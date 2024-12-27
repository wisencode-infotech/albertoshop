 <div id="headlessui-portal-root">
     <div data-headlessui-portal="">
        <div>
           <div id="headlessui-dialog-:r19:" class="mobile-header-filter-section hidden" role="dialog" aria-modal="true">
              <div dir="ltr">
                 <aside class="fixed inset-0 z-50 h-full overflow-hidden" style="left: 0%;">
                    <div class="absolute inset-0 overflow-hidden">
                       <div class="absolute inset-0 bg-dark bg-opacity-40" style="opacity: 1;"></div>
                       <div class="absolute inset-y-0 flex max-w-full outline-none ltr:left-0 rtl:left-0">
                          <div class="h-full w-screen max-w-md">
                             <div class="drawer flex h-full flex-col bg-light text-base shadow-xl">
                                <div data-overlayscrollbars-initialize="" class="os-theme-thin-dark h-full w-full" data-overlayscrollbars="host">
                                   <div class="os-size-observer">
                                      <div class="os-size-observer-listener ltr"></div>
                                   </div>
                                   <div data-overlayscrollbars-contents="" data-overlayscrollbars-viewport="scrollbarHidden" style="margin-right: 0px; margin-bottom: 0px; margin-left: 0px; top: 0px; right: auto; left: 0px; width: calc(100% + 0px); padding: 0px;">
                                      <div class="flex h-full flex-col">
                                         <div class="fixed top-0 z-20 flex w-full max-w-md items-center justify-between border-b border-border-200 border-opacity-75 bg-white p-5 px-5 md:px-6">
                                            <a class="inline-flex w-24 md:w-auto" href="/"><span class="relative h-[2.125rem] w-32 overflow-hidden md:w-[8.625rem]"><img alt="{{ config('app.title') }}" loading="eager" decoding="async" data-nimg="fill" class="object-contain" sizes="(max-width: 768px) 100vw" srcset="{{ asset(__setting('header_logo')) }}" style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;"></span></a>
                                            <button class="mobile-header-filter-close-btn flex h-7 w-7 items-center justify-center rounded-full bg-gray-200 text-body transition-all duration-200 hover:bg-accent hover:text-light focus:bg-accent focus:text-light focus:outline-0">
                                               <span class="sr-only">close</span>
                                               <svg class="h-2.5 w-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                               </svg>
                                            </button>
                                         </div>
                                         <div class="pt-20">
                                            <div class="h-full max-h-full">
                                               <aside class="mobile-pages-drawer-section hidden h-full bg-light lg:sticky xl:block xl:w-72 lg:top-22">
                                                  <div class="max-h-full grow overflow-hidden">
                                                     <div class="px-5">
                                                        <ul class="text-xs xl:py-8">

                                                         <li class="rounded-md py-1" style="background-color: rgb(255, 255, 255);">
                                                            <a wire:navigate href="{{ route('frontend.home') }}" class="flex w-full items-center py-2 font-semibold text-body-dark outline-none transition-all ease-in-expo  focus:text-accent focus:outline-0 focus:ring-0 ltr:text-left rtl:text-right text-body-dark text-sm">
                                                                 <span>{{ __trans('Shops') }}</span><span class="ltr:ml-auto ltr:mr-4 rtl:ml-4 rtl:mr-auto"></span>
                                                            </a>
                                                         </li>

                                                         <li class="rounded-md py-1" style="background-color: rgb(255, 255, 255);">
                                                            <a wire:navigate href="{{ route('frontend.contact-us') }}" class="flex w-full items-center py-2 font-semibold text-body-dark outline-none transition-all ease-in-expo  focus:text-accent focus:outline-0 focus:ring-0 ltr:text-left rtl:text-right text-body-dark text-sm">
                                                                 <span>{{ __trans('Contact') }}</span><span class="ltr:ml-auto ltr:mr-4 rtl:ml-4 rtl:mr-auto"></span>
                                                            </a>
                                                         </li>

                                                        </ul>
                                                     </div>
                                                  </div>
                                               </aside>

                                               <aside class="mobile-filter-products-drawer-section hidden h-full bg-light lg:sticky xl:block lg:top-22">
                                                  <div class="max-h-full grow overflow-hidden">
                                                     <div class="px-5">

                                                         <h2 class="text-lg font-bold mb-4">{{ __trans('Filter Products') }}</h2>
                                                         <form  wire:submit.prevent="applyFilters">
                                                              <!-- Search Bar -->
                                                              <div class="mb-4">
                                                                  <label for="search" class="block text-sm font-medium text-gray-700">{{ __trans('Search Products') }}</label>
                                                                  <input type="text" id="search" placeholder="Search by name..."
                                                                         class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                         wire:model="search" />
                                                              </div>

                                                              <!-- Sort By Product Name -->
                                                              <div class="mb-4">
                                                                  <label for="sort" class="block text-sm font-medium text-gray-700">{{ __trans('Sort by Product Name') }}</label>
                                                                  <select id="sort" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                          wire:model="sort">
                                                                      <option value="asc">{{ __trans('Product Name: A-Z') }}</option>
                                                                      <option value="desc">{{ __trans('Product Name: Z-A') }}</option>
                                                                  </select>
                                                              </div>

                                                              <!-- Price Range Filter -->
                                                              <div class="mb-4">
                                                                  <label class="block text-sm font-medium text-gray-700">{{ __trans('Price Range') }}</label>
                                                                  <div class="flex space-x-2">
                                                                      <input type="number" placeholder="Min Price"
                                                                             class="flex-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                             wire:model="minPrice" />
                                                                      <input type="number" placeholder="Max Price"
                                                                             class="flex-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                                             wire:model="maxPrice" />
                                                                  </div>
                                                              </div>

                                                              <!-- Submit Button -->
                                                              <div class="space-x-2">

                                                                  <button wire:click="resetFilters" 
                                                                          class="reset_filter_btn inline-flex items-center justify-center shrink-0 font-semibold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-0 focus:shadow focus:ring-1 focus:ring-accent-700  text-light border border-transparent hover:bg-accent-hover px-5 py-0 h-12 text-sm font-semibold h-11 md:text-base">
                                                                      {{ __trans('Reset') }}
                                                                  </button>

                                                                  <button type="submit" 
                                                                          class="float-right inline-flex items-center justify-center shrink-0 font-semibold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-0 focus:shadow focus:ring-1 focus:ring-accent-700 bg-accent text-light border border-transparent hover:bg-accent-hover px-5 py-0 h-12 text-sm font-semibold h-11 md:text-base">
                                                                      {{ __trans('Apply Filters') }}
                                                                  </button>
                                                              </div>
                                                         </form>
                                                     </div>
                                                  </div>
                                               </aside>

                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="os-scrollbar os-scrollbar-horizontal os-theme-dark os-scrollbar-auto-hide os-scrollbar-auto-hide-hidden os-scrollbar-handle-interactive os-scrollbar-cornerless os-scrollbar-unusable">
                                      <div class="os-scrollbar-track">
                                         <div class="os-scrollbar-handle" style="width: 100%;"></div>
                                      </div>
                                   </div>
                                   <div class="os-scrollbar os-scrollbar-vertical os-theme-dark os-scrollbar-auto-hide os-scrollbar-auto-hide-hidden os-scrollbar-handle-interactive os-scrollbar-cornerless os-scrollbar-unusable">
                                      <div class="os-scrollbar-track">
                                         <div class="os-scrollbar-handle" style="height: 100%;"></div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </aside>
              </div>
           </div>
           @livewire('address-modal')
           @livewire('product-review-model')
        </div>
     </div>
  </div>