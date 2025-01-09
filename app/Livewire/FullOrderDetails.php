<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FullOrderDetails extends Component
{
    public $order_data;
    public $can_write_review;

    protected $listeners = ['dispatchOrderData' => 'updateOrder'];

    public function mount($order_data)
    {
        $this->order_data = $order_data;
        $this->can_write_review = Auth::check() && $this->order_data->status == 4 && $this->order_data->updated_at->diffInDays(now()) <= 5;
        
    }

    public function updateOrder($order_id)
    {
        $this->order_data = Order::find($order_id);
        $this->can_write_review = Auth::check() && $this->order_data->status == 4 && $this->order_data->updated_at->diffInDays(now()) <= 5;
        $this->dispatch('dispatchOrderStatus', $this->order_data->status);
    }

    public function render()
    {
        return view('livewire.full-order-details');
    }
}

