@section('title', __trans('Checkout'))

<div class="bg-gray-100 px-4 py-8 lg:py-10 lg:px-8 xl:py-14 xl:px-16 2xl:px-20">
   <div class="m-auto flex w-full max-w-5xl flex-col items-center rtl:space-x-reverse lg:flex-row lg:items-start lg:space-x-8">
      
      <div class="w-full space-y-6 lg:max-w-2xl">
        <h3 class="text-2xl font-bold text-heading">{{ __trans('Checkout') }}</h3>
         <div class="bg-light p-5 shadow-700 md:p-8">
            <div class="mb-5 flex items-center justify-between md:mb-8">
               <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent text-base text-accent-contrast lg:text-xl">1</span>
                  <p class="text-lg capitalize text-heading lg:text-xl">{{ __trans('Contact Info') }}</p>
               </div>
            </div>
            <div class="w-full">
               <div class=" react-tel-input ">
                  <div class="special-label">{{ __trans('Phone') }}</div>
                  <input wire:model="phone" class="form-control !p-0 ltr:!pr-4 rtl:!pl-4 ltr:!pl-1 rtl:!pr-1 !flex !items-center !w-full !appearance-none !transition !duration-300 !ease-in-out !text-heading !text-sm focus:!outline-none focus:!ring-0 !border !border-border-base !rounded focus:!border-accent !h-12" placeholder="1 (702) 123-4567" type="tel">
               </div>
            </div>

            <div class="w-full mt-2">
               <div class=" react-tel-input ">
                  <div class="special-label">{{ __trans('Email') }}</div>
                  <input wire:model="email" class="form-control !p-0 ltr:!pr-4 rtl:!pl-4 ltr:!pl-1 rtl:!pr-1 !flex !items-center !w-full !appearance-none !transition !duration-300 !ease-in-out !text-heading !text-sm focus:!outline-none focus:!ring-0 !border !border-border-base !rounded focus:!border-accent !h-12" placeholder="{{ __trans('Enter your email') }}" type="text">
               </div>
            </div>

            @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
         </div>
         <div wire:loading.flex wire:target.except="placeOrder, selectPaymentMethod" class="fixed inset-0 z-10 flex items-center justify-center bg-accent-400 bg-opacity-10">
               <div class="loader"></div>
         </div>

         <div wire:loading.flex  wire:target="placeOrder" class="fixed inset-0 z-10 flex items-center justify-center bg-accent-400 bg-opacity-10">
               <div class="loader"></div>
         </div>
         
         <div class="bg-light p-5 shadow-700 md:p-8">
            <div class="mb-5 flex items-center justify-between md:mb-8">
               <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent text-base text-accent-contrast lg:text-xl">2</span>
                  <p class="text-lg capitalize text-heading lg:text-xl">{{ __trans('Shipping Address') }}</p>
               </div>
               <button wire:click="$dispatch('open-modal', { type: 'shipping' })" class="flex items-center text-sm font-semibold text-accent transition-colors duration-200 hover:text-accent-hover focus:text-accent-hover focus:outline-0">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 stroke-2 ltr:mr-0.5 rtl:ml-0.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                  </svg>
                  {{ __trans('Add') }}
               </button>
            </div>
            <div id="headlessui-radiogroup-:rc:" role="radiogroup" aria-labelledby="headlessui-label-:rd:">
               <label class="sr-only" id="headlessui-label-:rd:" role="none">{{ __trans('Shipping Address') }}</label>
               <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3" role="none">

               @if(count($shipping_addresses) != 0)
                   @foreach($shipping_addresses as $shipping_address) 
                     <div id="headlessui-radiogroup-option-:re:" role="radio" aria-checked="false" tabindex="0" data-headlessui-state="">
                        <div wire:click="selectShippingAddress({{ $shipping_address->id }})" class="group relative cursor-pointer rounded border p-4 hover:border-accent border-transparent bg-gray-100 shipping_address_container {{ $selected_shipping_address_id === $shipping_address->id ? 'active' : '' }}">
                           
                           <p class="mb-3 text-sm font-semibold capitalize text-heading">{{ __trans('Shipping') }}</p>
                           <p class="text-sm text-sub-heading">{{ $shipping_address->address }}, {{ $shipping_address->city }}, {{ $shipping_address->state }} {{ $shipping_address->postal_code }}, {{ $shipping_address->country }}</p>
                           <div class="absolute top-4 flex space-x-2 opacity-0 group-hover:opacity-100 ltr:right-4 rtl:left-4 rtl:space-x-reverse">
                              <button wire:click="$dispatch('editShippingAddress', { address_id: {{ $shipping_address->id }} })" class="flex h-5 w-5 items-center justify-center rounded-full bg-accent text-light">
                                 <span class="sr-only">{{ __trans('Edit') }}</span>
                                 <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                 </svg>
                              </button>
                              <button wire:click="$dispatch('deleteShippingAddress', { address_id: {{ $shipping_address->id }} })" class="flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-light">
                                 <span class="sr-only">{{ __trans('Delete') }}</span>
                                 <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                 </svg>
                              </button>
                           </div>
                        </div>
                     </div>
                   @endforeach
               @else

                  <div class="text-muted">
                     {{ __trans('No address available.') }}
                  </div>

               @endif  
               </div>

               @error('selected_shipping_address_id') <span class="text-red-500">{{ $message }}</span> @enderror

            </div>
         </div>

         <div class="bg-light p-5 shadow-700 md:p-8">
            <div class="mb-5 flex items-center justify-between md:mb-8">
               <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent text-base text-accent-contrast lg:text-xl">3</span>
                  <p class="text-lg capitalize text-heading lg:text-xl">{{ __trans('Billing Address') }}</p>
               </div>

               @if(count($shipping_addresses) != 0)
               <div>
                  <div class="flex items-center">
                     <input id="copy_to_billing" type="checkbox" class="checkbox" wire:model="copy_to_billing" wire:click="copyShippingAddress">
                     <label for="copy_to_billing" class="text-body text-sm primary">{{ __trans('Same as Shipping Address') }}</label>
                  </div>
               </div>
               @endif

               @if(!$copy_to_billing)
               <button wire:click="$dispatch('open-modal', { type: 'billing' })" class="flex items-center text-sm font-semibold text-accent transition-colors duration-200 hover:text-accent-hover focus:text-accent-hover focus:outline-0">
                  <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 stroke-2 ltr:mr-0.5 rtl:ml-0.5">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                  </svg>
                  {{ __trans('Add') }}
               </button>
               @endif
            </div>
            <div id="headlessui-radiogroup-:r9:" role="radiogroup" aria-labelledby="headlessui-label-:ra:">
               <label class="sr-only" id="headlessui-label-:ra:" role="none">{{ __trans('Billing Address') }}</label>

               <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3" role="none">

                  @if(!$copy_to_billing)

                     @if(count($billing_addresses) != 0)

                        @foreach($billing_addresses as $billing_address)  
                        <div id="headlessui-radiogroup-option-:rb:" role="radio" aria-checked="true" tabindex="0" data-headlessui-state="checked">
                           <div wire:click="selectBillingAddress({{ $billing_address->id }})" class="group relative cursor-pointer rounded border p-4 hover:border-accent border-transparent bg-gray-100 shipping_address_container {{ $selected_billing_address_id === $billing_address->id ? 'active' : '' }}">
                              <p class="mb-3 text-sm font-semibold capitalize text-heading">{{ __trans('Billing') }}</p>
                              <p class="text-sm text-sub-heading">{{ $billing_address->address }}, {{ $billing_address->city }}, {{ $billing_address->state }} {{ $billing_address->postal_code }}, {{ $billing_address->country }}</p>
                              <div class="absolute top-4 flex space-x-2 opacity-0 group-hover:opacity-100 ltr:right-4 rtl:left-4 rtl:space-x-reverse">
                                 <button wire:click="$dispatch('editBillingAddress', { address_id: {{ $billing_address->id }} })" class="flex h-5 w-5 items-center justify-center rounded-full bg-accent text-light">
                                    <span class="sr-only">{{ __trans('Edit') }}</span>
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                       <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                 </button>
                                 <button wire:click="$dispatch('deleteBillingAddress', { address_id: {{ $billing_address->id }} })" class="flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-light">
                                    <span class="sr-only">{{ __trans('Delete') }}</span>
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                       <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                 </button>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     @else

                        <div class="text-muted">
                           {{ __trans('No address avaialable.') }}
                        </div>

                     @endif  
                  
                  @endif

               </div>
            </div>
         </div>
         
         <div class="bg-light p-5 shadow-700 md:p-8">
            <div class="mb-5 flex items-center justify-between md:mb-8">
               <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                  <span class="flex h-8 w-8 items-center justify-center rounded-full bg-accent text-base text-accent-contrast lg:text-xl">4</span>
                  <p class="text-lg capitalize text-heading lg:text-xl">{{ __trans('Order Note') }}</p>
               </div>
            </div>
            <div class="block">
               <div><textarea id="orderNote" wire:model="order_notes" class="flex w-full appearance-none items-center rounded px-4 py-3 text-sm text-heading transition duration-300 ease-in-out focus:outline-0 focus:ring-0 border border-border-base focus:border-accent" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" rows="4"></textarea></div>
            </div>
         </div>
      </div>
      <div class="mt-10 mb-10 w-full sm:mb-12 lg:mb-0 lg:w-96">
         <div>
            <div class="flex flex-col pb-2 border-b border-border-200">

                @foreach($cart as $cart_key => $item)
               <div class="flex justify-between py-2">
                  <div class="flex items-center justify-between text-base"><span class="text-sm text-body"><span class="text-sm font-bold text-heading">{{ $item['quantity'] }}</span>
                    <span class="mx-2">x</span>
                    <span>{{ $item['product_name'] }} </span> 
                    @if (!empty($item['product_variation_name']))
                        | <span>{{ $item['product_variation_name'] }}</span>
                    @endif
                    <span>  
                    </span></span></div>
                  <span class="text-sm text-body font-semibold">{{ __userCurrencySymbol() }} {{ $item['product_price'] * $item['quantity'] }}</span>
               </div>
                @endforeach
            </div>
            
            <div class="mt-4 space-y-2">
               <div class="flex justify-between">
                  <p class="text-sm text-body font-semibold">{{ __trans('Sub Total') }}</p>
                  <span class="text-sm text-body font-semibold">{{ __userCurrencySymbol() }} {{ number_format($total_price, 2) }}</span>
               </div>
               <div class="flex justify-between">
                  <p class="text-sm text-body font-semibold">{{ __trans('Tax') }}</p>
                  <span class="text-sm text-body font-semibold">{{ __userCurrencySymbol() }}0.00</span>
               </div>
               <div class="flex justify-between">
                  <p class="text-sm text-body font-semibold">{{ __trans('Shipping') }} <span class="text-xs font-semibold text-accent"></span></p>
                  <span class="text-sm text-body font-semibold">{{ __userCurrencySymbol() }}0.00</span>
               </div>
               <div class="flex justify-between pt-3 border-t-4 border-double border-border-200">
                  <p class="text-base font-semibold text-heading">{{ __trans('Total') }}</p>
                  <span class="text-base font-semibold text-heading">{{ __userCurrencySymbol() }} {{ number_format($total_price, 2) }}</span>
               </div>

               @if ($discount_amount > 0)
                  <div class="flex justify-between pt-3 border-t-4 border-double border-border-200">
                     <p class="text-base font-semibold text-heading">{{ __trans('Discount') }}</p>
                     <span class="text-base font-semibold text-heading">{{ __userCurrencySymbol() }} {{ number_format($discount_amount, 2) }}</span>
                  </div>

                  <div class="flex justify-between pt-3 border-t-4 border-double border-border-200">
                     <p class="text-base font-semibold text-heading">{{ __trans('Final Price') }}</p>
                     <span class="text-base font-semibold text-heading">{{ __userCurrencySymbol() }} {{ number_format($final_price, 2) }}</span>
                  </div>
               @endif

            </div>

            <!-- Coupon Code Section -->
            <div class="p-5 mt-5 border border-gray-200 bg-light">
               <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                     <label class="mb-5 block text-base font-semibold text-heading" id="headlessui-label-:rg:" role="none">{{ __trans('Apply Coupon Code') }}</label>
                  </div>
               </div>
               <div class="flex space-x-4 rtl:space-x-reverse">
                  <input wire:model="coupon_code" class="form-control flex-grow" placeholder="{{ __trans('Enter coupon code') }}" type="text">
                  <button wire:click="applyCouponCode" class="font-semibold  transition duration-300 ease-in-out focus:outline-0 focus:shadow focus:ring-1 focus:ring-accent-700 bg-accent text-accent-contrast border border-transparent hover:bg-accent-hover w-full">{{ __trans('Apply') }}</button>
               </div>
               @if ($coupon_error)
                  <p class="text-red-500 text-sm mt-2">{{ $coupon_error }}</p>
               @endif

               @if ($coupon_success)
                  <p class="text-accent text-sm mt-2">{{ $coupon_success }}</p>
               @endif

               @error('coupon_code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="p-5 mt-5 border border-gray-200 bg-light">
               <div id="headlessui-radiogroup-:rf:" role="radiogroup" aria-labelledby="headlessui-label-:rg:">
                  <label class="mb-5 block text-base font-semibold text-heading" id="headlessui-label-:rg:" role="none">{{ __trans('Choose Payment Method') }}</label>
                  <div class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-2" role="none">
                     
                    @foreach($payment_methods as $payment_method)
                     <div id="headlessui-radiogroup-option-:rh:" role="radio" aria-checked="false" tabindex="0" data-headlessui-state="">
                        <div wire:click="selectPaymentMethod({{ $payment_method->id }}, '{{ $payment_method->description }}')" class="payment_method_section relative flex h-full w-full cursor-pointer items-center justify-center rounded border border-gray-200 bg-light p-3 text-center {{ $selected_payment_method_id === $payment_method->id ? 'active' : '' }}"><span class="text-xs font-semibold text-heading">{{ $payment_method->name }}</span></div>
                     </div>
                    @endforeach
                  </div>
               </div>
               @if(!empty($payment_method_description))
               <div>
                    <span class="block text-sm text-body">{{ $payment_method_description }}</span>
                </div>
                @endif
            </div>

            <div class="p-5 mt-5 border border-gray-200 bg-light">
               <div id="headlessui-radiogroup-:rf:" role="radiogroup" aria-labelledby="headlessui-label-:rg:">
                  <label class="mb-5 block text-base font-semibold text-heading" id="headlessui-label-:rg:" role="none">{{ __trans('Shipping Method') }}</label>
                  <div class="mb-8 grid grid-cols-2 gap-4 md:grid-cols-2" role="none">
                     <div id="headlessui-radiogroup-option-:rh:" role="radio" aria-checked="false" tabindex="0" data-headlessui-state="">
                        <div class="payment_method_section relative flex h-full w-full cursor-pointer items-center justify-center rounded border border-gray-200 bg-light p-3 text-center active"><span class="text-xs font-semibold text-heading">{{ $shipping_method->name }}</span></div>
                     </div>
                  </div>
               </div>
               @if(!empty($shipping_method->description))
               <div>
                    <span class="block text-sm text-body">{{ $shipping_method->description }}</span>
                </div>
                @endif
            </div>

            @if(count($cart) != 0)
            <button wire:click="placeOrder"  wire:loading.attr="disabled" data-variant="normal" class="inline-flex items-center justify-center shrink-0 font-semibold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-0 focus:shadow focus:ring-1 focus:ring-accent-700 bg-accent text-accent-contrast border border-transparent hover:bg-accent-hover px-5 py-0 h-12 mt-5 w-full">
               <span wire:loading.remove wire:target="placeOrder">
                    {{ __trans('Place Order') }}
                </span>
                <span wire:loading wire:target="placeOrder">
                    {{ __trans('Placing Order...') }}
                </span>
            </button>
            @endif
         </div>
      </div>
   </div>
</div>


