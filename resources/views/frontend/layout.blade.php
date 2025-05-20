<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.head')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    @stack('css_bot')
</head>

<body class="animsition">
    <div class="econmerce-content">
        <x-menu-component></x-menu-component>
        
        @yield('content')
    </div>
    @include('frontend.footer')
</body>
@stack('js_bot')
</html>
