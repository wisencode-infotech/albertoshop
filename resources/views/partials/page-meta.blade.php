@if (!empty($meta))
   @if (!empty($meta['keywords'])) 
       @section('meta:keywords', $meta['keywords']) 
   @endif

   @if (!empty($meta['description'])) 
       @section('meta:description', $meta['description']) 
   @endif

   @if (!empty($meta['og:title'])) 
       @section('meta:og:title', $meta['og:title']) 
   @endif

   @if (!empty($meta['og:description'])) 
       @section('meta:og:description', $meta['og:description']) 
   @endif

   @if (!empty($meta['og:image'])) 
       @section('meta:og:image', $meta['og:image']) 
   @endif

   @if (!empty($meta['canonical_url'])) 
       @section('meta:og:url', $meta['canonical_url']) 
   @endif
@endif