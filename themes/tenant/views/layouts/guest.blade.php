<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ url('favicon.png') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'themes/tenant') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'themes/tenant') }}" rel="stylesheet">

    <style>
        label {
          top: 0%;
          transform: translateY(-50%);
          font-size: 11px;
          color: rgba(37, 99, 235, 1);
        }
        .empty input:not(:focus) + label {
          top: 50%;
          transform: translateY(-50%);
          font-size: 14px;
        }
        input:not(:focus) + label {
          color: rgba(70, 70, 70, 1);
        }
        input {
          border-width: 1px;
        }
        input:focus {
          outline: none;
          border-color: rgba(37, 99, 235, 1);
        }
    </style>
</head>
<body class="h-screen font-sans antialiased leading-none bg-gray-100">
    <div id="app" class="w-full h-full flex">
        @yield('content')
    </div>
</body>
</html>
