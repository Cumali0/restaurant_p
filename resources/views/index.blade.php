<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">
</head>

<body>
<!-- Navbar -->
<div class="container-xxl position-relative p-0">
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
            <a href="#" class="btn btn-primary py-2 px-4">MasaAyırt</a>
        </div>
    </nav>
</div>

<!-- Hero Section -->
<div class="container-xxl py-5 bg-dark hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start"></div>
            <h1 class="display-3 text-white animated slinderInLeft">Lezzetli Yemeğimizin <br>Tadını Çıkarın</h1>
            <p class="text-white animated slinderInLeft mb-4 p-2">Kalite Paraya Değer </p>
            <a href="#" class="btn btn-primary py-sm-3 px-sm-5 slinderInLeft">Masa Ayırt</a>
        </div>
        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
            <img src="img/hero.png" class="img-fluid" width="500px" alt="">
        </div>
    </div>
</div>
</div>
</div>

<!--navbar & hero Ends-->

<!--Service Section State-->

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInup" data-wow-delay="0.1s">
                <div class="p-4">
                    <div class="row g-4">
                        <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                        <h5>Usta Aşçılar</h5>
                        <p>Yılların tecrübesiyle, damaklarda unutulmaz tatlar yaratıyoruz</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 wow fadeInup">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                        <h5>Kaliteli Aşçılar</h5>
                        <p>Deneyimli ve tutkulu şeflerimiz, her yemeği sanat eserine dönüştürüyor.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInup">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-cart-plus  text-primary mb-4"></i>
                        <h5>Kaliteli Yemek</h5>
                        <p>Her lokmada tazelik ve özenle hazırlanan eşsiz lezzetler</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInup">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                        <h5>7/24 servis</h5>
                        <p>Kalite lezzetin adresi degilmidir zateno yüzden kaliteli yiyin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Service Section  End-->

<!--About Section State -->


<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6 text-start">
                        <img class="img-gluid rounded w-100 wow zoomIn" src="img/about-1.jpg" alt="">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-gluid rounded w-75 wow zoomIn cumali " src="img/about-2.jpg" style="margin: top 25%;" alt="">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-gluid rounded w-75 wow zoomIn" src="img/about-3.jpg"  alt="">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-gluid rounded w-100 wow zoomIn" src="img/about-4.jpg"  alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h5 class="Section-title ff-secondary text-start text-primary fw-normal">Hakkımızda</h5>
                <h1 class="mb-4">Restorana<i class="fa fa-utensils text-primary me-2"></i>Hoşgeldiniz</h1>
                <p class="mb-4"> Sizlere en taze malzemelerle hazırladığımız enfes lezzetlerimizi sunmak ve keyifli bir yemek deneyimi yaşatmak için buradayız. Afiyetle, güzel anılar biriktirmeniz dileğiyle.</p>
                <p class="mb-4">Çıkın çıkın gelin buraya mükemmel</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-primary px-3x">
                            <h1 class="flex-shrink-0 display-5 text-primary mb-0">15</h1>
                            <div class="ps-4">
                                <p class="mb-0">Yılların</p>
                                <h6 class="text-uppercase mb-0">Deneyimi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center border-start border-5 border-primary px-3x">
                            <h1 class="flex-shrink-0 display-5 text-primary mb-0">50</h1>
                            <div class="ps-4">
                                <p class="mb-0">Popüler</p>
                                <h6 class="text-uppercase mb-0">Usta Aşçılar</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <a href="" class="btn btn-primary py-3 px-5 mt-2"></a>
            </div>
        </div>
    </div>
</div>

<!--About Section End -->

<!--Menu Section State -->

<div class="container --xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInup">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">Yemek Menüsü</h5>
            <h1 class="mb-5">En Popüler Ürünler</h1>
        </div>
        <div class="tab-class text-center wow fadeInup" data-wow-delay="0.1s">
            <ul class="nav nav-pills d-inline-flex justify-content-center  border-bottom mb-5 ">
                <li class="nav-item">
                    <a href="" class="d-flex align-items-center text-start mx-3 pb-3"></a>
                    <i class="fa fa-bread-slice fa-2x text-primary"></i>
                    <div class="ps-1">
                        <small class="text-body">Güzel</small>
                        <h6 class="mt-n1 mb-0">Kahvaltı</h6>

                    </div>
                <li class="nav-item">
                    <a href="" class="d-flex align-items-center text-start mx-3 pb-3"></a>
                    <i class="fa fa-hamburger fa-2x text-primary"></i>
                    <div class="ps-1">
                        <small class="text-body">Özel</small>
                        <h6 class="mt-n1 mb-0">Öğle </h6>

                    </div>

                </li>
                <li class="nav-item">
                    <a href="" class="d-flex align-items-center text-start mx-3 pb-3"></a>
                    <i class="fa fa-utensils fa-2x text-primary"></i>
                    <div class="ps-1">
                        <small class="text-body">Popüler</small>
                        <h6 class="mt-n1 mb-0"> Akşam </h6>

                    </div>

                </li>
            </ul>
            <div class="teb-content">
                <div class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-1.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Tavuk Burger</span>
                                        <span class="text-primary">159TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        %100 tavuk göğsünden hazırlanan crispy köfte, susamlı ekmek, taze marul, domates, turşu, özel burger sosu ve cheddar peyniri ile servis edilen lezzetli Tavuk Burger.(Menüye kola + patates dahildir.)
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-2.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Et Burger</span>
                                        <span class="text-primary">249TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        %100 dana etinden hazırlanan crispy köfte, susamlı ekmek, taze marul, domates, turşu, özel burger sosu ve cheddar peyniri ile servis edilen lezzetli Chicken Burger.(Menüye kola + patates dahildir.)
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-3.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Pepperoni Pizza</span>
                                        <span class="text-primary">199TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        İnce açılmış hamur üzerine mozzarella, pepperoni, mantar ve özel domates sosu ile taş fırında pişirilen lezzetli Pepperoni Pizza.(Menüye kola dahildir.)
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-4.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Sezar Salata</span>
                                        <span class="text-primary">249TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        Izgara tavuk, parmesan peyniri, kruton ve özel Caesar sosu ile hazırlanan hafif ve doyurucu Sezar Salata.
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-5.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Spaghetti Bolognese</span>
                                        <span class="text-primary">179TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        Spagetti üzerine bol domates sosu ve parmesan peyniriyle sunulan klasik İtalyan Spaghetti Bolognese.(Menüye kola dahildir.)
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-6.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">>
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Mantı</span>
                                        <span class="text-primary">150TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        Yoğurtlu sarımsaklı sos ve tereyağlı biber sosu ile servis edilen geleneksel Mantı.
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-7.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Musakka</span>
                                        <span class="text-primary">100TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        Fırında pişirilmiş, beşamel soslu, kıymalı ve patates katmanlarıyla hazırlanan nefis Musakka.
                                    </small>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <img src="img/menu-8.jpg" class="flex-shrink-0 img-fluid rounded" alt="" style="max-width: 200px; height: 200px">
                                <div class="w-100 d-flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                        <span>Sushi Roll</span>
                                        <span class="text-primary">199TL</span>
                                    </h5>
                                    <small class="fst-italic">
                                        Taze somon fileto, avokado, salatalık ve krem peynirle hazırlanan, susamlı nori yaprağına sarılı leziz Salmon Sushi Roll.
                                    </small>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--Menu Section End -->

<!--Reservation Section Start-->
<div class="container-xxl py-5 px-0 wow fadeInup">
    <div class="row g-0">
        <div class="col-md-6">
            <div class="video">
                <button type="button" class="btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videomodal">
                    <span></span>

                </button>

            </div>
        </div>
        <div class="col-md-6 bg-dark align-items-center">
            <div class="p-5">
                <h5 class="section-title ff-secondary text-start text-primary fw-normal">
                    Rezarvasyon

                </h5>
                <h1 class="text-white mb-4">Online Masa Kaydı</h1>
                <form action="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form floating">
                                <input type="text" class="form-control" id="name" placeholder="Ad">
                                <label for="name">Your Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form floating">
                                <input type="text" class="form-control" id="email" placeholder="Soyad">
                                <label for="name">Your Email</label>
                            </div>
                        </div>
                        div class="col-md-6">
                        <div class="form floating date" id="date3">
                            <input type="text" class="form-control" id="email" placeholder="Date & Time" data-target="#date3" data-toggle="datetimpicker" itemid="datetime">
                            <label for="name">Date & Time</label>
                        </div>
                    </div>
            </div>


            </form>

        </div>
    </div>
</div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
