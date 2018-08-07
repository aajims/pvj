<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <link rel="shortcut icon" type="image/png" href="public/favicon.png"/>-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paypro Merchant Portal</title>{{--
<!--    <link rel="stylesheet" href="{{ asset('js/components/img/favicon.png') }}"/>-->
    <link rel="shortcut icon" href="{{{ public('favicon.png') }}}"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <script>
        function asset() {
            return "{{ asset('') }}";
        }
        function appName() {
            return "{{ config('app.name') }}";
        }
        function baseUrl() {
            return "{{ url('/') }}";
        }
        function apiUrl() {
            return "{{ url('/api/') }}";
        }
        function currentUrl() {
            return "{{ url()->current() }}";
        }
    </script>
</head>
<body>
    <div id="app"></div>{{--
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
