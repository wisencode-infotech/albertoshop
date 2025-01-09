<div class="flex w-full items-center justify-center px-6">
    <div class="flex w-full flex-col py-7 md:flex-row md:items-start justify-center">
        @foreach($orderStatuses as $statusKey => $statusName)
            <div class="progress-box_progress_container__n7Sm7">
                <div class="progress-box_progress_wrapper__JZ0Ia {{ $statusKey <= $currentStatus ? 'progress-box_checked__bYvuh' : '' }}">
                    <div class="progress-box_status_wrapper__Wemi0">
                        @if($statusKey <= $currentStatus)
                            <div class="h-4 w-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20.894" height="16" viewBox="0 0 20.894 16" class="w-full">
                                    <path data-name="checkmark" d="M169.184,175.473l-1.708-1.756a.367.367,0,0,0-.272-.116.352.352,0,0,0-.272.116l-11.837,11.925-4.308-4.308a.375.375,0,0,0-.543,0l-1.727,1.727a.387.387,0,0,0,0,.553l5.434,5.434a1.718,1.718,0,0,0,1.135.553,1.8,1.8,0,0,0,1.126-.534h.01l12.973-13.041A.415.415,0,0,0,169.184,175.473Z" transform="translate(-148.4 -173.6)" fill="currentColor"></path>
                                </svg>
                            </div>
                        @else
                            {{ $statusKey }}
                        @endif
                    </div>
                    <div class="progress-box_bar__pcoY4"></div>
                </div>
                <div class="flex flex-col items-start ltr:ml-5 rtl:mr-5 md:items-center ltr:md:ml-0 rtl:md:mr-0">
                    <span class="text-base font-semibold capitalize text-body-dark ltr:text-left rtl:text-right md:px-2 md:!text-center">
                        {{ $statusName }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
