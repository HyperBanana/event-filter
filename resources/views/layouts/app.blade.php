<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</head>

<body>
    @include('inc.navbar')
    <div class="container">
        @include('inc.messages')
        @yield('content')
    </div>
    @yield('scripts')
</body>

</html>
