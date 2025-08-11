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
                <a href="#hakkimiz-section" class="nav-item nav-link">Hakkında</a>
                <a href="#" class="nav-item nav-link">Servis</a>
                <a href="#menu-section" class="nav-item nav-link">Menü</a>
                <a href="#" class="nav-item nav-link">Sayfalar</a>
                <a href="#irtibat-section" class="nav-item nav-link">İrtibat</a>
            </div>
            <a href="#" class="btn btn-primary py-2 px-4">MasaAyırt</a>
        </div>
    </nav>
</div>

<!-- Hero Section -->
<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container my-5 py-5">
        <div class="row align-items-center g-5 register-tr">
            <div class="col-lg-6 text-center text-lg-start"></div>
            <h1 class="display-3 text-white animated slinderInLeft me-2">Lezzetli Yemeğimizin <br>Tadını Çıkarın</h1>
            <p class="text-white animated slinderInLeft mb-4 p-2 ms-4">Kalite Paraya Değer </p>
            <a href="#" id="reserveBtn" class="btn btn-primary py-sm-3 px-sm-5 slinderInLeft ms-4" style="width: 20%;">Masa Ayırt</a>
        </div>
        <div class="text-center text-lg-end overflow-hidden">

            <img src="{{ asset('img/hero.png') }}" class="img-fluid" width="500px" alt="">
        </div>
    </div>
</div>



<!--navbar & hero Ends-->

<!--Service Section State-->

<div class="container py-5">
    <div class="container">
        <div class="row g-4">

            <!-- 1. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                        <h5>Usta Aşçılar</h5>
                        <p>Yılların tecrübesiyle, damaklarda unutulmaz tatlar yaratıyoruz</p>
                    </div>
                </div>
            </div>

            <!-- 2. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                        <h5>Kaliteli Aşçılar</h5>
                        <p>Deneyimli ve tutkulu şeflerimiz, her yemeği sanat eserine dönüştürüyor.</p>
                    </div>
                </div>
            </div>

            <!-- 3. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                        <h5>Kaliteli Yemek</h5>
                        <p>Her lokmada tazelik ve özenle hazırlanan eşsiz lezzetler</p>
                    </div>
                </div>
            </div>

            <!-- 4. Kutu -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp">
                <div class="service-item rounded pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                        <h5>7/24 Servis</h5>
                        <p>Kalite lezzetin adresi değil midir? O yüzden kaliteli yiyin.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!--Service Section  End-->

<!--About Section State -->


<div class="container py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6 text-start">
                        <img class="img-gluid rounded w-100 wow zoomIn" src="{{ asset('img/about-1.jpg') }}" alt="">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-75 wow zoomIn cumali" src="{{ asset('img/about-2.jpg') }}" style="margin-top: 25%;" alt="">

                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-75 wow zoomIn" src="{{ asset('img/about-3.jpg') }}" alt="">

                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid rounded w-100 wow zoomIn" src="{{ asset('img/about-4.jpg') }}" alt="">

                    </div>
                </div>
            </div>
            <div id="hakkimiz-section" class="col-lg-6">
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

<div class="container py-5">
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
            <div id="menu-section" class="teb-content">
                <div class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        @foreach($menus as $menu)
                            <link rel="stylesheet" href="/css/style.css">
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" class="flex-shrink-0 img-fluid rounded hover-tilt" alt="{{ $menu->name }}" style="max-width: 200px; height: 200px; ">
                                    @endif
                                    <div class="w-100 d-flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>{{ $menu->name }}</span>
                                            <span class="text-primary">{{ number_format($menu->price, 2) }} TL</span>
                                        </h5>
                                        <small class="fst-italic">
                                            {{ $menu->description }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--Menu Section End -->

<!--Reservation Section Start-->

<div id="reservation" class="container py-5 px-0 wow fadeInUp">
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
                    Rezervasyon
                </h5>
                <h1 class="text-white mb-4">Online Masa Kaydı</h1>
                <form id="reservationForm" action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Ad -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ad" required>
                                <label for="name">Ad</label>
                            </div>
                        </div>
                        <!-- Soyad -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad" required>
                                <label for="surname">Soyad</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-posta Adresi" required>
                                <label for="email">E-posta Adresi</label>
                            </div>
                        </div>

                        <!-- Tarih & Saat -->
                        <div class="col-md-6">
                            <div class="form-floating date" id="date3">
                                <input type="text" class="form-control" id="datetimepicker" name="datetime" placeholder="Date & Time" required autocomplete="off">
                                <label for="datetimepicker">Tarih & Saat</label>
                            </div>
                        </div>
                        <!-- Kişi Sayısı -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="people" name="people" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }} Kişi</option>
                                    @endfor
                                </select>
                                <label for="people">Kişi Sayısı</label>
                            </div>
                        </div>

                        <!-- Masalar Dinamik Listesi -->
                        <div class="col-12" id="tables-container" style="margin-top: 15px; display: flex;">
                            <p class="text-white">Lütfen önce tarih ve saati seçiniz.</p>
                        </div>

                        <!-- Seçilen masa id'si gizli input -->
                        <input type="hidden" id="selected_table_id" name="table_id" />

                        <!-- Özel İstek -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="message" name="message" placeholder="Özel İstek" style="height: 100px;"></textarea>
                                <label for="message">Özel İstek</label>
                            </div>
                        </div>
                        <!-- Gönder -->
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Şimdi Rezervasyon Yap</button>
                        </div>

                        <div class="col-12 mt-2">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
                <div id="reservationResult"></div>
            </div>
        </div>
    </div>
</div>

<!--Reservation Section End-->

<!--Team Section Start-->

<div class="container pt-5 pb-3">
    <div class="container">
        <div class="text-center wow fadeInup">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">
                Ekip Üyeleri
            </h5>
            <h1 class="mb-5">Usta Şeflerimiz</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 wow fadeInup register-clove">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-1.jpg') }}" alt="">

                    </div>
                    <h5 class="mb-0">Zafer Şef</h5>
                    <small>Yardımcı Aşçı</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 wow fadeInup">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-2.jpg') }}" alt="">

                    </div>
                    <h5 class="mb-0">Mehmet Şef</h5>
                    <small>Aşçı</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>

                </div>

            </div>
            <div class="col-lg-3 col-md-6 wow fadeInup">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-3.jpg') }}" alt="">

                    </div>
                    <h5 class="mb-0">Soner Şef</h5>
                    <small>Baş Aşçı</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>

                </div>

            </div>
            <div class="col-lg-3 col-md-6 wow fadeInup">
                <div class="team-item text-center rounded overflow-hidden">
                    <div class="rounded-circle overflow-hidden m-4">
                        <img class="img-fluid" src="{{ asset('img/team-4.jpg') }}" alt="">


                    </div>
                    <h5 class="mb-0">Danilo Şef</h5>
                    <small>Gurme</small>
                    <div class="d-flex justify-content-center mt-3">
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>





<!--Team Section End -->

<!--Fotter Section Start-->
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeInUp">
    <div class="container py-5">
        <div class="row g-5">

            <!-- Şirket -->
            <div class="col-lg-3 col-md-6">
                <h4 id="company-title"  class="section-title ff-secondary text-start text-primary fw-normal mb-4">ŞİRKET</h4>
                <a href="" class="btn btn-link">Hakkımızda</a>
                <a href="" class="btn btn-link">Bize Ulaşın</a>
                <a href="" class="btn btn-link">Rezarvasyon</a>
                <a href="" class="btn btn-link">Hakkında</a>
                <a href="" class="btn btn-link">Takımların & Durumu</a>
            </div>

            <!-- Bağlantı -->
            <div id="irtibat-section"  class="col-lg-3 col-md-6">
                <h4  id="company-title"  class="section-title ff-secondary text-start text-primary fw-normal mb-4">Bağlantı</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt"></i> Merkez : Çarşı Mah. Tabakhane Sok.No:14 Ortahisar / Trabzon</p>
                <p class="mb-2"><i class="fa fa-phone-alt"></i> Tel :0542 361 78 45</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i> yemek@gmail.com</p>
                <div class="d-flex pt-2">
                    <a href="" class="btn btn-outline-light btn-social"><i class="fab fa-twitter"></i></a>
                    <a href="" class="btn btn-outline-light btn-social"><i class="fab fa-facebook-f"></i></a>
                    <a href="" class="btn btn-outline-light btn-social"><i class="fab fa-youtube"></i></a>
                    <a href="" class="btn btn-outline-light btn-social"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Açılış -->
            <div  class="col-lg-3 col-md-6">
                <h4 id="company-title"  class="section-title ff-secondary text-start text-primary fw-normal mb-4">Açılış</h4>
                <h5 class="text-light fw-normal">Pazartesi - Cumartesi</h5>
                <p>09:00 - 21:00</p>
                <h5 class="text-light fw-normal">Pazar</h5>
                <p>10:00 - 20:00</p>
            </div>

            <!-- Haber Bülteni -->
            <div  class="col-lg-3 col-md-6">
                <h4 id="company-title"  class="section-title ff-secondary text-start text-primary fw-normal mb-4">Haber Bülteni</h4>
                <div class="input-group mx-auto" style="max-width: 400px;">
                    <input type="text" class="form-control border-primary py-3 ps-4" placeholder="E-posta adresiniz">
                    <button class="btn btn-primary px-4">Kayıt Ol</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Copyright -->
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center mb-3 mb-md-0 col-lg-12">
                    <a href="" class="border-bottom">Sitede adınız, tüm haklarınız saklıdır.</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>

<script>





        document.addEventListener('DOMContentLoaded', function() {
            // flatpickr instance (global-like)
            const datetimeInput = document.getElementById('datetimepicker');
            let fpInstance = flatpickr(datetimeInput, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                locale: "tr",
                enable: [
                    function(date) { return date.getDay() >= 0 && date.getDay() <= 6; }
                ],
                onReady: function(selectedDates, dateStr, instance) {
                    updateTimeLimits(instance);
                },
                onClose: function(selectedDates, dateStr, instance) {
                    updateTimeLimits(instance);
                    if (dateStr) {
                        fetchAvailableTables(dateStr);
                    } else {
                        clearTables();
                    }
                }
            });

            function updateTimeLimits(fpInstance) {
                const selectedDate = fpInstance.selectedDates[0];
                if (!selectedDate) {
                    fpInstance.set('minTime', "09:00");
                    fpInstance.set('maxTime', "21:00");
                    return;
                }
                const day = selectedDate.getDay();
                if (day === 0) { // Pazar
                    fpInstance.set('minTime', "10:00");
                    fpInstance.set('maxTime', "20:00");
                } else {
                    fpInstance.set('minTime', "09:00");
                    fpInstance.set('maxTime', "21:00");
                }
            }

            const tablesContainer = document.getElementById('tables-container');
            let selectedTableId = null;

            function fetchAvailableTables(datetime) {
                const duration = 90;
                console.log("fetchAvailableTables çağrıldı:", datetime);

                fetch(`/tables-availability?datetime=${encodeURIComponent(datetime)}&duration=${duration}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log("Masalar geldi:", data);
                        tablesContainer.innerHTML = '';
                        selectedTableId = null;
                        const selectedInput = document.getElementById('selected_table_id');
                        if (selectedInput) selectedInput.value = '';

                        if (data.error) {
                            tablesContainer.innerHTML = `<p class="text-danger">${data.error}</p>`;
                            return;
                        }

                        if ((!data.available || data.available.length === 0) && (!data.booked || data.booked.length === 0)) {
                            tablesContainer.innerHTML = `<p class="text-white">Bu tarihte hiç masa bulunmamaktadır.</p>`;
                            return;
                        }

                        // Boş masalar
                        (data.available || []).forEach(table => {
                            const div = document.createElement('div');
                            div.className = 'table available';
                            div.textContent = 'Masa ' + table.name;
                            div.style.cursor = 'pointer';
                            div.onclick = () => selectTable(table.id, div);
                            tablesContainer.appendChild(div);
                        });

                        // Dolu masalar (kırmızı / seçilemez)
                        (data.booked || []).forEach(table => {
                            const div = document.createElement('div');
                            div.className = 'table booked';
                            div.textContent = 'Masa ' + table.name;
                            div.style.opacity = '0.6';
                            // booked masalara onclick koymuyoruz (seçilemez)
                            tablesContainer.appendChild(div);
                        });
                    })
                    .catch(err => {
                        console.error(err);
                        tablesContainer.innerHTML = '<p class="text-danger">Masalar yüklenemedi, lütfen tekrar deneyin.</p>';
                    });
            }

            function selectTable(id, element) {
                if (element.classList.contains('booked')) return; // dolu masa seçilemez

                const selectedInput = document.getElementById('selected_table_id');

                if (selectedTableId === id) {
                    selectedTableId = null;
                    element.classList.remove('selected');
                    if (selectedInput) selectedInput.value = '';
                } else {
                    selectedTableId = id;
                    document.querySelectorAll('.table.selected').forEach(el => el.classList.remove('selected'));
                    element.classList.add('selected');
                    if (selectedInput) selectedInput.value = id;
                }
            }

            function clearTables() {
                tablesContainer.innerHTML = '<p class="text-white">Lütfen önce tarih ve saati seçiniz.</p>';
                selectedTableId = null;
                const selectedInput = document.getElementById('selected_table_id');
                if (selectedInput) selectedInput.value = '';
            }

            // Form submit handler
            const reservationForm = document.getElementById('reservationForm');
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                // ÖNEMLİ: datetime değerini reset'ten önce al
                const datetimeValue = (fpInstance && fpInstance.input && fpInstance.input.value) ? fpInstance.input.value.trim() : (document.getElementById('datetimepicker').value || '').trim();
                console.log('Gönderilen datetime:', datetimeValue);

                // Zorunlu alan kontrolü
                if (!formData.get('table_id') || !formData.get('datetime')) {
                    document.getElementById('reservationResult').innerHTML =
                        '<p style="color:red;">Lütfen masa ve tarih/saat seçiniz.</p>';
                    return;
                }

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })







                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            });


                            form.reset();
                            document.getElementById('selected_table_id').value = '';
                            clearTables();


                            // Tarih ve saati al, sonra masaları yeniden yükle
                            const datetime = document.getElementById('datetimepicker').value;
                            if(datetime) {
                                fetchAvailableTables(datetime);
                            } else {
                                console.log("clearTables çağrılıyor");
                                clearTables();
                            }

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: data.message || 'Rezervasyon yapılamadı.',
                                showConfirmButton: true
                            });
                        }
                    })

                    .catch(() => {
                        document.getElementById('reservationResult').innerHTML =
                            '<p style="color:red;">Sunucu hatası oluştu.</p>';
                    });
            });













            // Sayfa açılışında temiz göster
            clearTables();




        });


</script>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>
