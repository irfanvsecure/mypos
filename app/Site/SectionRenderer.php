<?php

namespace App\Site;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Support\Str;
use Illuminate\View\AnonymousComponent;

/**
 * Turns a page's sections into HTML. No Blade code is ever read from the database: "html" sections are plain
 * HTML with {{tokens}}, and components are only the ones that exist in resources/views/components, fed with
 * the stored attributes as data — exactly what a <x-name ...> tag in a Blade file does.
 */
class SectionRenderer
{
    /** When true, each section is wrapped in <!--§S:key--> … <!--§/S--> (used by the SEO / link analysis only). */
    public static bool $annotate = false;

    public function page(Page $page): string
    {
        $out = '';
        foreach ($page->sections as $section) {
            if ($section->is_visible) {
                $out .= self::$annotate
                    ? '<!--§S:' . $section->key . '-->' . $this->section($section) . '<!--§/S-->'
                    : $this->section($section);
            }
        }

        return $out . ($page->options['content_tail'] ?? '');
    }

    public function section(PageSection $s): string
    {
        $c = $s->content ?? [];
        $before = $c['before'] ?? '';

        return match ($s->type) {
            'html' => $before . $this->html($c['html'] ?? '', $c['embeds'] ?? []),
            'component' => $before . $this->component($s->component, $c['attributes'] ?? [], $c['slot'] ?? null),
            default => '',
        };
    }

    /** HTML with {{tokens}}; each {{embed:N}} becomes the rendered N-th embedded component. */
    public function html(string $html, array $embeds = []): string
    {
        $html = ImageAttributes::apply(Tokens::resolve($html));
        if (! $embeds) {
            return $html;
        }

        // Embeds render in document order, so anything they @push (e.g. structured data) keeps its order.
        return preg_replace_callback('/\{\{embed:(\d+)\}\}/', function ($m) use ($embeds) {
            $e = $embeds[(int) $m[1]] ?? null;

            return $e ? $this->component($e['component'], $e['attributes'] ?? [], $e['slot'] ?? null) : '';
        }, $html);
    }

    /**
     * Render resources/views/components/{name}.blade.php the same way Blade's compiled <x-name> tag does.
     *
     * @param array $attributes attribute name (as written in the tag) => value; strings may hold {{tokens}}
     * @param array|null $slot  {html, embeds} for the tag's inner content
     */
    public function component(string $name, array $attributes, ?array $slot = null): string
    {
        if (! self::componentExists($name)) {
            return '';
        }

        $attributes = Tokens::resolveDeep($attributes);
        $data = [];
        foreach ($attributes as $k => $v) {
            $data[Str::camel($k)] = $v;
        }

        $factory = view();
        $component = AnonymousComponent::resolve(['view' => 'components.' . $name, 'data' => $data]);
        $component->withName($name);
        if (! $component->shouldRender()) {
            return '';
        }

        $slotHtml = $slot ? $this->html($slot['html'] ?? '', $slot['embeds'] ?? []) : '';

        $factory->startComponent($component->resolveView(), $component->data());
        $component->withAttributes($attributes);
        echo $slotHtml;

        return $factory->renderComponent();
    }

    public static function componentExists(string $name): bool
    {
        return (bool) preg_match('/^[a-z0-9]+(?:[.-][a-z0-9]+)*$/', $name)
            && is_file(resource_path('views/components/' . str_replace('.', '/', $name) . '.blade.php'));
    }
}
