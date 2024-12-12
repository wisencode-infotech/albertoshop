<?php

namespace App\Services;

use App\Jobs\SendOrderPlacedEmailJob;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderStatusChangedMail;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderService
{
    public $order;

    public function setRecord($order)
    {
        $this->order = $order;
    }

    public function updateStatus($status)
    {
        $this->updateFranchiseCommision($status);

        $this->order->status = $status;

        $this->order->save();

        if($status == 2){
            // $this->sendWhatsappMessage();
        }

        $this->sendStatusChangedEmail();
    }

    public function placeOrder($order)
    {
        $this->setRecord($order);

        $product_service = new ProductService();
        $product_service->updateStock($order);

        $this->sendOrderPlacedEmail();

        $data = [
            'title' => 'Order Placed',
            'message' => 'Your order #' . $order->order_number ?? $order->id . ' has been placed successfully.',
            'user_id' => $order->user->id,
            'is_global' => false,
            'type' => 'order',
            'url' => route('frontend.orders.details', $order->id),
            'meta_data' => [
                'order_id' => $order->id,
                'total' => $order->total_price,
                'extra_info' => $order->extra_information,
            ],
            'is_read' => false
        ];

        __addNotification($data);
    }

    protected function sendOrderPlacedEmail()
    {
        // Send order placed email to the customer
        if ( !empty($this->order->customer) ){
            SendOrderPlacedEmailJob::dispatch($this->order);
        }
            
    }

    protected function sendStatusChangedEmail()
    {
        // Send email notification for order status change
        if ( !empty($this->order->customer) )
            Mail::to($this->order->customer_contact_email)->queue(new OrderStatusChangedMail($this->order));
    }

    protected function sendWhatsAppMessage() {

        $shipping_address = $this->order->address->shippingAddress;

        $phone_number = $this->order->customer_contact_number ?? '';

        if(empty($phone_number)){
            $phone_number = $this->order->user->phone;
        }

        $phone_number_id = 497799816752273;
        $access_token = "EAAOLwrJ6Rq4BO1N1e5BVAofeRHT0nZAmUr4B1rZCL5AZAcfOAqjzJCwazJC8rAQRQYqfaAM4GddsTfcojO1uZByRLQX0WU36rJGxzaeQtqNv5pZBiiYrFZAb9z3zdPZCDSRGdwteDpn9QNviiZAhALoGVPwxCfhKw2XhVvvQEz9vvXCAws5MjddsXZAFsYCHxPmvxC6ZB05c7Ijui5CJjm9DCNjjbel4YZD"; // Replace with your Access Token
        $url = "https://graph.facebook.com/v16.0/$phone_number_id/messages";
    
        $data = [
            "messaging_product" => "whatsapp",
            // "to" => $phone_number,
            "to" => 919714019429,
            "type" => "template",
            "template" => [
                "name" => "custom_order_accepted", // Your approved template name
                "language" => ["code" => "en"],
                "components" => [
                    [
                        "type" => "body",
                        "parameters" => [
                            ["type" => "text", "text" => $this->order->user->name],
                            ["type" => "text", "text" => $this->order->order_number],
                            ["type" => "text", "text" => $this->order->total_price],
                            ["type" => "text", "text" => $this->order->user->phone],
                            ["type" => "text", "text" => $shipping_address->full_address]
                        ]
                    ]
                ]
            ]
        ];
    
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer $access_token"
        ];
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        curl_close($ch);
        // dd($response);
        return $response;
    }

    public function saveOrderTransaction($transaction_id, $status) 
    {
        $transaction = new Transaction();
        $transaction->order_id = $this->order->id;
        $transaction->transaction_id = $transaction_id;
        $transaction->amount = $this->order->total_price;
        $transaction->status = $status;
        $transaction->save();
    }

    public function updateFranchiseCommision($status) 
    {    
        (new UserService($this->order->user))->handleUserCommission($this->order, $status);
    }

    public function updatePaymentStatus($status)
    {
        $payment = Payment::where('order_id', $this->order->id)->first();
        $payment->status = $status;
        $payment->save();
    }
}
