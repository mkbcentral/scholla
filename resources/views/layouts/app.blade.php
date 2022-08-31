<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name','MASOMO')}}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('moment/moment.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @livewireStyles

    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">

            @include('layouts.partials.navbar')
            @include('layouts.partials.sidebar')

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
