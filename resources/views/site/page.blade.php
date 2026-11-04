@extends('layouts.app')
@php
    /** @var \App\Models\Page $page */
    $seo = $page->seo;
    $raw = fn ($v) => \App\Site\Tokens::resolveRaw((string) $v);
@endphp
@if ($page->page_key !== null)@section('page', $page->page_key)@endif
@foreach (['title', 'description', 'keywords', 'canonical', 'og_image', 'og_type', 'robots', 'og_title', 'og_description', 'twitter_card', 'twitter_title', 'twitter_description', 'twitter_image'] as $field)
@if ($seo && $seo->$field !== null)@section($field, $raw($seo->$field))@endif
@endforeach
@if (isset($page->options['pixel_category']))@section('pixel_category', $page->options['pixel_category'])@endif
@if ($page->schemaBlocks->where('is_active', true)->isNotEmpty())
@push('head')
@foreach ($page->schemaBlocks->where('is_active', true) as $block)
<script type="application/ld+json">{!! $raw($block->json) !!}</script>
@endforeach
@endpush
@endif
@section('content'){!! app(\App\Site\SectionRenderer::class)->page($page) !!}@endsection
