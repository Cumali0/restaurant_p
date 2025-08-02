<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}" />
</head>
<body>

<div class="container">

    @include('admin.layouts.header')

    @include('admin.layouts.sidebar')

    <main>
        @yield('content')
    </main>

</div> <!-- container sonu -->

<!-- JS Dosyaları -->

<script src="{{ asset('admin/js/index.js') }}"></script>

</body>
</html>
