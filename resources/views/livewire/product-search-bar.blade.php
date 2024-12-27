<div class="top-searchbar-section bg-white top-0 z-50 w-full transition-all border-b border-border-200 shadow-sm h-15 lg:h-22 is-scrolling" >
<!-- <div class="fixed inset-0 -z-10 h-[100vh] w-full bg-black/50 hidden"></div> -->
    <div>
        <div
            class="flex w-full transform-gpu items-center justify-between bg-light transition-transform duration-300 lg:h-22 lg:px-6 2xl:px-8 lg:absolute lg:border-0 lg:bg-transparent lg:shadow-none">

                <div class="lg:absolute top-0 z-20 flex h-full w-full items-center justify-center space-x-4 border-b-accent-300 bg-light px-5 py-1.5 ltr:left-0 rtl:right-0 rtl:space-x-reverse lg:border lg:bg-opacity-30">
                   <form wire:submit.prevent="applyFilters" class="w-full lg:max-w-3xl">
                        <div class="relative flex rounded md:rounded-lg h-11 md:h-12">
                            <label for="grocery-search-header" class="sr-only">{{ __trans('Search your products from here') }}</label>
                            
                            <input id="grocery-search-header" type="text" autocomplete="off" 
                                   class="search item-center flex h-full w-full appearance-none overflow-hidden truncate rounded-lg text-sm text-heading placeholder-gray-500 transition duration-300 ease-in-out focus:outline-0 focus:ring-0 search-minimal bg-gray-100 ltr:pl-10 rtl:pr-10 ltr:pr-4 rtl:pl-4 ltr:md:pl-14 rtl:md:pr-14 border border-transparent focus:border-accent focus:bg-light" 
                                   name="search" 
                                   placeholder="{{ __trans('Search your products from here') }}" 
                                   wire:model.live.debounce.250ms="search"
                                   wire:focus="$set('isFocused', true)"
                                   wire:blur="$set('isFocused', false)">

                             @if($search || $isFocused)
                                <button type="button" wire:click="clearSearch" class="clear-search absolute flex h-full w-10 items-center justify-center text-body transition-colors duration-200 hover:text-accent-hover focus:text-accent-hover focus:outline-0 ltr:right-0 rtl:left-0 md:w-14">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9l-6 6 1 1 6-6 6 6 1-1-6-6 6-6-1-1-6 6-6-6-1 1 6 6z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif       
                            
                            <button class="absolute flex h-full w-10 items-center justify-center text-body transition-colors duration-200 hover:text-accent-hover focus:text-accent-hover focus:outline-0 ltr:left-0 rtl:right-0 md:w-14">
                                <span class="sr-only">{{ __trans('Search') }}</span>
                                <svg viewBox="0 0 17.048 18" class="h-4 w-4">
                                    <path d="M380.321,383.992l3.225,3.218c.167.167.341.329.5.506a.894.894,0,1,1-1.286,1.238c-1.087-1.067-2.179-2.131-3.227-3.236a.924.924,0,0,0-1.325-.222,7.509,7.509,0,1,1-3.3-14.207,7.532,7.532,0,0,1,6,11.936C380.736,383.462,380.552,383.685,380.321,383.992Zm-5.537.521a5.707,5.707,0,1,0-5.675-5.72A5.675,5.675,0,0,0,374.784,384.513Z" transform="translate(-367.297 -371.285)" fill="currentColor"></path>
                                </svg>
                            </button>
                        </div>
                    </form> 

                    <button class="hide-on-mobile hide-on-medium products-filter flex h-8 items-center rounded border border-border-200 bg-gray-100 bg-opacity-90 py-1 px-3 text-sm font-semibold text-heading transition-colors duration-200 hover:border-accent-hover hover:bg-accent hover:text-light focus:border-accent-hover focus:bg-accent focus:text-light focus:outline-0 md:h-10 md:py-1.5 md:px-4 md:text-base h-12 md:h-12">
                      <svg width="18" height="14" class="ltr:mr-2 rtl:ml-2" viewBox="0 0 18 14">
                         <path d="M942.581,1295.564H925.419c-.231,0-.419-.336-.419-.75s.187-.75.419-.75h17.163c.231,0,.419.336.419.75S942.813,1295.564,942.581,1295.564Z" transform="translate(-925 -1292.064)" fill="currentColor"></path>
                         <path d="M942.581,1951.5H925.419c-.231,0-.419-.336-.419-.75s.187-.75.419-.75h17.163c.231,0,.419.336.419.75S942.813,1951.5,942.581,1951.5Z" transform="translate(-925 -1939.001)" fill="currentColor"></path>
                         <path d="M1163.713,1122.489a2.5,2.5,0,1,0,1.768.732A2.483,2.483,0,0,0,1163.713,1122.489Z" transform="translate(-1158.213 -1122.489)" fill="currentColor"></path>
                         <path d="M2344.886,1779.157a2.5,2.5,0,1,0,.731,1.768A2.488,2.488,0,0,0,2344.886,1779.157Z" transform="translate(-2330.617 -1769.425)" fill="currentColor"></path>
                      </svg>
                      {{ __trans('Filter') }}
                   </button>

                </div>

        </div>
    </div>
</div>