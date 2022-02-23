<!DOCTYPE html>
<html lang="en" style="background-color:grey">

<head>
    @include('includes.head')
    @section('css_global')
    @show
    @section('css_app')
    @show
    @section('js_global')
    @show
    @section('js_app')
    @show
</head>

<body >
    <!-- Login form -->
    @yield('content')
</body>


@section('plugin')
@show
</html>