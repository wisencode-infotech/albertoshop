<div class="w-full pt-4 pb-20 lg:py-6 px-4 xl:px-0">

    @if(count($products) == 0)

        <div class="flex flex-col items-center w-7/12 mx-auto">
            <div class="w-full h-full flex items-center justify-center">
                <img alt="{{ __trans('Sorry, No Product Found :(') }}" loading="lazy" width="200" height="153" decoding="async" data-nimg="1" class="object-contain" src="{{ asset('assets/frontend/img/no-result.png') }}" style="color: transparent;">
            </div>
            <h3 class="w-full text-center text-xl font-semibold text-body my-7">{{ __trans('Sorry, No product found :(') }}</h3>
        </div>

    @else

        <!-- Loading Skeleton -->
        <div wire:loading wire:target="setCategory" class="grid grid-cols-4 gap-4">
           @include('livewire.skeleton-loader', [
                'skeletons' => range(1, 15) // Pass the skeleton count to the view
            ])
        </div>

        <div wire:loading.delay class="opacity-50 w-full"> 
            @include('livewire.skeleton-loader', [
                'skeletons' => range(1, 15) // Pass the skeleton count to the view
            ])
        </div>

        
        <div wire:loading.remove wire:target="setCategory" class="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-3">
            @foreach ($products as $product)
                <article
                    class="product-card cart-type-helium h-full overflow-hidden rounded border border-border-200 bg-light transition-shadow duration-200 hover:shadow-sm">
                    <div class="cursor-pointer relative flex h-48 w-auto items-center justify-center sm:h-64">
                        
                        <span class="sr-only">{{ __trans('Product') }} {{ __trans('Image') }}</span>

                        <img alt="{{ $product->title }}" loading="lazy" decoding="async" data-nimg="fill"
                            class="block object-contain product-image"
                            style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent"
                            wire:navigate href="{{ route('frontend.product-detail', ['product_slug' => $product->slug]) }}"
                            sizes="(max-width: 768px) 100vw" src="{{ $product->display_image_url }}">

                        <div class="absolute top-0 left-0 py-1 px-2">
                            @livewire('wishlist-button', ['product_id' => $product->id, key(uniqid())])
                        </div>

                    </div>
                    <header class="relative p-3 md:p-5 md:py-6">
                        <h3 role="button" wire:navigate href="{{ route('frontend.product-detail', ['product_slug' => $product->slug]) }}" class="font-semibold truncate text-heading">
                            {{ $product->name }}
                            @if ($product->variation_names->count() > 0)
                                ({{ \Str::limit($product->variation_names->implode(', '), 30) }})
                            @endif
                        </h3>

                        <span class="font-semibold text-muted text-sm truncate">{{ $product->category->name }}</span>

                        <p class="text-xs text-muted pr-9 min-h-[32px] mt-2">{{ \Str::limit($product->short_description, 70) }}</p>
                        <div class="relative flex items-center justify-between mt-7 min-h-6 md:mt-8">

                            <div class="flex overflow-hidden order-5 sm:order-4 w-9 sm:w-24 h-24 sm:h-10 bg-accent text-light rounded-full flex-col-reverse sm:flex-row absolute sm:relative bottom-0 sm:bottom-auto ltr:right-0 rtl:left-0 ltr:sm:right-auto ltr:sm:left-auto">
                                
                                <livewire:quantity-selector :product_id="$product->id" :key="'quantity-selector-' . uniqid()" />

                                @livewire('product-stock', ['product_id' => $product->id, 'layout' => 'product-list'], key('product-stock-' . uniqid()))
                            </div>

                            <div class="relative">
                                <span class="text-sm font-semibold text-accent md:text-base">
                                    @livewire('product-price', ['product_id' => $product->id], key('product-price-' . uniqid()))
                                </span>
                            </div>

                            @if ($product->variations()->count() > 0)
                                <div class="flex">
                                    @livewire('product-variation', ['product_id' => $product->id, 'layout' => 'products-list'], key('product-variation-' . uniqid()))
                                </div>
                            @endif
                        </div>

                    </header>
                </article>
            @endforeach
        </div>

        @if ($products->hasMorePages())
            <div class="flex justify-center mt-8 mb-4 sm:mb-6 lg:mb-2 lg:mt-12">
                <!-- Default Button Text -->
                <button wire:click="loadMore" wire:loading.attr="disabled"  data-variant="normal"
                    class="px-5 py-3 bg-accent text-light rounded hover:bg-accent-hover transition">
                    <span wire:loading.remove wire:target="loadMore">{{ __trans('Load More') }}</span>
                    <span wire:loading wire:target="loadMore">{{ __trans('Loading...') }}</span>
                </button>
            </div>
        @endif

        
    @endif
</div>

