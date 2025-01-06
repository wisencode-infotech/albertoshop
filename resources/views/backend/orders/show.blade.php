@extends('backend.layouts.master')

@section('title') Orders @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') <a href="{{ route('backend.order.index') }}">Orders</a> @endslot
@slot('title') Details #{{ $order->id }} @endslot
@endcomponent

@php $currency = $order->currency; @endphp

<div class="row">
    <div class="col-lg-12">
     <div class="card">
        <div class="card-body">
            <div class="invoice-title">
                <div class="float-end">
                    <h4 class="float-end font-size-16">Order # {{ $order->order_number ?? $order->id }}</h4>
                    <br>

                    <select class="form-control change_status form-control-sm" style="width: auto; margin-right: 5px;">
                        @foreach ($all_statuses as $key => $value)
                            <option data-order-id = "{{ $order->id }}" value="{{ $key }}" @if($order->status == $key) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>

                    <!-- <span class="badge rounded-pill badge-soft-{{ $status_color }} font-size-12">{{ $status }}</span> -->
                </div>
                
                <div class="auth-logo mb-4">
                    <img src="{{ asset(__setting('header_logo')) }}" class="img-fluid img-thumbnail app-logo-as-img" alt="">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    @if(!empty($order->address->billing_address_id))
                    <address>
                        <strong>Billed To:</strong><br>
                        {{ $order->user->name }}<br>
                        {{ $order->address->billingAddress->address }}<br>
                        {{ $order->address->billingAddress->city }}<br>
                        {{ $order->address->billingAddress->state }},  {{ $order->address->billingAddress->postal_code }}<br>
                        {{ $order->address->billingAddress->country }}
                    </address>
                    @endif
                </div>
                <div class="col-sm-6 text-sm-end">
                    @if(!empty($order->address->shipping_address_id))
                    <address class="mt-2 mt-sm-0">
                        <strong>Shipped To:</strong><br>
                        {{ $order->address->shippingAddress->address }}<br>
                        {{ $order->address->shippingAddress->city }}<br>
                        {{ $order->address->shippingAddress->state }},  {{ $order->address->shippingAddress->postal_code }}<br>
                        {{ $order->address->shippingAddress->country }}
                    </address>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 mt-3">
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
                    <address>
                        <strong>Payment Method</strong><br>
                        {{ $order->payment->details->name }}<br>
                    </address>
                    @endif

                  
                    <address>
                        <strong>Currency</strong><br>
                        {{ $currency->code }}
                    </address>
                   

                </div>
                <div class="col-sm-6 mt-3 text-sm-end">
                    <address>
                        <strong>Order Date:</strong><br>
                        @php $formattedDate = date('F d, Y', strtotime($order->created_at)); @endphp
                        {{ $formattedDate }}<br><br>
                    </address>
                </div>
            </div>
            <div class="py-2 mt-3">
                <h3 class="font-size-15 fw-bold">Order summary</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 70px;">No.</th>
                            <th>Item</th>
                            <th class="text-end">Price</th>
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
                            <td>{{ ++$index }}</td>
                            <td>{{ $quantity .' X '. $product->name }}</td>
                            <td class="text-end">{{ $currency->symbol }}{{ $price * $quantity }}</td>
                        </tr>
                        @php $subtotal += $price * $quantity; @endphp
                        @php $total += $price * $quantity; @endphp
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-end">Sub Total</td>
                            <td class="text-end">{{ $currency->symbol }}{{ number_format($order->subtotal_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end">Discount</td>
                            <td class="text-end">{{ $currency->symbol }}{{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        <!-- <tr>
                            <td colspan="2" class="border-0 text-end">
                                <strong>Shipping</strong></td>
                                <td class="border-0 text-end">$13.00</td>
                            </tr> -->
                            <tr>
                                <td colspan="2" class="border-0 text-end">
                                    <strong>Total</strong></td>
                                    <td class="border-0 text-end"><h4 class="m-0">{{ $currency->symbol }} {{ number_format($order->total_price, 2) }}</h4></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                        </div>

                        <div class="float-end">
                            <a href="{{ route('backend.order.download-pdf', $order->id) }}" class="btn btn-danger waves-effect waves-light me-1"><i class="fa fa-download"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('script')
    <script type="text/javascript">
         $(document).on('change', '.change_status', function(e) {
            var selected_status = $(this).val();
            var order_id = $(this).find('option:selected').data('order-id'); 
                $.ajax({
                    url: "{{ route('backend.order.change.status') }}", // The action URL of the form
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Passing the CSRF token in headers
                    },
                    data: {
                        'selected_status': selected_status,
                        'order_id': order_id,
                    },
                    dataType: 'json',
                    success: function(response) {
                        toastr.success(response.message);
                        $('#orders-table').DataTable().ajax.reload(null, false); // Reload the DataTable
                    },
                    error: function(error) {
                        toastr.error('Something went wrong!');
                    },
                    complete: function() {
                        // Any additional actions after the request completes
                    }
                });
            });
    </script>
    @endsection