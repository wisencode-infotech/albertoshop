@if ($meta = view()->yieldContent('meta:keywords')) 
    <meta name="keywords" content="{{ $meta }}">
@else
    <meta name="keywords" content="{{ $meta['keywords'] ?? config('app.name') }}">
@endif
@if ($meta = view()->yieldContent('meta:description')) 
    <meta name="description" content="{{ $meta }}">
@else
    <meta name="description" content="{{ $meta['description'] ?? config('app.name') }}">
@endif
@if ($meta = view()->yieldContent('meta:og:title')) 
    <meta property="og:title" content="{{ $meta }}">
@else
    <meta property="og:title" content="{{ $meta['og:title'] ?? config('app.name') }}">
@endif
@if ($meta = view()->yieldContent('meta:og:description')) 
    <meta property="og:description" content="{{ $meta }}">
@else
    <meta property="og:description" content="{{ $meta['og:description'] ?? config('app.name') }}">
@endif
@if ($meta = view()->yieldContent('meta:og:image')) 
    <meta property="og:image" content="{{ $meta }}">
@else
    <meta property="og:image" content="{{ $meta['og:image'] ?? asset(__setting('header_logo')) }}">
@endif
@if ($meta = view()->yieldContent('meta:og:url')) 
    <meta property="og:url" content="{{ $meta }}">
@else
    <meta property="og:url" content="{{ $meta['canonical_url'] ?? url()->current() }}">
@endif