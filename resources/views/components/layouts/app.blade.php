<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    @include('partials.seo')

    <link rel="icon" href="{{  asset(__setting('fav_logo')) }}" type="image/png"> 

    {!! Cache::rememberForever('site-customizer', function () {
        return view('components.layouts.site-customizer')->render();
    }) !!}

    <link rel="stylesheet" href="{{ mix('assets/frontend/css/mix.css') }}">

    @livewireStyles
</head>
<body>

    <div id="__next">
        <div dir="ltr">
            <main class="{{ config('app.title') }}-version-undefined">   
                <div class="flex min-h-screen flex-col bg-gray-100 transition-colors duration-150">  
                    @livewire('header', [], key('header'))
                    
                    <!-- Page Content -->
                    <div class="min-h-screen">
                        {{ $slot }}
                    </div>

                    @livewire('mobile-navbar', [], key('mobile-navbar'))

                    <div wire:ignore>
                        @if (!request()->routeIs('frontend.home'))
                            @livewire('footer', [], key('footer'))
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts

    @livewire('mobile-header-filter', [], key('mobile-header-filter'))
    @livewire('notification-toast', [], key('notification-toast'))

    <script>
        
        var _app_base_url = '{{ url("/") }}';
        var _user_is_loggedin = {{ auth()->check() ? 'true' : 'false' }};

    </script>

    <script src="{{ mix('assets/frontend/js/mix.js') }}"></script>

    @yield('scripts')

    <script src="https://kit.fontawesome.com/76125ef05e.js" crossorigin="anonymous" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-center",
                timeOut: 5000,
                extendedTimeOut: 1000,
            };
        });
    </script>

</body>
</html>
