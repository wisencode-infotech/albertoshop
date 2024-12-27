<header id="site-header" class="site-header-with-search top-0 z-50 w-full transition-all sticky border-b border-border-200 shadow-sm lg:h-22 is-scrolling header-section">
    <div class="fixed inset-0 -z-10 h-[100vh] w-full bg-black/50 hidden"></div>
    <div class="grid w-full grid-cols-3 gap-2">
        
        <div class="" style="grid-column: 1 / 2; width: 33%;">
            <a class="inline-flex mx-auto lg:mx-0" style="margin-bottom: 5px;" wire:navigate href="{{ route('frontend.contact-us') }}">
                <span class="contact-image-for-mobile mt-2">
                    <i class="fa fa-phone text-accent"></i>
                    <span class="hide-on-mobile mt-2 mx-1 text-sm font-normal">{{ __trans('Contact') }}</span>
                </span>
            </a>
        </div>

        
        <div class="flex justify-center" style="grid-column: 2 / 3;">
            <a class="inline-flex mx-auto lg:mx-0" wire:navigate href="{{ route('frontend.home') }}">
                <img alt="{{ config('app.title') }}" loading="eager" decoding="async" class="object-contain app-logo-as-img" src="{{ asset(__setting('header_logo')) }}">
            </a>
        </div>
        
        <div class="flex justify-end" style="grid-column: 3 / 4;">
                <ul class="shrink-0 items-center space-x-7 rtl:space-x-reverse xl:flex 2xl:space-x-10">

                    <li class="hidden menuItem group relative mx-3 cursor-pointer">
                       <div class="flex items-center gap-2 group-hover:text-accent">
                          <span class="text-brand-dark group-hover:text-brand relative inline-flex items-center py-2 font-normal rtl:left-0"> {{ __userCurrencyCode() }}</span>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 7.2" width="12" height="7.2" class="mt-1">
                             <path d="M6.002 5.03L10.539.265a.826.826 0 011.211 0 .94.94 0 010 1.275l-5.141 5.4a.827.827 0 01-1.183.026L.249 1.545a.937.937 0 010-1.275.826.826 0 011.211 0z" fill="currentColor"></path>
                          </svg>
                       </div>
                       <ul class="shadow-dropDown invisible absolute top-full z-30 w-[150px] rounded-md bg-light py-4 opacity-0 shadow transition-all duration-300 group-hover:visible group-hover:opacity-100 right-0 xl:w-[150px]">
                           @foreach(__currencies() as $currency)
                                <li wire:key="currency-{{ $currency->id }}" class="menu-child-item font-chivo hover:filter-green group py-[10px] px-[22px] transition-all duration-200 hover:pl-[ 25px] hover:opacity-100">
                                    <a class="flex items-center font-normal text-heading no-underline transition duration-200 hover:text-accent focus:text-accent" href="{{ route('frontend.change.currency', $currency->code) }}">
                                        {{ ucfirst($currency->code) }} ({{ ucfirst($currency->symbol) }})
                                    </a>
                                </li>
                            @endforeach
                       </ul>
                    </li>

                    <li class="menuItem group relative mx-3 cursor-pointer">
                       <div class="flex items-center gap-2 group-hover:text-accent">
                          <span class="text-brand-dark group-hover:text-brand relative inline-flex items-center py-2 font-normal rtl:left-0"> {{ strtoupper(app()->getLocale()) }}</span>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 7.2" width="12" height="7.2" class="mt-1">
                             <path d="M6.002 5.03L10.539.265a.826.826 0 011.211 0 .94.94 0 010 1.275l-5.141 5.4a.827.827 0 01-1.183.026L.249 1.545a.937.937 0 010-1.275.826.826 0 011.211 0z" fill="currentColor"></path>
                          </svg>
                       </div>
                       <ul class="shadow-dropDown invisible absolute top-full z-30 rounded-md bg-light py-4 opacity-0 shadow transition-all duration-300 group-hover:visible group-hover:opacity-100 right-0">
                           @foreach(__languages() as $language)
                                <li wire:key="language-{{ $language->id }}"  class="menu-child-item font-chivo hover:filter-green group py-[10px] px-[22px] transition-all duration-200 hover:pl-[ 25px] hover:opacity-100">
                                    <a class="flex items-center font-normal text-heading no-underline transition duration-200 hover:text-accent focus:text-accent" href="{{ route('frontend.change.locale', $language->code) }}">
                                        {{ ucfirst($language->name) }}
                                    </a>
                                </li>
                            @endforeach
                       </ul>
                    </li>

                    @livewire('cart-icon')

                </ul>

                @if (auth()->check())

                @livewire('notification-icon', ['context' => 'header']) 
                
                <div class="lg:inline-flex ml-3">
                   <div class="relative inline-block ltr:text-left rtl:text-right" data-headlessui-state="open">
                      <button class="profile_menu_btn flex items-center focus:outline-0" id="headlessui-menu-button-:rn:" type="button" aria-haspopup="menu" aria-expanded="true" data-headlessui-state="open" aria-controls="headlessui-menu-items-:r19:">
                         <div class="relative cursor-pointer overflow-hidden rounded-full border border-border-100 h-[38px] w-[38px] border-border-200"><img alt="user name" fetchpriority="high" srcset="{{ auth()->user()->profile_image_url }}" src="{{ auth()->user()->profile_image_url }}" style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;"></div>
                         <span class="sr-only">user</span>
                      </button>
                      <ul class="profile_menu_section absolute hidden mt-5 w-48 rounded bg-white pb-4 shadow-700 focus:outline-none ltr:right-0 ltr:origin-top-right rtl:left-0 rtl:origin-top-left transform opacity-100 scale-100"  >
                         <li id="headlessui-menu-item-:r1c:" role="menuitem" tabindex="-1" data-headlessui-state=""><button wire:navigate href="{{ route('frontend.profile') }}" class="block w-full py-2.5 px-6 text-sm font-semibold capitalize text-heading transition duration-200 hover:text-accent focus:outline-0 ltr:text-left rtl:text-right text-heading">{{ __trans('Profile') }}</button></li>
                         <li id="headlessui-menu-item-:r1c:" role="menuitem" tabindex="-1" data-headlessui-state=""><button wire:navigate href="{{ route('frontend.my-orders') }}" class="block w-full py-2.5 px-6 text-sm font-semibold capitalize text-heading transition duration-200 hover:text-accent focus:outline-0 ltr:text-left rtl:text-right text-heading">{{ __trans('My Orders') }}</button></li>
                         <li id="headlessui-menu-item-:r1c:" role="menuitem" tabindex="-1" data-headlessui-state=""><button wire:navigate href="{{ route('frontend.my-wishlist') }}" class="block w-full py-2.5 px-6 text-sm font-semibold capitalize text-heading transition duration-200 hover:text-accent focus:outline-0 ltr:text-left rtl:text-right text-heading">{{ __trans('My Wishlist') }}</button></li>
                         @if (auth()->check())
                         <li id="headlessui-menu-item-:r1c:" role="menuitem" tabindex="-1" data-headlessui-state=""><button wire:navigate href="{{ route('frontend.credit') }}" class="block w-full py-2.5 px-6 text-sm font-semibold capitalize text-heading transition duration-200 hover:text-accent focus:outline-0 ltr:text-left rtl:text-right text-heading">{{ __trans('Credit') }}</button></li>
                         @endif
                         <li id="headlessui-menu-item-:r1f:" role="menuitem" tabindex="-1" data-headlessui-state=""><button wire:navigate href="{{ route('frontend.logout') }}" class="block w-full py-2.5 px-6 text-sm font-semibold capitalize text-heading transition duration-200 hover:text-accent focus:outline-0 ltr:text-left rtl:text-right">{{ __trans('Logout') }}</button></li>
                      </ul>
                   </div>
                </div>
                @endif

                @if (!auth()->check())
                <div class="flex items-center space-x-4 rtl:space-x-reverse mr-3">
                    <div class="hidden lg:inline-flex"></div>
                    <a wire:navigate href="{{ route('frontend.login') }}"
                        class="hide-on-medium h-9 shrink-0 items-center justify-center rounded border border-transparent bg-accent px-3 py-0 text-sm font-semibold leading-none text-light outline-none transition duration-300 ease-in-out hover:bg-accent-hover focus:shadow focus:outline-none focus:ring-1 focus:ring-accent-700 inline-flex">
                        <i class="fa fa-sign-in pr-2"></i> {{ __trans('Login') }}
                    </a>
                </div>

                <div class="flex items-center rtl:space-x-reverse">
                    <div class="hidden lg:inline-flex"></div>
                    <a wire:navigate href="{{ route('frontend.register') }}"
                        class="hide-on-medium h-9 shrink-0 items-center justify-center rounded border border-transparent bg-accent px-3 py-0 text-sm font-semibold leading-none text-light outline-none transition duration-300 ease-in-out hover:bg-accent-hover focus:shadow focus:outline-none focus:ring-1 focus:ring-accent-700 inline-flex"><i class="fa fa-user pr-2"></i> {{ __trans('Register') }}
                    </a>
                </div>
                @endif
        </div>
    </div>
</header>
