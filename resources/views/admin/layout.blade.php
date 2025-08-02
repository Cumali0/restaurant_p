<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8"/>
    <title>@yield('title', 'Admin Paneli')</title>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}"/>
</head>
<body>

@include('admin.layouts.sidebar')
@include('admin.layouts.header')

<main>
    @yield('content')
</main>



</body>
</html>
