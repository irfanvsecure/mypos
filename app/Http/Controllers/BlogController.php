<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $topic = $request->query('topic');
        $topic = array_key_exists($topic, Post::TOPICS) ? $topic : null;

        $posts = Post::published()
            ->when($topic, fn ($q) => $q->where('topic', $topic))
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('blog.index', compact('posts', 'topic'));
    }

    public function show(Post $post)
    {
        [$content, $toc] = $post->contentWithToc();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->orderByRaw('topic = ? desc', [$post->topic])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'content', 'toc', 'related'));
    }
}
