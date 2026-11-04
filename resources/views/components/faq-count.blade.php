@props(['groups' => []])
{{ \App\Models\Faq::whereIn('faq_group', (array) $groups)->where('is_visible', true)->count() }}