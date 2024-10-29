<div class="p-4 sm:p-8 bg-gray-50 min-h-screen flex items-center justify-center">
   <div class="w-full max-w-screen-md bg-white rounded-lg shadow-lg p-6">
      
      <div class="text-center mb-8">
         <h1 class="text-4xl font-bold text-red-600">{{ __trans('Payment Error') }}</h1>
         <p class="text-gray-600 mt-2">{{ __trans('There was an issue with your payment. Please review the details below.') }}</p>
      </div>

      <div class="mb-6 text-left">
         <a wire:navigate href="{{ route('frontend.home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-500">
            <svg width="1em" height="1em" viewBox="0 0 20 20" fill="currentColor" class="inline">
               <path d="M18.5166 8.82913C18.5161 8.82872 18.5156 8.82817 18.5152 8.82776L11.1719 1.48546C10.8589 1.17235 10.4428 1 10.0001 1C9.55745 1 9.1413 1.17235 8.82816 1.48546L1.48868 8.82405C1.48621 8.82652 1.4836 8.82913 1.48127 8.8316C0.838503 9.47801 0.839602 10.5268 1.48443 11.1716C1.77903 11.4663 2.16798 11.6368 2.584 11.6548C2.60103 11.6565 2.61806 11.6573 2.63522 11.6573H2.92776V17.0606C2.92776 18.13 3.79797 19 4.86746 19H7.7404C8.0317 19 8.2678 18.7638 8.2678 18.4727V14.2363C8.2678 13.7484 8.66486 13.3515 9.15283 13.3515H10.8474C11.3354 13.3515 11.7323 13.7484 11.7323 14.2363V18.4727C11.7323 18.7638 11.9684 19 12.2597 19H15.1326C16.2022 19 17.0723 18.13 17.0723 17.0606V11.6573H17.3437C17.7862 11.6573 18.2024 11.4849 18.5156 11.1717C19.1612 10.526 19.1614 9.47527 18.5166 8.82913ZM17.7697 10.426C17.6559 10.5398 17.5045 10.6026 17.3437 10.6026H16.5449C16.2536 10.6026 16.0175 10.8387 16.0175 11.1299V17.0606C16.0175 17.5484 15.6206 17.9453 15.1326 17.9453H12.7871V14.2363C12.7871 13.1669 11.917 12.2968 10.8474 12.2968H9.15283C8.08321 12.2968 7.213 13.1669 7.213 14.2363V17.9453H4.86746C4.37962 17.9453 3.98256 17.5484 3.98256 17.0606V11.1299C3.98256 10.8387 3.74647 10.6026 3.45516 10.6026H2.67011C2.66187 10.6021 2.65377 10.6016 2.64539 10.6015C2.48827 10.5988 2.3409 10.5364 2.23047 10.4259C1.99562 10.191 1.99562 9.80884 2.23047 9.57387C2.23061 9.57387 2.23061 9.57373 2.23075 9.57359L2.23116 9.57318L9.5742 2.23116C9.68792 2.11731 9.83914 2.05469 10.0001 2.05469C10.1609 2.05469 10.3121 2.11731 10.426 2.23116L17.7674 9.57167C17.7685 9.57277 17.7697 9.57387 17.7708 9.57497C18.0045 9.81021 18.004 10.1916 17.7697 10.426Z" />
            </svg>
            {{ __trans('Back to Home') }}
         </a>
      </div>

      <div class="p-6 rounded-lg border bg-gray-50 shadow-inner text-gray-700">
         <div class="mb-4">
            <span class="font-bold text-lg text-gray-800">{{ __trans('Status') }}:</span> {{ $status }}
         </div>
         <div class="mb-4">
            <span class="font-bold text-lg text-gray-800">{{ __trans('Order ID') }}:</span> {{ $orderId }}
         </div>
         <div>
            <span class="font-bold text-lg text-gray-800">{{ __trans('Error Message') }}:</span>
            <p class="mt-1 text-sm text-gray-600">{{ $message }}</p>
         </div>
      </div>
   </div>
</div>
