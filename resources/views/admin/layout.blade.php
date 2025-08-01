<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Admin Paneli')</title>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}" />
</head>
<body>

@include('admin.partials.sidebar')
@include('admin.partials.header')

<main>
    @yield('content')
</main>

<script src="{{ asset('admin/js/index.js') }}"></script>
<script src="{{ asset('admin/js/order.js') }}"></script>
</body>
</html>
