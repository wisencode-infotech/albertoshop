<?php

namespace App\Services;

use App\Helpers\CartHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\PaymentMethod;

class VivaPaymentService
{
    private $client;
    private $bearerToken;
    protected $payments_method_detail;

    public function __construct()
    {
        $this->payments_method_detail = PaymentMethod::where('name','Viva.com')->first();
        $this->bearerToken = base64_encode("{$this->payments_method_detail->meta_info->merchant_id}:{$this->payments_method_detail->meta_info->api_key}");
        $this->client = new Client();
    }

    public function processVivaPayment(Order $order)
    {
        $orderData = $this->createOrder($order);

        if (isset($orderData['payment_url'])) {
            return redirect($orderData['payment_url']);
        }

        return redirect()->route('frontend.payment.error')->with('error', __trans('Something went wrong with Viva payment'))->with('order', $order);
    }

    public function createOrder($order)
    {
        try {

            $payload = [
                'amount' => $order->total_price * 100, // in cents
                'customerTrns' => 'Order #' . $order->id,
                'customer' => [
                    'email' => $order->user->email,
                    'fullName' => $order->user->name,
                    'phone' => $order->user->phone,
                ],
                'sourceCode' => 8206,
                'merchantTrns' => $order->id,
                'redirectUrl' => route('frontend.thank-you', [$order]),
                'cancelUrl' => route('frontend.payment.error', ['status' => 'cancel']),
                'orderDescription' => 'Purchase of items in Order #' . $order->id,
            ];

            $response = $this->client->post($this->payments_method_detail->meta_info->api_url, [
                'json' => $payload,
                'headers' => [
                    'Authorization' => 'Basic ' . $this->bearerToken,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);
            
            if (!empty($responseData['OrderCode'])) {
                $responseData['payment_url'] = $this->payments_method_detail->meta_info->checkout_url.'?ref='.$responseData['OrderCode'];
            }

            return $responseData;

        } catch (RequestException $e) {
            
            return redirect()->route('frontend.payment.error')->with('error', 'Viva Order Creation Error: ' . $e->getMessage())->with('order', $order);
        }
    }

    public function handleVivaCallback(Request $request)
    {
        // Log the callback data for debugging
        Log::info('Viva Callback Data: ', $request->all());

        // Extract relevant data from the callback
        $orderCode = $request->input('orderCode');
        $status = $request->input('Status'); // Check for payment status
        $orderId = $request->input('MerchantTrns'); // Your order identifier

        // Find the order using your order ID (you might need to adjust this logic)
        if (!$orderId || !$status) {
            Log::error('Viva callback missing required order ID or status');
            return response()->json(['message' => 'Invalid callback data'], 400);
        }

        $order = Order::find($orderId);
        if (!$order) {
            Log::error('Order not found for callback', ['orderId' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $this->updateOrderStatus($order, $status, $orderCode);

        return response()->json(['status' => 'success']);
    }

    private function updateOrderStatus(Order $order, $status, $orderCode)
    {
        $orderService = new OrderService(); // Ensure you have this service defined
        $orderService->setRecord($order); // Assuming this sets the current order for updates

        if ($status === 'SUCCEEDED') {
            $orderService->updateStatus(2); // Update status to "Paid"
            $orderService->saveOrderTransaction($orderCode, 'PAID');
            $orderService->updatePaymentStatus('completed');
            CartHelper::clearDatabaseCart($order->user_id); // Assuming this clears the user's cart
        } else {
            $orderService->updateStatus(5); // Update status to "Failed"
            $orderService->saveOrderTransaction($orderCode, 'FAILED');
            $orderService->updatePaymentStatus('failed');
        }
    }
}
