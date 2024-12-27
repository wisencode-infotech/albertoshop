<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header, .footer {
            text-align: center;
            padding: 10px 0;
        }
        .logo {
            float: left;
            vertical-align: middle;
        }
        .status {
            float: right;
            /* padding: 5px 10px; */
            /* background-color: #f0f0f0; */
            /* border-radius: 5px; */
        }

        .order_number {
            /* float: right; */
            padding: 5px 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        .clear {
            clear: both;
        }
        .summary {
            margin-top: 20px;
        }
        .details {
            padding: 10px;
            border-top: 1px solid #ddd;
            /* border-bottom: 1px solid #ddd; */
            overflow: hidden;
        }
        .details-left {
            float: left;
            width: 48%;
        }
        .details-right {
            float: right;
            width: 48%;
            text-align: right;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .summary-table th {
            padding: 10px;
            font-size: 14px;
            text-align: center;
        }

        .summary-table td {
            padding: 10px;
            font-size: 14px;
            border-top: 1px solid #ddd;
            text-align: center;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset(__setting('header_logo')) }}" alt="PuriCBD" width="100">
            </div>
            <div class="status">

                @php
                    $order_statuses_color = [
                        1 => '#ffa500',  // Warning
                        2 => '#28a745',  // Success
                        3 => '#17a2b8',  // Info
                        4 => '#007bff',  // Primary
                        5 => '#dc3545',  // Danger
                        6 => '#6c757d'   // Secondary
                    ];

                    $status_color = $order_statuses_color[$order->status] ?? '#000000';
                @endphp

                <span>
                    <b class="order_number"> #{{ $order->order_number ?? $order->id }}</b>
                    <b class="order_number" style="background-color: {{ $status_color }}">{{ config('general.order_statuses.' . $order->status) }}</b>
                </span>

                
            </div>
            <div class="clear"></div>
        </div>

        @php 
            $currency = $order->currency; 
            $extra_information = json_decode($order->extra_information, true);
        @endphp

        <!-- Order Details Section -->
        <div class="details" style="font-size: 12px;">
            <div class="details-left">

                    @if(!empty($order->address->billing_address_id))
                    <span style="line-height: 0.6;">
                        <strong>Billed To:</strong><br>
                        <p>{{ $order->user->name }}</p>
                        <p>{{ $order->address->billingAddress->address }}</p>
                        <p>{{ $order->address->billingAddress->city }}</p>
                        <p>{{ $order->address->billingAddress->state }},  {{ $order->address->billingAddress->postal_code }}</p>
                        <p>{{ $order->address->billingAddress->country }}</p>
                    </span>
                    @endif

                    @if(!empty($extra_information['customer_contact_email']))
                    <p>{{ $extra_information['customer_contact_email'] ?? 'N/A' }}</p>
                    @endif

                    @if(!empty($extra_information['customer_contact_phone']))
                    <p>{{ $extra_information['customer_contact_phone'] ?? 'N/A' }}</p>
                    @endif

                    @if(!empty($extra_information['customer_additional_notes']))
                    <p>Notes: {{ $extra_information['customer_additional_notes'] ?? 'N/A' }}</p>
                    @endif

                    @if(!empty($order->payment->details))
                    <span>
                        <strong>Payment Method</strong><br>
                        {{ $order->payment->details->name }}<br>
                    </span>
                    @endif

                  
                    <span>
                        <br><strong>Currency</strong><br>
                        {{ $currency->code }}
                    </span>
            </div>
            <div class="details-right">
                @if(!empty($order->address->shipping_address_id))
                <span style="line-height: 0.6;" class="mt-2 mt-sm-0">
                    <strong>Shipped To:</strong><br>
                    <p>{{ $order->address->shippingAddress->address }}</p>
                    <p>{{ $order->address->shippingAddress->city }}</p>
                    <p>{{ $order->address->shippingAddress->state }},  {{ $order->address->shippingAddress->postal_code }}<br></p>
                    <p>{{ $order->address->shippingAddress->country }}</p>
                </span>
                @endif
            </div>
            <div class="clear"></div>
        </div>

        <!-- Order Summary Section -->
        <div class="summary">
            <h5>Order Summary</h5>
            <table class="summary-table">
                <thead>
                    <tr>
                        <th style="text-align: left;">No.</th>
                        <th style="text-align: left;">Item</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                @php $subtotal = 0; $total = 0; @endphp

                @foreach($order->products as $index => $product)

                @php
                    $price = $product->pivot->price;
                    $quantity = $product->pivot->quantity;
                @endphp

                <tr>
                    <td style="text-align: left;">{{ ++$index }}</td>
                    <td style="text-align: left;font-weight:bold;font-size:12px;">{{ $quantity .' X '. $product->name }}</td>
                    <td style="text-align: right;font-weight:bold;">{{ $currency->symbol }}{{ $price * $quantity }}</td>
                </tr>
                @php $subtotal += $price * $quantity; @endphp
                @php $total += $price * $quantity; @endphp
                @endforeach
                <tr class="total-row" style="display: none;">
                    <td colspan="2" class="text-end" style="text-align:right">Sub Total</td>
                    <td style="text-align: right;">{{ $currency->symbol }}{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2" style="text-align: right;" class="border-0 text-end">
                        <strong>Total</strong>
                    </td>
                    <td style="text-align: right;"><h4 class="m-0">{{ $currency->symbol }} {{ number_format($total, 2) }}</h4></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
