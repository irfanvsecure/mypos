@extends('layouts.app')

@section('page', 'blogs')
@section('title', ($topic ? \App\Models\Post::TOPICS[$topic] . ' — ' : '') . 'Blog: POS, FBR Integration & Business Guides — myPOS' . ($posts->currentPage() > 1 ? ' (Page ' . $posts->currentPage() . ')' : ''))
@section('description', 'Practical guides on POS software, FBR & PRA integration, digital invoicing, and running retail, restaurant and salon businesses in Pakistan — from the myPOS team.')
@if ($topic || $posts->currentPage() > 1)
@section('canonical', url('/blogs') . ($posts->currentPage() > 1 ? '?page=' . $posts->currentPage() : ''))
@endif

@section('content')
<x-page-header title="Blogs" crumb="Blog" eyebrow="MYPOS BLOG"
  lead="Guides on POS software, FBR &amp; PRA compliance and running a better retail, restaurant or salon business in Pakistan." />

<section>
  <div class="wrap">
    <nav class="filter-bar reveal" aria-label="Blog topics">
      <a href="{{ route('blog.index') }}" class="{{ $topic ? '' : 'active' }}">All articles</a>
      @foreach (\App\Models\Post::TOPICS as $key => $label)
        <a href="{{ route('blog.index', ['topic' => $key]) }}" class="{{ $topic === $key ? 'active' : '' }}">{{ $label }}</a>
      @endforeach
    </nav>

    <div class="post-grid">
      @forelse ($posts as $post)
        <article class="post-card reveal-scale">
          <a href="{{ $post->url }}" class="pc-img">
            @if ($post->featured_image)<img src="{{ asset(ltrim($post->featured_image, '/')) }}" alt="{{ $post->title }}" loading="lazy">@endif
          </a>
          <div class="pc-body">
            <div class="pc-tag">{{ strtoupper($post->topic_label) }}</div>
            <h3><a href="{{ $post->url }}">{{ $post->title }}</a></h3>
            <p>{{ $post->excerpt }}</p>
            <div class="pc-foot"><span>{{ $post->published_at?->format('M j, Y') }} · {{ $post->reading_minutes }} min read</span><b>Read →</b></div>
          </div>
        </article>
      @empty
        <p>No articles yet.</p>
      @endforelse
    </div>

    @if ($posts->hasPages())
      <nav class="pagination" aria-label="Pagination">
        @if ($posts->onFirstPage())<span class="disabled">←</span>@else<a href="{{ $posts->previousPageUrl() }}" rel="prev">←</a>@endif
        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $n => $u)
          @if ($n === $posts->currentPage())<span class="current">{{ $n }}</span>@else<a href="{{ $u }}">{{ $n }}</a>@endif
        @endforeach
        @if ($posts->hasMorePages())<a href="{{ $posts->nextPageUrl() }}" rel="next">→</a>@else<span class="disabled">→</span>@endif
      </nav>
    @endif
  </div>
</section>

<x-cta-band title="Need help choosing the right POS?" text="Talk to our team — we'll recommend the right setup for your business, including FBR &amp; PRA integration, and give you a free demo." />
@endsection
