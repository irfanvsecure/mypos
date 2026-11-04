<?php

namespace App\Mcp\Tools;

use App\Mcp\P;
use App\Mcp\SiteTool;
use App\Mcp\Support;
use App\Mcp\ToolError;
use App\Models\Category;
use App\Models\Post;
use App\Models\Redirect;
use App\Models\Tag;
use App\Site\HtmlSanitizer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/** Blog posts, categories and tags. */
class BlogTools
{
    public static function tools(): array
    {
        $slug = P::str('Post slug (its URL path, e.g. "fbr-pos-integration-retail-stores-pakistan").')->req();
        $postFields = [
            'title' => P::str('Post title (the H1).', 'max:250'),
            'content' => P::str('Post body HTML (use <h2>/<h3> for headings; no <h1>).'),
            'excerpt' => P::str('Short summary for the blog list (plain text).', 'max:1000'),
            'category' => P::str('Category slug (see list_categories).'),
            'tags' => P::arr('Tag names or slugs (missing tags are created).', P::str('Tag')),
            'featured_image' => P::str('Image path, e.g. /uploads/2026/11/post.webp.'),
            'meta_title' => P::str('SEO title (default: the title).', 'max:300'),
            'meta_description' => P::str('Meta description (default: the excerpt).', 'max:500'),
        ];

        return [
            new SiteTool('list_blogs', 'List blog posts with status (published / scheduled / draft), category, tags and dates.', [
                'status' => P::str('Filter.')->enum(['published', 'scheduled', 'draft', 'all']),
                'category' => P::str('Category slug.'),
                'search' => P::str('Text in the title or slug.'),
                'include_trashed' => P::bool('Also posts in the trash.'),
            ], function (array $a) {
                $q = Post::with('tags')->orderByDesc('published_at');
                if (! empty($a['include_trashed'])) {
                    $q->withTrashed();
                }
                match ($a['status'] ?? 'all') {
                    'published' => $q->published(),
                    'scheduled' => $q->where('published_at', '>', now()),
                    'draft' => $q->whereNull('published_at'),
                    default => null,
                };
                if (! empty($a['category'])) {
                    $q->where('topic', $a['category']);
                }
                if (! empty($a['search'])) {
                    $q->where(fn ($w) => $w->where('title', 'like', "%{$a['search']}%")->orWhere('slug', 'like', "%{$a['search']}%"));
                }

                return $q->get()->map(fn (Post $p) => self::summary($p))->all();
            }, readOnly: true),

            new SiteTool('get_blog', 'Get one blog post with its full HTML content, SEO fields, category and tags.', ['slug' => $slug], function (array $a) {
                $p = Support::post($a['slug'], true);

                return self::summary($p) + ['content' => $p->content, 'excerpt' => $p->excerpt, 'featured_image' => $p->featured_image,
                    'meta_title' => $p->meta_title, 'meta_description' => $p->meta_description, 'reading_minutes' => $p->reading_minutes];
            }, readOnly: true),

            new SiteTool('create_blog', 'Write a new blog post. Saved as a draft unless status=published (or publish_at schedules it).', ['slug' => P::str('URL slug (default: from the title).')] + array_merge($postFields, [
                'title' => $postFields['title']->req(),
                'content' => $postFields['content']->req(),
                'status' => P::str('draft (default) or published.')->enum(['draft', 'published']),
                'publish_at' => P::str('Schedule: ISO date-time in the future, e.g. 2026-12-01T09:00:00+05:00.', 'date'),
            ]), function (array $a) {
                $slug = Str::slug($a['slug'] ?? $a['title']);
                Support::assertFreePath($slug);
                if (str_contains($slug, '/')) {
                    throw new ToolError('Post slugs cannot contain "/".');
                }
                $post = DB::transaction(function () use ($a, $slug) {
                    $post = new Post(['slug' => $slug, 'content' => '']);
                    self::fill($post, $a);
                    $post->published_at = isset($a['publish_at']) ? Carbon::parse($a['publish_at']) : (($a['status'] ?? 'draft') === 'published' ? now() : null);
                    $post->save();
                    if (isset($a['tags'])) {
                        $post->tags()->sync(self::tagIds($a['tags']));
                    }

                    return $post;
                });
                Support::log('post.create', $post, "Created blog post /$slug", null, self::summary($post));

                return ['created' => self::summary($post->fresh('tags')), 'warnings' => self::warnings($post), 'cache' => Support::changed([$slug, 'blogs'])];
            }),

            new SiteTool('update_blog', 'Edit a blog post. Changing the slug of a published post adds a 301 from the old URL.', ['slug' => $slug, 'new_slug' => P::str('New URL slug.'),
                'expected_updated_at' => P::str('updated_at you read (refused if the post changed since).')] + $postFields, function (array $a) {
                $post = Support::post($a['slug']);
                Support::assertStamp($post, $a['expected_updated_at'] ?? null);
                $before = self::summary($post) + ['content_length' => strlen($post->content)];
                $redirect = null;
                DB::transaction(function () use ($post, $a, &$redirect) {
                    if (! empty($a['new_slug']) && Str::slug($a['new_slug']) !== $post->slug) {
                        $new = Str::slug($a['new_slug']);
                        Support::assertFreePath($new, $post);
                        if ($post->published_at && $post->published_at <= now()) {
                            Redirect::withTrashed()->updateOrCreate(['from_path' => $post->slug], ['to_url' => '/' . $new, 'status_code' => 301, 'is_auto' => true, 'deleted_at' => null]);
                            Redirect::where('to_url', '/' . $post->slug)->update(['to_url' => '/' . $new]);
                            $redirect = "/{$post->slug} → /$new (301)";
                        }
                        $post->slug = $new;
                    }
                    self::fill($post, $a);
                    $post->save();
                    if (isset($a['tags'])) {
                        $post->tags()->sync(self::tagIds($a['tags']));
                    }
                });
                Support::log('post.update', $post, "Updated blog post /{$post->slug}", $before, self::summary($post->fresh('tags')));

                return ['updated' => self::summary($post->fresh('tags')), 'redirect_added' => $redirect, 'warnings' => self::warnings($post),
                    'cache' => Support::changed([$post->slug, 'blogs'])];
            }),

            new SiteTool('delete_blog', 'Move a blog post to the trash (its URL then answers 404; restore with restore_item).', ['slug' => $slug], function (array $a) {
                $post = Support::post($a['slug']);
                $post->delete();
                Support::log('post.delete', $post, "Moved blog post /{$post->slug} to the trash");

                return ['deleted' => $post->slug, 'restore_with' => ['tool' => 'restore_item', 'type' => 'post', 'id' => $post->id], 'cache' => Support::changed([$post->slug, 'blogs'])];
            }, destructive: true),

            new SiteTool('publish_blog', 'Publish a draft or scheduled post now.', ['slug' => $slug], fn (array $a) => self::setPublished($a['slug'], now(), 'published')),
            new SiteTool('unpublish_blog', 'Take a post offline (back to draft). Its URL answers 404 until published again.', ['slug' => $slug], fn (array $a) => self::setPublished($a['slug'], null, 'unpublished')),
            new SiteTool('schedule_blog', 'Schedule a post to go live at a future date-time.', [
                'slug' => $slug, 'publish_at' => P::str('ISO date-time in the future, e.g. 2026-12-01T09:00:00+05:00.', 'date')->req(),
            ], function (array $a) {
                $at = Carbon::parse($a['publish_at']);
                if ($at->isPast()) {
                    throw new ToolError('publish_at must be in the future (use publish_blog to publish now).');
                }

                return self::setPublished($a['slug'], $at, 'scheduled');
            }),

            new SiteTool('list_stale_posts', 'Published posts not updated for a while (candidates for a refresh).', [
                'months' => P::int('Not updated for at least this many months (default 12).', ['min:1', 'max:120']),
            ], fn (array $a) => Post::published()->where('updated_at', '<', now()->subMonths($a['months'] ?? 12))->orderBy('updated_at')->get()
                ->map(fn ($p) => self::summary($p) + ['months_since_update' => (int) $p->updated_at->diffInMonths(now())])->all(), readOnly: true),

            // ---------------- categories ----------------
            new SiteTool('list_categories', 'List blog categories (the blog filter bar) with post counts.', [], fn () => Category::withCount('posts')->orderBy('sort_order')->get()
                ->map(fn ($c) => $c->only(['id', 'slug', 'name', 'description', 'sort_order']) + ['posts' => $c->posts_count, 'url' => url('/blogs?topic=' . $c->slug)])->all(), readOnly: true),

            new SiteTool('create_category', 'Add a blog category.', [
                'name' => P::str('Name shown in the filter bar.', 'max:120')->req(),
                'slug' => P::str('Slug (default: from the name).', ['max:80']),
                'description' => P::str('Description (plain text).', 'max:1000'),
                'sort_order' => P::int('Position in the filter bar (default last).'),
            ], function (array $a) {
                $slug = Str::slug($a['slug'] ?? $a['name']);
                if (Category::withTrashed()->where('slug', $slug)->exists()) {
                    throw new ToolError("Category \"$slug\" already exists (maybe in the trash).");
                }
                $c = Category::create(['slug' => $slug, 'name' => Support::text($a['name'], 'name'), 'description' => Support::text($a['description'] ?? null, 'description'),
                    'sort_order' => $a['sort_order'] ?? ((int) Category::max('sort_order') + 1)]);
                Support::log('category.create', $c, "Created category $slug", null, $c->toArray());

                return ['created' => $c->only(['id', 'slug', 'name']), 'cache' => Support::changed(['blogs'])];
            }),

            new SiteTool('update_category', 'Rename a category, change its slug (posts move with it), description or position.', [
                'slug' => P::str('Current category slug.')->req(),
                'name' => P::str('New name.', 'max:120'), 'new_slug' => P::str('New slug.', 'max:80'),
                'description' => P::str('Description.', 'max:1000'), 'sort_order' => P::int('Position.'),
            ], function (array $a) {
                $c = Category::where('slug', $a['slug'])->first() ?? throw new ToolError("No category \"{$a['slug']}\".");
                $before = $c->toArray();
                DB::transaction(function () use ($c, $a) {
                    if (! empty($a['new_slug']) && Str::slug($a['new_slug']) !== $c->slug) {
                        $new = Str::slug($a['new_slug']);
                        if (Category::withTrashed()->where('slug', $new)->exists()) {
                            throw new ToolError("Category \"$new\" already exists.");
                        }
                        Post::withTrashed()->where('topic', $c->slug)->update(['topic' => $new]);
                        $c->slug = $new;
                    }
                    if (isset($a['name'])) {
                        $c->name = Support::text($a['name'], 'name');
                    }
                    if (array_key_exists('description', $a)) {
                        $c->description = Support::text($a['description'], 'description');
                    }
                    if (isset($a['sort_order'])) {
                        $c->sort_order = $a['sort_order'];
                    }
                    $c->save();
                });
                Support::log('category.update', $c, "Updated category {$c->slug}", $before, $c->toArray());

                return ['updated' => $c->only(['id', 'slug', 'name']), 'cache' => Support::changed(['blogs'])];
            }),

            new SiteTool('delete_category', 'Move a category to the trash. If posts use it, give move_posts_to (another category slug).', [
                'slug' => P::str('Category slug.')->req(), 'move_posts_to' => P::str('Category slug for its posts.'),
            ], function (array $a) {
                $c = Category::where('slug', $a['slug'])->first() ?? throw new ToolError("No category \"{$a['slug']}\".");
                $count = Post::where('topic', $c->slug)->count();
                if ($count && empty($a['move_posts_to'])) {
                    throw new ToolError("$count posts use this category; give move_posts_to.");
                }
                if ($count) {
                    Category::where('slug', $a['move_posts_to'])->exists() || throw new ToolError("No category \"{$a['move_posts_to']}\".");
                    Post::where('topic', $c->slug)->update(['topic' => $a['move_posts_to']]);
                }
                $c->delete();
                Support::log('category.delete', $c, "Moved category {$c->slug} to the trash ($count posts moved)");

                return ['deleted' => $c->slug, 'posts_moved' => $count, 'cache' => Support::changed(['blogs'])];
            }, destructive: true),

            // ---------------- tags ----------------
            new SiteTool('list_tags', 'List blog tags with post counts and their /tag/ URLs.', [], fn () => Tag::withCount('posts')->orderBy('name')->get()
                ->map(fn ($t) => $t->only(['id', 'slug', 'name']) + ['posts' => $t->posts_count, 'url' => url('/tag/' . $t->slug)])->all(), readOnly: true),

            new SiteTool('create_tag', 'Add a blog tag.', ['name' => P::str('Tag name.', 'max:80')->req(), 'slug' => P::str('Slug (default: from the name).')], function (array $a) {
                $slug = Str::slug($a['slug'] ?? $a['name']);
                if (Tag::withTrashed()->where('slug', $slug)->exists()) {
                    throw new ToolError("Tag \"$slug\" already exists.");
                }
                $t = Tag::create(['slug' => $slug, 'name' => Support::text($a['name'], 'name')]);
                Support::log('tag.create', $t, "Created tag $slug");

                return ['created' => $t->only(['id', 'slug', 'name'])];
            }),

            new SiteTool('update_tag', 'Rename a tag or change its slug (adds a 301 from the old /tag/ URL).', [
                'slug' => P::str('Current tag slug.')->req(), 'name' => P::str('New name.', 'max:80'), 'new_slug' => P::str('New slug.'),
            ], function (array $a) {
                $t = Tag::where('slug', $a['slug'])->first() ?? throw new ToolError("No tag \"{$a['slug']}\".");
                $before = $t->toArray();
                if (! empty($a['new_slug']) && Str::slug($a['new_slug']) !== $t->slug) {
                    $new = Str::slug($a['new_slug']);
                    if (Tag::withTrashed()->where('slug', $new)->exists()) {
                        throw new ToolError("Tag \"$new\" already exists; use merge_tags.");
                    }
                    self::tagRedirect($t->slug, $new);
                    $t->slug = $new;
                }
                if (isset($a['name'])) {
                    $t->name = Support::text($a['name'], 'name');
                }
                $t->save();
                Support::log('tag.update', $t, "Updated tag {$t->slug}", $before, $t->toArray());

                return ['updated' => $t->only(['id', 'slug', 'name']), 'cache' => Support::changed(['tag/' . $before['slug'], 'tag/' . $t->slug])];
            }),

            new SiteTool('delete_tag', 'Move a tag to the trash (posts keep their other tags).', ['slug' => P::str('Tag slug.')->req()], function (array $a) {
                $t = Tag::where('slug', $a['slug'])->first() ?? throw new ToolError("No tag \"{$a['slug']}\".");
                $t->delete();
                Support::log('tag.delete', $t, "Moved tag {$t->slug} to the trash");

                return ['deleted' => $t->slug, 'cache' => Support::changed(['tag/' . $t->slug])];
            }, destructive: true),

            new SiteTool('merge_tags', 'Merge one tag into another: its posts get the target tag, the old tag goes to the trash, and /tag/<from> redirects (301) to /tag/<into>.', [
                'from' => P::str('Tag slug to merge away.')->req(), 'into' => P::str('Tag slug to keep.')->req(),
            ], function (array $a) {
                $from = Tag::where('slug', $a['from'])->first() ?? throw new ToolError("No tag \"{$a['from']}\".");
                $into = Tag::where('slug', $a['into'])->first() ?? throw new ToolError("No tag \"{$a['into']}\".");
                if ($from->is($into)) {
                    throw new ToolError('from and into are the same tag.');
                }
                $moved = DB::transaction(function () use ($from, $into) {
                    $ids = $from->posts()->withTrashed()->pluck('posts.id')->all();
                    $into->posts()->syncWithoutDetaching($ids);
                    $from->posts()->detach();
                    $from->delete();
                    self::tagRedirect($from->slug, $into->slug);

                    return count($ids);
                });
                Support::log('tag.merge', $into, "Merged tag {$from->slug} into {$into->slug}", ['from' => $from->slug], ['posts_moved' => $moved]);

                return ['merged' => $from->slug, 'into' => $into->slug, 'posts_moved' => $moved, 'redirect' => "/tag/{$from->slug} → /tag/{$into->slug} (301)",
                    'cache' => Support::changed(['tag/' . $from->slug, 'tag/' . $into->slug])];
            }),

            new SiteTool('set_blog_taxonomies', 'Set a post\'s category and/or tags (tags replace the current list; missing tags are created).', [
                'slug' => $slug, 'category' => P::str('Category slug.'), 'tags' => P::arr('Tag names or slugs.', P::str('Tag')),
            ], function (array $a) {
                $post = Support::post($a['slug']);
                $before = self::summary($post);
                if (isset($a['category'])) {
                    Category::where('slug', $a['category'])->exists() || throw new ToolError("No category \"{$a['category']}\". See list_categories.");
                    $post->topic = $a['category'];
                    $post->save();
                }
                if (isset($a['tags'])) {
                    $post->tags()->sync(self::tagIds($a['tags']));
                    $post->touch();
                }
                Support::log('post.taxonomies', $post, "Set category/tags of /{$post->slug}", $before, self::summary($post->fresh('tags')));

                return ['post' => self::summary($post->fresh('tags')), 'cache' => Support::changed([$post->slug, 'blogs'])];
            }),
        ];
    }

    public static function summary(Post $p): array
    {
        $status = $p->trashed() ? 'trashed' : ($p->published_at === null ? 'draft' : ($p->published_at->isFuture() ? 'scheduled' : 'published'));

        return ['id' => $p->id, 'slug' => $p->slug, 'url' => url('/' . $p->slug), 'title' => $p->title, 'status' => $status,
            'publish_at' => $p->published_at?->toIso8601String(), 'category' => $p->topic, 'tags' => $p->relationLoaded('tags') ? $p->tags->pluck('slug')->all() : $p->tags()->pluck('slug')->all(),
            'updated_at' => Support::stamp($p)];
    }

    private static function fill(Post $post, array $a): void
    {
        foreach (['title', 'excerpt', 'meta_title', 'meta_description'] as $f) {
            if (array_key_exists($f, $a)) {
                $post->$f = Support::text($a[$f], $f);
            }
        }
        if (isset($a['content'])) {
            if (preg_match('/<h1\b/i', $a['content'])) {
                throw new ToolError('Post content must not contain <h1>: the title is the H1. Use <h2> and <h3>.');
            }
            $post->content = (new HtmlSanitizer())->clean($a['content'])['html'];
            $post->reading_minutes = max(1, (int) ceil(str_word_count(strip_tags($post->content)) / 200));
        }
        if (array_key_exists('category', $a)) {
            if ($a['category'] !== null && ! Category::where('slug', $a['category'])->exists()) {
                throw new ToolError("No category \"{$a['category']}\". See list_categories.");
            }
            $post->topic = $a['category'];
        }
        if (array_key_exists('featured_image', $a)) {
            $img = $a['featured_image'] ? '/' . ltrim($a['featured_image'], '/') : null;
            if ($img && (str_contains($img, '..') || ! is_file(public_path(ltrim($img, '/'))))) {
                throw new ToolError("No image at $img. Upload it with upload_image first.");
            }
            $post->featured_image = $img;
        }
    }

    private static function tagIds(array $tags): array
    {
        return collect($tags)->filter()->map(function ($t) {
            $slug = Str::slug($t);

            return (Tag::where('slug', $slug)->first() ?? Tag::create(['slug' => $slug, 'name' => trim(strip_tags($t))]))->id;
        })->unique()->values()->all();
    }

    private static function tagRedirect(string $from, string $to): void
    {
        Redirect::withTrashed()->updateOrCreate(['from_path' => 'tag/' . $from], ['to_url' => '/tag/' . $to, 'status_code' => 301, 'is_auto' => true, 'deleted_at' => null]);
        Redirect::where('to_url', '/tag/' . $from)->update(['to_url' => '/tag/' . $to]);
    }

    private static function setPublished(string $slug, ?Carbon $at, string $what): array
    {
        $post = Support::post($slug);
        $before = $post->published_at?->toIso8601String();
        $post->published_at = $at;
        $post->save();
        Support::log('post.' . $what, $post, ucfirst($what) . " /{$post->slug}", ['published_at' => $before], ['published_at' => $at?->toIso8601String()]);

        return ['post' => self::summary($post), 'cache' => Support::changed([$post->slug, 'blogs'])];
    }

    private static function warnings(Post $p): array
    {
        $w = [];
        if (! $p->excerpt) {
            $w[] = 'No excerpt: the blog list and meta description fall back to nothing useful.';
        }
        if (! $p->featured_image) {
            $w[] = 'No featured image.';
        }
        if ($p->topic === null) {
            $w[] = 'No category.';
        }

        return $w;
    }
}
