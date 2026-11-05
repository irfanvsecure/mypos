<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $topic = $request->query('topic');
        $topic = array_key_exists((string) $topic, Post::topics()) ? $topic : null;

        $posts = Post::published()
            ->when($topic, fn ($q) => $q->where('topic', $topic))
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        // A category's own SEO title / description (set through the MCP tools) replaces the generated ones.
        $seo = $topic ? \App\Models\Category::where('slug', $topic)->first()?->seo : null;

        return view('blog.index', [
            'posts' => $posts, 'topic' => $topic,
            'listTitle' => $seo?->title, 'listDescription' => $seo?->description, 'listRobots' => $seo?->robots,
        ]);
    }

    /** /tag/{slug}: published posts with this tag. */
    public function tag(string $slug)
    {
        $tag = \App\Models\Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->published()->orderByDesc('published_at')->paginate(12)->withQueryString();

        return view('blog.index', [
            'posts' => $posts, 'topic' => null, 'tag' => $tag,
            'listTitle' => $tag->name . ' — Blog — myPOS',
            'listCanonical' => url('/tag/' . $tag->slug),
        ]);
    }

    public function show(Post $post)
    {
        [$content, $toc] = $post->contentWithToc();
        $content = \App\Site\ImageAttributes::apply($content, lazyAfterFirst: true);

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw('topic = ? desc', [$post->topic])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'content', 'toc', 'related'));
    }
}
