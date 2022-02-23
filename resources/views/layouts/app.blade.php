<!DOCTYPE html>
<html lang="en">
    <head>
        @include('includes.head')
        @section('css_global')
        @show
        @section('js_global')
        @show
        @section('css_app')
        @show
        @section('js_app')
        @show
    </head>
    <body>
        <!-- <div> -->
            <!-- sidebar -->
            @include('includes.sidebar')
            <!-- content -->
            @yield('content')
            <!-- footer -->
            @include('includes.footer')
        <!-- </div> -->
    </body>
        @section('plugin')
        @show
</html>
