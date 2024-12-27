<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .title {
            text-align: left;
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f4f4f4;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="{{ asset(__setting('header_logo')) }}" alt="Logo" height="80">
    </div>
    <div class="title">Orders</div>

    @foreach ($orders as $order)

    @php 
        $currency = $order->currency; 
        $extraInformation = json_decode($order->extra_information, true);
    @endphp

        <div style="border:2px solid black;margin:20px 0;page-break-inside: avoid;">
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Order:</strong></td>
                        <td>{{ $order->order_number ?? $order->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Username:</strong></td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                    </tr>

                    @if(!empty($order->payment->details))
                    <tr>
                        <td><strong>Payment Method:</strong></td>
                        <td>
                            {{ $order->payment->details->name }}
                        </td>
                    </tr>
                    @endif
                    

                    @if(!empty($order->address->billing_address_id))
                    <tr>
                        <td><strong>Billing Address:</strong></td>
                        <td> 
                            {{ $order->address->billingAddress->address }}<br>
                            {{ $order->address->billingAddress->city }}<br>
                            {{ $order->address->billingAddress->state }},  {{ $order->address->billingAddress->postal_code }}<br>
                            {{ $order->address->billingAddress->country }}
                        </td>
                    </tr>
                    @endif

                    @if(!empty($order->address->shipping_address_id))
                    <tr>
                        <td><strong>Shipping Address:</strong></td>
                        <td> 
                            {{ $order->address->shippingAddress->address }}<br>
                            {{ $order->address->shippingAddress->city }}<br>
                            {{ $order->address->shippingAddress->state }},  {{ $order->address->shippingAddress->postal_code }}<br>
                            {{ $order->address->shippingAddress->country }}
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td><strong>Currency:</strong></td>
                        <td>{{ $currency->code }}</td>
                    </tr>

                    @if(!empty($extraInformation['customer_contact_email']))
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $extraInformation['customer_contact_email'] ?? 'N/A' }}</td>
                    </tr>
                    @endif

                    @if(!empty($extraInformation['customer_contact_phone']))
                    <tr>
                        <td><strong>Phone Number:</strong></td>
                        <td>{{ $extraInformation['customer_contact_phone'] ?? 'N/A' }}</td>
                    </tr>
                    @endif

                    @if(!empty($extraInformation['customer_additional_notes']))
                    <tr>
                        <td><strong>Notes:</strong></td>
                        <td>{{ $extraInformation['customer_additional_notes'] ?? 'N/A' }}</td>
                    </tr>
                    @endif

                </tbody>
            </table>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Item Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp

                    @foreach ($order->products as $product)
                        @php
                            $quantity = $product->pivot->quantity;
                            $price = $product->pivot->price;
                        @endphp

                        <!-- Loop through each product associated with the order -->
                        <tr>
                            <td>{{ $product->name ?? '' }}</td>
                            <td>{{ $currency->symbol }}{{ number_format($price, 2) }}</td>
                            <td>{{ $product->pivot->quantity }}</td> <!-- Use the pivot quantity -->
                            <td>{{ $currency->symbol }}{{ number_format($price * $quantity, 2) }}</td>
                            <!-- Calculate subtotal for each item -->
                        </tr>
                        @php 
                            $total += $price * $quantity; 
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>{{ $currency->symbol }}{{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach
</body>
</html>
