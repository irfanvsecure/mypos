<?php

namespace App\Site\Extract;

use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Used only by `site:extract`: while a marked copy of a page renders, records which component each
 * <x-tag> rendered and the exact data it received, and wraps its output in <!--§Ek--> … <!--§/Ek--> markers.
 */
class Recorder
{
    private static int $next = 0;

    /** @var array<int, array{0:int,1:string}> */
    private static array $stack = [];

    /** @var array<int, array{component:string, attributes:array, slot:?string}> */
    public static array $captured = [];

    /** @var array<string, mixed> */
    public static array $layout = [];

    public static function open(string $component): void
    {
        $key = ++self::$next;
        self::$stack[] = [$key, $component];
        echo '<!--§E' . $key . '-->';
    }

    public static function close(): void
    {
        [$key] = array_pop(self::$stack);
        echo '<!--§/E' . $key . '-->';
    }

    /** View composer for components.*: the first component view rendered after open() is the tag's own. */
    public static function compose(View $view): void
    {
        $top = end(self::$stack);
        if (! $top) {
            return;
        }
        [$key, $component] = $top;
        if (isset(self::$captured[$key]) || $view->name() !== 'components.' . $component) {
            return;
        }

        $data = $view->getData();
        $bag = $data['attributes'] ?? null;
        $attributes = [];
        foreach ($bag ? $bag->getAttributes() : [] as $name => $value) {
            // Props arrive unescaped as view data under their camelCase name; prefer that raw value.
            $camel = Str::camel($name);
            $attributes[$name] = array_key_exists($camel, $data) && $camel !== 'attributes' ? $data[$camel] : $value;
        }
        self::assertPlain($attributes, "component $component");

        $slot = isset($data['slot']) ? (string) $data['slot']->toHtml() : '';

        self::$captured[$key] = ['component' => $component, 'attributes' => $attributes, 'slot' => $slot === '' ? null : $slot];
    }

    /** View composer for the layout: by now the page has filled every section and push stack. */
    public static function composeLayout(View $view): void
    {
        $f = $view->getFactory();
        foreach (['page', 'title', 'description', 'keywords', 'canonical', 'og_image', 'og_type', 'robots', 'pixel_category'] as $name) {
            self::$layout['yields'][$name] = $f->hasSection($name) ? $f->yieldContent($name) : null;
        }
        self::$layout['content'] = $f->yieldContent('content');
        self::$layout['head'] = $f->yieldPushContent('head');
        self::$layout['scripts'] = $f->yieldPushContent('scripts');
    }

    private static function assertPlain(mixed $v, string $where): void
    {
        if (is_array($v)) {
            foreach ($v as $x) {
                self::assertPlain($x, $where);
            }
        } elseif (! is_null($v) && ! is_scalar($v)) {
            throw new \RuntimeException("$where received a " . get_debug_type($v) . ' attribute, which cannot be stored as data.');
        }
    }
}
