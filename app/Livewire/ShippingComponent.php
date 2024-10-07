<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ShippingAddress;
use App\Models\BillingAddress;
use App\Helpers\CartHelper;

class ShippingComponent extends Component
{
    public $shipping_addresses = [];
    public $billing_addresses = [];
    public $selected_shipping_address_id;
    public $selected_billing_address_id;
    public $cart_items = [];
    public $total_price = 0;

    protected $listeners = ['addressSaved' => 'loadAddresses'];

    public function mount(){

        $this->shipping_addresses = ShippingAddress::where('user_id', auth()->user()->id)->get();
        $this->billing_addresses = BillingAddress::where('user_id', auth()->user()->id)->get();

        // Select the first address by default if there are any addresses
        if ($this->shipping_addresses->isNotEmpty()) {
            $this->selected_shipping_address_id = $this->shipping_addresses->first()->id;
        }

        if ($this->billing_addresses->isNotEmpty()) {
            $this->selected_billing_address_id = $this->billing_addresses->first()->id;
        }

        $this->cart_items = CartHelper::items();
        $this->total_price = CartHelper::total();
    }

    public function selectShippingAddress($address_id)
    {
        $this->selected_shipping_address_id = $address_id;
    }

    public function selectBillingAddress($address_id)
    {
        $this->selected_billing_address_id = $address_id;
    }

    public function loadAddresses()
    {
        $this->shipping_addresses = ShippingAddress::where('user_id', auth()->user()->id)->get();
        $this->billing_addresses = BillingAddress::where('user_id', auth()->user()->id)->get();
    }

    public function render()
    {
        return view('livewire.shipping-component', [
            'cart' => $this->cart_items
        ]);
    }
}