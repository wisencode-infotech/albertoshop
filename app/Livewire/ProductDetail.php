<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;

    public function mount($product_slug)
    {
        $this->product = Product::authenticated()->where('slug', $product_slug)->first();

        if (!$this->product)
            abort(404);
    }

    public function placeholder()
    {
        return view('livewire.skeleton-detail-page-loader');
    }

    public function render()
    {
        return view('livewire.product-detail', [
            'product' => $this->product,
        ]);
    }
}
