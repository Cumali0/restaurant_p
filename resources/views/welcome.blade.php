<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<div class="container position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="#" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restaurant</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="#" class="nav-item nav-link active">Ev</a>
                <a href="#" class="nav-item nav-link">Hakkında</a>
                <a href="#" class="nav-item nav-link">Servis</a>
                <a href="#" class="nav-item nav-link">Menü</a>
                <a href="#" class="nav-item nav-link">Sayfalar</a>
                <a href="#" class="nav-item nav-link">İrtibat</a>
            </div>
            <a href="#" class="btn btn-primary py-2 px-4">Masa Ayırt</a>
        </div>
    </nav>
</div>

<!-- Hero Section -->
<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-3 text-white animated slideInLeft">Lezzetli Yemeğimizin <br>Tadını Çıkarın</h1>
                <p class="text-white animated slideInLeft mb-4 p-2">Kalite Paraya Değer</p>
                <a href="#" class="btn btn-primary py-sm-3 px-sm-5 slideInLeft" style="width: 150px;">Masa Ayırt</a>
            </div>
            <div class="col-lg-6 text-center text-end overflow-hidden">
                <img src="{{ asset('img/hero.png') }}" class="img-fluid" width="500" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- JS dosyanın çağrılması: -->
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
