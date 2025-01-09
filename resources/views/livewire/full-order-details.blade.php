<div class="flex w-full flex-col border border-border-200 bg-white" style="overflow: auto;">
    @if($order_data)
    <div class="flex flex-col items-center p-5 md:flex-row md:justify-between">
        <h2 class="mb-2 flex text-sm font-semibold text-heading md:text-lg">Order Details <span class="px-2">-</span> {{ $order_data->order_number ?? $order_data->id }}</h2>
        <div class="flex items-center">
            @if (Route::currentRouteName() !== 'frontend.orders.details')
            <a class="flex items-center text-sm font-semibold text-accent no-underline transition duration-200 hover:text-accent-hover focus:text-accent-hover" wire:navigate href="{{ route('frontend.orders.details', $order_data->id) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" class="ltr:mr-2 rtl:ml-2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>Details
            </a>
            @endif
        </div>
    </div>
    <div class="relative mx-5 mb-6 overflow-hidden rounded">
        <div class="bg-[#F7F8FA] px-7 py-4">
            <div class="flex flex-col flex-wrap items-center justify-between mb-0 text-base font-bold gap-x-8 text-heading sm:flex-row lg:flex-nowrap">
                <div class="order-2 grid w-full grid-cols-1 gap-6 xs:flex-nowrap sm:order-1 max-w-full basis-full justify-between md:grid-cols-2">
                    <div class="flex items-center gap-3"><span class="block text-xs shrink-0 grow-0 basis-auto xs:text-base lg:inline-block">Order Status :</span>
                        <div class="w-full lg:w-auto"><span class="px-3 py-1 rounded-full bg-status-processing bg-opacity-[.15] text-status-processing min-h-[2rem] items-center justify-center text-[9px] !leading-none xs:text-sm inline-flex">{{ config('general.order_statuses.' . $order_data->status) }}</span></div>
                    </div>
                    <div class="flex items-center gap-3 md:ml-auto"><span class="block text-xs shrink-0 grow-0 basis-auto xs:text-base lg:inline-block">{{ __trans('Payment Method') }} :</span>
                        <div class="w-full lg:w-auto"><span class="px-3 py-1 rounded-full text-light bg-accent !text-accent min-h-[2rem] items-center justify-center truncate whitespace-nowrap text-[9px] !leading-none xs:text-sm inline-flex">{{ $order_data->payment->details->name }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($order_data->transactions))
    <div class="relative mx-5 mb-6 overflow-hidden rounded text-muted text-sm">
        @foreach($order_data->transactions as $transaction)
            <div>
                {{ __trans('Txn.') }} : <span> #{{ $transaction->transaction_id }}</span>
            </div>
        @endforeach
    </div>
    @endif

    <div class="flex flex-col border-b border-border-200 sm:flex-row">
        <div class="flex w-full flex-col border-b border-border-200 px-5 py-4 sm:border-b-0 ltr:sm:border-r rtl:sm:border-l md:w-3/5">



        @if(!empty($order_data->address->shipping_address_id))    
        <div class="mb-4">
            <span class="mb-2 block text-sm font-bold text-heading">Shipping Address</span>
            <span class="text-sm text-body">
                
                {{ $order_data->address->shippingAddress->address }}<br>
                {{ $order_data->address->shippingAddress->city }}<br>
                {{ $order_data->address->shippingAddress->state }},  {{ $order_data->address->shippingAddress->postal_code }}<br>
                {{ $order_data->address->shippingAddress->country }}

            </span>
        </div>
        @endif

        @if(!empty($order_data->address->billing_address_id))
        <div>
            <span class="mb-2 block text-sm font-bold text-heading">Billing Address</span>
            <span class="text-sm text-body">
                {{ $order_data->address->billingAddress->address }}<br>
                {{ $order_data->address->billingAddress->city }}<br>
                {{ $order_data->address->billingAddress->state }},  {{ $order_data->address->billingAddress->postal_code }}<br>
                {{ $order_data->address->billingAddress->country }}
            </span>
        </div>
        @endif
        </div>
        <div class="flex w-full flex-col px-5 py-4 md:w-2/5">
            <div class="mb-3 flex justify-between"><span class="text-sm text-body">Sub Total</span><span class="text-sm text-heading">{{ $order_data->currency->symbol . ' ' . number_format($order_data->subtotal_amount, 2) }}</span></div>
            <div class="mb-3 flex justify-between"><span class="text-sm text-body">Discount</span><span class="text-sm text-heading">{{ $order_data->currency->symbol }} {{ number_format($order_data->discount_amount, 2) }}</span></div>
            <div class="mb-3 flex justify-between"><span class="text-sm text-body">Delivery Fee</span><span class="text-sm text-heading">{{ $order_data->currency->symbol }}0.00</span></div>
            <div class="mb-3 flex justify-between"><span class="text-sm text-body">Tax</span><span class="text-sm text-heading">{{ $order_data->currency->symbol }}0.00</span></div>
            <div class="flex justify-between"><span class="text-sm font-bold text-heading">Total</span><span class="text-sm font-bold text-heading">{{ $order_data->currency->symbol . ' ' . number_format($order_data->total_price, 2) }}</span></div>
        </div>
    </div>
    <div>
        <livewire:order-progress :currentStatus="$order_data->status" />
        <div class="rc-table orderDetailsTable w-full rc-table-fixed-header rc-table-scroll-horizontal">
            <div class="rc-table-container">
                <div class="rc-table-body" style="overflow: auto scroll; max-height: 500px;">
                    <table style="width: 350px; min-width: 100%; table-layout: fixed;">
                        <colgroup>
                            <col style="width: 250px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 140px;">
                        </colgroup>
                        <thead class="rc-table-thead">
                            <tr>
                                <th title="Item" class="rc-table-cell rc-table-cell-ellipsis" style="text-align: left;"><span class="ltr:pl-20 rtl:pr-20">Item</span></th>
                                <th class="rc-table-cell" style="text-align: center;">Quantity</th>
                                <th class="rc-table-cell" style="text-align: right;">Price</th>
                                <th class="rc-table-cell" style="text-align: right;"></th>
                            </tr>
                        </thead>
                        <tbody class="rc-table-tbody">
                            <tr aria-hidden="true" class="rc-table-measure-row" style="height: 0px; font-size: 0px;">
                                <td style="padding: 0px; border: 0px; height: 0px;">
                                    <div style="height: 0px; overflow: hidden;">&nbsp;</div>
                                </td>
                                <td style="padding: 0px; border: 0px; height: 0px;">
                                    <div style="height: 0px; overflow: hidden;">&nbsp;</div>
                                </td>
                                <td style="padding: 0px; border: 0px; height: 0px;">
                                    <div style="height: 0px; overflow: hidden;">&nbsp;</div>
                                </td>
                                <td style="padding: 0px; border: 0px; height: 0px;">
                                    <div style="height: 0px; overflow: hidden;">&nbsp;</div>
                                </td>
                            </tr>
                            @foreach($order_data->products as $index => $product)
                            
                            @php
                                $price = $product->pivot->price;
                                $quantity = $product->pivot->quantity;
                            @endphp

                            <tr data-row-key="2021-03-08 10:24:53" class="rc-table-row rc-table-row-level-0 !cursor-auto">
                                <td class="rc-table-cell rc-table-cell-ellipsis" style="text-align: left;">
                                    <div class="flex items-center">
                                        <div class="relative flex h-16 w-16 shrink-0 overflow-hidden rounded"><img alt="{{ $product->name }}" loading="lazy" decoding="async" data-nimg="fill" class="h-full w-full object-cover" sizes="(max-width: 768px) 100vw" srcset="{{ $product->display_image_url }}" src="{{ $product->display_image_url }}" style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;"></div>
                                        <div class="flex flex-col overflow-hidden ltr:ml-4 rtl:mr-4">
                                            <div class="mb-1 flex space-x-1 rtl:space-x-reverse"><a class="inline-block overflow-hidden truncate text-sm text-body transition-colors hover:text-accent hover:underline" href="{{ route('frontend.product-detail', ['product_slug' => $product->slug]) }}">{{ $product->name }}</a>
                                            </div><span class="mb-1 inline-block overflow-hidden truncate text-sm font-semibold text-accent">{{ $order_data->currency->symbol }}{{ $price }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="rc-table-cell" style="text-align: center;">
                                    <p class="text-base">{{ $quantity }}</p>
                                </td>
                                <td class="rc-table-cell" style="text-align: right;">
                                    <div>{{ $order_data->currency->symbol }}{{ $price * $quantity }}</div>
                                </td>

                                
                                <td class="rc-table-cell" style="text-align: right;">
                                    @if($can_write_review)
                                    <button wire:click="$dispatch('openReviewModal', { product_id: {{ $product->id }} })" class="cursor-pointer text-sm font-semibold text-body transition-colors hover:text-accent">Write a review</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>