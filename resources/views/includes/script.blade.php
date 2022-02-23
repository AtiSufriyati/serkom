@section('css_global')
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/auth.css">
@endsection

@section('js_global')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('assets/js/blockui.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert/sweetalert.min.js') }}"></script>

@endsection

@section('css_app')
<link rel="stylesheet" href="css/serkom.css">

@endsection

@section('js_app')
<script src="{{ asset('js/pages/serkom.js') }}"></script>
@endsection

