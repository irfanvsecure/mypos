<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('site:nav-sprite', function () {
    file_put_contents(public_path(\App\Site\NavSprite::FILE), \App\Site\NavSprite::build());
    $this->info('Wrote public/' . \App\Site\NavSprite::FILE . ' (' . count(config('site.nav_icons')) . ' icons)');
})->purpose('Rebuild the header icon sprite from config(site.nav_icons)');
