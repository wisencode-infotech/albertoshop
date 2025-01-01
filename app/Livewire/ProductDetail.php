<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductDetail extends Component
{
    public $product;

    public $meta;

    public function mount($product_slug)
    {
        // Use caching for product lookup if appropriate for performance
        $this->product = Cache::remember("product_{$product_slug}", 60, function () use ($product_slug) {
            return Product::authenticated()
                ->with(['category:id,name', 'images:id,product_id,image_path'])
                ->where('slug', $product_slug)
                ->first();
        });

        if (!$this->product)
            abort(404, "product_not_found");

        $this->setMeta(); // Set meta info after product retrieval
    }

    public function setMeta()
    {
        // Check if SEO fields exist, otherwise fall back to default
        $this->meta = [
            'keywords' => $this->product->seo_keywords ?: $this->product->name,
            'description' => $this->product->seo_description ?: $this->product->description,
            'og:title' => $this->product->og_title ?: $this->product->name,
            'og:description' => $this->product->og_description ?: $this->product->description,
            'og:image' => $this->product->og_image ?: $this->product->display_image_url,
            'canonical_url' => $this->product->canonical_url ?: url()->current(),
        ];
    }

    public function render()
    {
        return view('livewire.product-detail', [
            'product' => $this->product,
        ]);
    }
}
