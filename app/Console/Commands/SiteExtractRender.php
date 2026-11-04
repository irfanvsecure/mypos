<?php

namespace App\Console\Commands;

use App\Site\Extract\Recorder;
use App\Site\Extract\SourceMarker;
use App\Site\Tokens;
use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

/**
 * Internal step of `site:extract` (run in its own process per page): renders a marked copy of one Blade page
 * through the real HTTP stack, with sentinel values for everything request- or settings-dependent,
 * and prints what was captured as JSON.
 */
class SiteExtractRender extends Command
{
    protected $signature = 'site:extract-render {path : URL path, empty for the home page}';

    protected $description = 'Internal: render one Blade page for site:extract and print the capture as JSON';

    protected $hidden = true;

    public function handle(): int
    {
        $path = trim((string) $this->argument('path'), '/');
        $view = $path === '' ? 'home' : 'pages/' . $path;
        $file = resource_path("views/$view.blade.php");
        if (! is_file($file)) {
            $this->error("No Blade file for /$path");
            return self::FAILURE;
        }

        $dir = storage_path('framework/extract-views');
        File::ensureDirectoryExists(dirname("$dir/$view.blade.php"));
        File::put("$dir/$view.blade.php", SourceMarker::mark(File::get($file)));
        View::getFinder()->prependLocation($dir);
        View::getFinder()->flush();

        config(['site.__extract' => true, 'site.url' => Tokens::SENTINELS['site_url']]);
        foreach (['phone', 'phone_raw', 'email', 'address', 'hours', 'register_url', 'whatsapp'] as $k) {
            config(["site.$k" => Tokens::SENTINELS[$k]]);
        }
        URL::forceRootUrl(Tokens::SENTINELS['base']);

        Blade::directive('extractOpen', fn ($e) => "<?php \App\Site\Extract\Recorder::open($e); ?>");
        Blade::directive('extractClose', fn () => '<?php \App\Site\Extract\Recorder::close(); ?>');
        View::composer('components.*', fn ($v) => Recorder::compose($v));
        View::composer('layouts.app', fn ($v) => Recorder::composeLayout($v));

        $response = app(Kernel::class)->handle(Request::create('/' . $path, 'GET'));

        $this->output->write(json_encode([
            'status' => $response->getStatusCode(),
            'error' => $response->getStatusCode() >= 400 ? mb_substr(strip_tags((string) $response->getContent()), 0, 2000) : null,
            'layout' => Recorder::$layout,
            'captured' => Recorder::$captured,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE));

        return self::SUCCESS;
    }
}
