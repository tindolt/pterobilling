<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $title }} - {{ config('app.company_name') }}</title>
        @include('layouts.styles')
    </head>
    <body class="hold-transition layout-top-nav @if(config('app.dark_mode')) dark-mode @endif">
        <div class="wrapper">
            <!-- Navbar -->
            @include('layouts.store.nav')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @include('layouts.store.header')

                <!-- Main content -->
                <div class="content">
                    <div class="container">
                        @unless ($secure)
                            @include('layouts.store.secure')
                        @endunless
                        @include('layouts.store.announcement')
                        @include('layouts.store.messages')
                        @yield('content')
                    </div>
                </div>
            </div>

            <!-- Main Footer -->
            @include('layouts.store.footer')
        </div>

        @include('layouts.scripts')
    </body>
</html>
