<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariation;
use Livewire\Component;

class ProductPrice extends Component
{
    public $product_id;
    public $product_variation_id;
    public $price = 0;
    public $original_price = 0;
    

    public function mount($product_id, $product_variation_id = null)
    {
        $this->product_id = $product_id;

        $this->product_variation_id = $product_variation_id;

        if (empty($product_variation_id)) {
            $product_variation = ProductVariation::select('id')->where('product_id', $this->product_id)->first();
            $this->product_variation_id = $product_variation->id ?? null;
        }

        $this->setPrice();
    }

    public function getListeners()
    {
        return [
            "productVariantChanged-{$this->product_id}" => 'productVariantChanged'
        ];
    }

    public function setPrice()
    {
        if (!empty($this->product_variation_id)) {
            $this->original_price = $this->productVariation()->priceWithCurrency();
            $this->price = $this->productVariation()->discountedPriceWithCurrency();
        } else {
            $this->original_price = $this->product()->priceWithCurrency();
            $this->price = $this->product()->discountedPriceWithCurrency();
        }
    }

    public function productVariantChanged($product_id, $product_variation_id = null)
    {
        if ($this->product_id !== $product_id)
            return;
        
        $this->product_id = $product_id;

        $this->product_variation_id = $product_variation_id;

        $this->setPrice();
    }

    public function product()
    {
        return Product::where('id', $this->product_id)->first();
    }

    public function productVariation()
    {
        return ProductVariation::where('id', $this->product_variation_id)->select('id', 'price', 'product_id')->first();
    }

    public function render()
    {
        return view('livewire.product-price', [
            'price' => $this->price,
            'original_price' => $this->original_price
        ]);
    }
}
