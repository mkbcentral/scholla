<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name','MASOMO')}}</title>
        @if (config('app.env')=='production')
            <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/logo.jpg') }}">
            <link rel="stylesheet" href="{{ asset('public/build/assets/app.6ccd8cd5.css') }}">
            <link rel="stylesheet" href="{{ asset('public/build/assets/app.eb801204.css') }}">
            <link rel="stylesheet" href="{{ asset('public/chargement.css') }}">
            <script src="{{ asset('public/build/assets/app.78935d82.js') }}"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.1/css/all.min.css"
                 integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg=="
                 crossorigin="anonymous" referrerpolicy="no-ferrer" />
        @else
            <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('logo.jpg') }}">
            <link rel="stylesheet" href="{{ asset('chargement.css') }}">
            @vite(['resources/css/app.css', 'resources/js/app.js'])

        @endif
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @livewireStyles

    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">

            @include('layouts.partials.navbar')
           @livewire('application.navigation.application-link-menu-sub')
            <div class="content-wrapper">
                <div class="content">
                    <div class="card">
                        <div class="card-body">
                            {{$slot}}
                        </div>
                    </div>
                </div>

            </div>
            @auth
                @include('layouts.partials.sidebar-control')
            @endauth

            @include('layouts.partials.footer')

        </div>
        @livewireScripts
    </body>
</html>
