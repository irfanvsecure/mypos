<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::post('/enquiry', [EnquiryController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('enquiry.store');

Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/portfolio-item/{slug}', [ClientController::class, 'show'])->name('clients.show');

// Old WordPress sitemap URLs all point at the single generated sitemap.
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::redirect('/sitemap_index.xml', '/sitemap.xml', 301);
Route::redirect('/page-sitemap.xml', '/sitemap.xml', 301);
Route::redirect('/post-sitemap.xml', '/sitemap.xml', 301);
Route::redirect('/portfolio-sitemap.xml', '/sitemap.xml', 301);
Route::redirect('/category-sitemap.xml', '/sitemap.xml', 301);

// Migration safety net: an /uploads file that hasn't been copied locally yet is served from the old WordPress
// server. Apache serves files that exist directly, so this only runs for missing ones. Set
// SITE_REMOTE_UPLOADS=false in .env once every image is local (or the old server is switched off).
Route::get('/uploads/{path}', function (string $path) {
    abort_unless(config('site.remote_uploads') && !str_contains($path, '..'), 404);
    return redirect('https://mypos.pk/wp-content/uploads/' . $path, 302);
})->where('path', '.*');

// Old WordPress media URLs (indexed by Google Images, linked from other sites) → same file under /uploads.
Route::get('/wp-content/uploads/{path}', fn (string $path) => redirect('/uploads/' . $path, 301))->where('path', '.*');

// Every other migrated WordPress URL: static page view, blog post, redirect or 410.
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '.*')
    ->name('page');
