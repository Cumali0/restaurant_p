

    @extends('admin.layouts.app')

    @section('title', 'Menü Yönetimi')

    @section('content')

        <div class="admin-menu-container">


            {{-- Kategoriye Göre Filtreleme --}}
            <form method="GET" action="{{ route('admin.menus.index') }}" class="mb-3 d-flex gap-2 align-items-center flex-wrap">

                <input type="text" name="name" value="{{ request('name') }}" placeholder="Menu Adı" class="form-control" style="max-width: 200px;">

                <select name="category" class="form-control" style="max-width: 150px;">
                    <option value="">Kategori (Tümü)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>

                <input type="number" step="1" name="min_price" value="{{ request('min_price') }}" placeholder="Min Fiyat" class="form-control" style="max-width: 120px;">

                <input type="number" step="1" name="max_price" value="{{ request('max_price') }}" placeholder="Max Fiyat" class="form-control" style="max-width: 120px;">

                <button type="submit" class="btn btn-primary btn-sm">Filtrele</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary btn-sm">Temizle</a>
            </form>


            {{-- Başarılı işlem mesajı --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Menü içeriği --}}
            @if($mode == 'index')
                {{-- Menü Yönetimi Başlığı ve Yeni Yemek Ekle Butonu --}}
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap;">
                    <h1 style="flex: 1; text-align: center;">🍽️ Menü Yönetimi</h1>
                    <div style="text-align: right; flex: 1;">
                        <a href="{{ route('admin.menus.index', ['mode' => 'create']) }}" class="btn btn-success">+ Yeni Yemek Ekle</a>
                    </div>
                </div>

                @if($menus->isEmpty())
                    <div class="alert alert-info text-center">Henüz yemek eklenmemiş.</div>
                @else
                    <div class="menu-cards-container d-flex flex-wrap justify-content-start gap-3">
                        @foreach($menus as $menu)
                            <div class="menu-card" style="flex: 0 0 19%; min-width: 180px;">
                                <div class="card h-100">
                                    @if($menu->image)
                                        <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <span>Resim Yok</span>
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $menu->name }}</h5>
                                        <p class="card-text">{{ $menu->description ?? 'Açıklama yok.' }}</p>
                                        <p class="card-text">
                                            <strong>Kategori:</strong> {{ $menu->category ?? '-' }}<br>
                                            <strong>Fiyat:</strong> {{ number_format($menu->price, 2) }} ₺<br>
                                            <strong>Durum:</strong>
                                            @if($menu->active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Pasif</span>
                                            @endif
                                        </p>
                                    </div>

                                    <div class="card-footer d-flex justify-content-between">
                                        <a href="{{ route('admin.menus.index', ['mode' => 'edit', 'menu' => $menu->id]) }}" class="btn btn-warning btn-sm">Düzenle</a>
                                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Düzenlemek istediğinize emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Sil</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                @endif

            @elseif($mode == 'create' || $mode == 'edit')
                @php $isEdit = $mode == 'edit'; @endphp

                <h1>{{ $isEdit ? 'Yemek Düzenle' : 'Yeni Yemek Ekle' }}</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ $isEdit ? route('admin.menus.update', $menu) : route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Yemek Adı</label>
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{ old('name', $isEdit ? $menu->name : '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $isEdit ? $menu->description : '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Fiyat (₺)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="form-control"
                               value="{{ old('price', $isEdit ? $menu->price : '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <input type="text" name="category" id="category" class="form-control"
                               value="{{ old('category', $isEdit ? $menu->category : '') }}">
                    </div>

                    @if($isEdit && $menu->image)
                        <div class="mb-3">
                            <label>Mevcut Resim</label><br>
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" style="width: 120px; height: 90px; object-fit: cover; border-radius: 5px;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">Yemek Resmi</label>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control">
                        @if($isEdit)
                            <small class="form-text text-muted">Yeni resim yüklemek istersen seç.</small>
                        @endif
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="active" value="1" id="active" class="form-check-input"
                            {{ old('active', $isEdit ? $menu->active : true) ? 'checked' : '' }}>
                        <label for="active" class="form-check-label">Aktif</label>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Güncelle' : 'Kaydet' }}</button>
                    <a href="{{ route('admin.menus.index', ['mode' => 'index']) }}" class="btn btn-secondary">Geri Dön</a>
                </form>
            @endif
        </div>

        @push('styles')
            <style>
                /* Stil kuralları */
                /* ... (Buraya mevcut css'in gelecek) */
            </style>
        @endpush

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const deleteForms = document.querySelectorAll('form[action][method="POST"]');
                    deleteForms.forEach(form => {
                        form.addEventListener('submit', e => {
                            if (!confirm('Silmek istediğinize emin misiniz?')) {
                                e.preventDefault();
                            }
                        });
                    });
                });
            </script>
        @endpush


    @push('styles')
        <style>


            .menu-cards-container {
                gap: 1rem;
            }

            /* Responsive için flex-basis ayarları */
            @media (max-width: 1200px) {
                .menu-card {
                    flex: 0 0 24%;
                }
            }

            @media (max-width: 992px) {
                .menu-card {
                    flex: 0 0 32%;
                }
            }

            @media (max-width: 768px) {
                .menu-card {
                    flex: 0 0 48%;
                }
            }

            @media (max-width: 576px) {
                .menu-card {
                    flex: 0 0 100%;
                }
            }


            .admin-menu-container h1 {
                margin-bottom: 20px;
                color: #333;
            }

            .admin-menu-container table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }

            .admin-menu-container table thead {
                background-color: #007bff;
                color: white;
            }

            .admin-menu-container table th, .admin-menu-container table td {
                padding: 10px 12px;
                text-align: left;
                border: 1px solid #ddd;
                vertical-align: middle;
            }

            .admin-menu-container table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            /* Butonlar */
            .admin-menu-container .btn {
                padding: 6px 12px;
                border-radius: 4px;
                font-size: 14px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                border: none;
                transition: background-color 0.3s ease;
            }

            .admin-menu-container .btn-primary {
                background-color: #007bff;
                color: white;
            }
            .admin-menu-container .btn-primary:hover {
                background-color: #0056b3;
            }

            .admin-menu-container .btn-success {
                background-color: #28a745;
                color: white;
            }
            .admin-menu-container .btn-success:hover {
                background-color: #1e7e34;
            }

            .admin-menu-container .btn-warning {
                background-color: #ffc107;
                color: black;
            }
            .admin-menu-container .btn-warning:hover {
                background-color: #d39e00;
            }

            .admin-menu-container .btn-danger {
                background-color: #dc3545;
                color: white;
            }
            .admin-menu-container .btn-danger:hover {
                background-color: #bd2130;
            }

            .admin-menu-container .btn-secondary {
                background-color: #6c757d;
                color: white;
            }
            .admin-menu-container .btn-secondary:hover {
                background-color: #565e64;
            }

            /* Form alanları */
            .admin-menu-container input[type="text"],
            .admin-menu-container input[type="number"],
            .admin-menu-container textarea,
            .admin-menu-container input[type="file"] {
                width: 100%;
                padding: 8px 10px;
                margin-top: 5px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                font-size: 14px;
            }

            /* Checkbox */
            .admin-menu-container .form-check-input {
                margin-top: 0.3rem;
                margin-right: 5px;
                cursor: pointer;
            }

            /* Badge */
            .admin-menu-container .badge {
                padding: 5px 10px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 600;
            }

            .admin-menu-container .bg-success {
                background-color: #28a745;
                color: white;
            }

            .admin-menu-container .bg-secondary {
                background-color: #6c757d;
                color: white;
            }

            /* Responsive */
            @media(max-width: 768px) {
                .admin-menu-container table,
                .admin-menu-container thead,
                .admin-menu-container tbody,
                .admin-menu-container th,
                .admin-menu-container td,
                .admin-menu-container tr {
                    display: block;
                }
                .admin-menu-container thead tr {
                    display: none;
                }
                .admin-menu-container tr {
                    margin-bottom: 20px;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    padding: 10px;
                }
                .admin-menu-container td {
                    padding-left: 50%;
                    position: relative;
                    text-align: right;
                    border: none;
                    border-bottom: 1px solid #eee;
                }
                .admin-menu-container td::before {
                    position: absolute;
                    left: 15px;
                    width: 45%;
                    white-space: nowrap;
                    text-align: left;
                    font-weight: 600;
                    content: attr(data-label);
                }
            }

            .card-title {
                font-size: 20px;
                font-weight: bold;
            }
            .card-text {
                font-size: 14px;
            }
            .card-footer {
                background: #f9f9f9;
                border-top: 1px solid #ddd;
            }


            .menu-card-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 20px;
            }

            .menu-card {
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                height: 100%;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                transition: transform 0.2s ease-in-out;
            }

            .menu-card:hover {
                transform: scale(1.02);
            }

            .menu-card img {
                width: 100%;
                height: 150px;
                object-fit: cover;
            }

            .no-image {
                width: 100%;
                height: 150px;
                background: #f0f0f0;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #666;
            }

            .menu-content {
                padding: 10px 15px;
                flex: 1;
            }

            .menu-card-actions {
                padding: 10px 15px;
                display: flex;
                justify-content: space-between;
                border-top: 1px solid #eee;
                background: #fafafa;
            }

            .menu-card-actions form {
                display: inline;
            }

            .admin-menu-container {
                max-width: 1320px; /* veya istediğin max genişlik */
                margin: 0 auto; /* ortaya hizalamak için */

                width: 1320px;
                height: auto;
                padding: 20px;
                background: #fff;
                border-radius: 8px;
                box-sizing: border-box;
            }

            .menu-cards-container {
                display: flex;
                flex-wrap: wrap;
                gap: 15px; /* kartlar arası boşluk */
                justify-content: flex-start;
            }

            .menu-card {
                flex: 0 0 19%; /* 5 kart yan yana için yaklaşık */
                min-width: 180px; /* responsive için minimum genişlik */
                box-sizing: border-box;
            }




            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 20px;
            }

            .menu-container {
                max-width: 1300px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 20px;
            }

            .menu-card {
                background-color: #fff;
                border-radius: 16px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                display: flex;
                flex-direction: column;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .menu-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            }

            .menu-card img {
                width: 100%;
                height: 160px;
                object-fit: cover;
                border-bottom: 1px solid #eee;
            }

            .menu-content {
                padding: 16px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
            }

            .menu-title {
                font-size: 18px;
                font-weight: bold;
                margin: 0 0 8px;
                color: #333;
            }

            .menu-description {
                font-size: 14px;
                color: #777;
                margin-bottom: 12px;
                flex-grow: 1;
            }

            .menu-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .menu-price {
                font-size: 16px;
                font-weight: bold;
                color: #27ae60;
            }

            .menu-category {
                font-size: 13px;
                color: #999;
                background-color: #f1f1f1;
                padding: 2px 8px;
                border-radius: 12px;
            }

            /* Sayfalama kapsayıcı */
            .pagination {
                display: flex;
                justify-content: center;
                padding-left: 0;
                list-style: none;
                border-radius: 0.5rem;
                gap: 0.6rem;
            }

            .pagination {

                justify-content: center;
                padding-left: 0;
                list-style: none;
                border-radius: 0.5rem;
                user-select: none;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                display: flex !important;
                flex-wrap: nowrap !important;  /* tek satırda dizilsin */
                gap: 0.6rem;                   /* aradaki boşluk */
                overflow-x: visible !important; /* taşarsa scroll değil taşsın, scroll istemiyoruz */
            }

            /* Sayfa numarası butonları genel */
            .pagination li a,
            .pagination li span {
                color: #495057;
                background-color: #f8f9fa;
                border: 1.7px solid #dee2e6;
                padding: 9px 12px;
                text-decoration: none;
                font-weight: 700;
                border-radius: 50%;
                min-width: 44px;
                height: 44px;
                line-height: 26px;
                text-align: center;
                transition:
                    background-color 0.35s ease,
                    color 0.35s ease,
                    box-shadow 0.35s ease,
                    border-color 0.35s ease,
                    transform 0.3s ease;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-sizing: border-box;
                box-shadow: inset 0 0 5px #fff8; /* Hafif iç parlama */
            }

            /* Hover ve focus efektleri */
            .pagination li a:hover,
            .pagination li a:focus {
                background-color: #0d6efd;
                color: #fff;
                border-color: #0a58ca;
                box-shadow:
                    0 0 12px rgba(13, 110, 253, 0.7),
                    inset 0 0 8px rgba(255, 255, 255, 0.3);
                outline: none;
                transform: scale(1.1);
                z-index: 10;
            }

            /* Aktif sayfa */
            .pagination li.active span {
                background-color: #0d6efd;
                color: #fff;
                border-color: #0a58ca;
                cursor: default;
                box-shadow:
                    0 0 14px rgba(13, 110, 253, 0.85),
                    inset 0 0 10px rgba(255,255,255,0.4);
                font-weight: 900;
                transform: scale(1.15);
                z-index: 20;
            }

            /* Devre dışı butonlar */
            .pagination li.disabled span {
                color: #adb5bd;
                cursor: not-allowed;
                background-color: #e9ecef;
                border-color: #dee2e6;
                box-shadow: none;
                opacity: 0.6;
                user-select: none;

            }

            /* Önceki ve Sonraki butonlara özel stil */
            .pagination li:first-child a,
            .pagination li:last-child a {
                min-width: auto;               /* min-width kaldırıldı */
                padding: 8px 14px;
                border-radius: 24px;           /* Oval ve daha geniş */
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;                     /* Ok ile yazı arası boşluk */
                background-color: #0d6efd;
                color: #fff;
                border-color: #0a58ca;
                box-shadow:
                    0 0 14px rgba(13, 110, 253, 0.85),
                    inset 0 0 12px rgba(255,255,255,0.4);
                transition:
                    background-color 0.35s ease,
                    color 0.35s ease,
                    box-shadow 0.35s ease,
                    transform 0.3s ease;
                cursor: pointer;
            }

            .pagination li:first-child a:hover,
            .pagination li:last-child a:hover {
                background-color: #084298;
                border-color: #042f6c;
                box-shadow:
                    0 0 20px rgba(8, 66, 152, 0.95),
                    inset 0 0 15px rgba(255,255,255,0.6);
                transform: scale(1.1);
                z-index: 15;
            }

            /* Ok ikonları biraz daha net ve uyumlu */
            .pagination li:first-child a::before,
            .pagination li:last-child a::after {
                display: inline-flex;
                vertical-align: middle;
                width: 18px;
                height: 18px;
                content: '';
                background-size: contain;
                background-repeat: no-repeat;
                margin: 0;
                filter: drop-shadow(0 0 1px rgba(0,0,0,0.15));
            }

            /* Önceki: sola ok */
            .pagination li:first-child a::before {
                background-image: url('data:image/svg+xml;utf8,<svg fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>');
            }

            /* Sonraki: sağa ok */
            .pagination li:last-child a::after {
                background-image: url('data:image/svg+xml;utf8,<svg fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>');
            }

            /* Sayfa numarası butonlarıyla farklı görünmeleri için */
            .pagination li a:not(:first-child):not(:last-child),
            .pagination li span:not(:first-child):not(:last-child) {
                min-width: 44px;
                height: 44px;
                padding: 9px 12px;
                border-radius: 50%;
            }

            /* Responsive: küçük ekranlarda iyileştirmeler */
            @media (max-width: 768px) {
                .pagination {
                    gap: 0.6rem;
                }
                .pagination li a,
                .pagination li span {
                    min-width: 38px;
                    height: 38px;
                    padding: 8px 10px;
                    font-size: 0.9rem;
                }
                .pagination li:first-child a,
                .pagination li:last-child a {
                    border-radius: 20px;
                    padding: 7px 10px;
                    gap: 6px;
                }
                .pagination li:first-child a::before,
                .pagination li:last-child a::after {
                    width: 16px;
                    height: 16px;
                }
            }

            @media (max-width: 480px) {
                .pagination {
                    gap: 0.4rem;
                }
                .pagination li a,
                .pagination li span {
                    min-width: 32px;
                    height: 32px;
                    padding: 6px 8px;
                    font-size: 0.85rem;
                }
                .pagination li:first-child a,
                .pagination li:last-child a {
                    border-radius: 18px;
                    padding: 6px 8px;
                    gap: 5px;
                }
                .pagination li:first-child a::before,
                .pagination li:last-child a::after {
                    width: 14px;
                    height: 14px;
                }
            }

            /* Dokunmatik cihazlarda dokunma alanı artırıldı */
            .pagination li a,
            .pagination li span {
                touch-action: manipulation;
            }









            @keyframes bounce {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-8px);
                }
            }

            .pagination li a:hover,
            .pagination li a:focus {
                animation: bounce 0.5s ease forwards;
                color: #0d6efd;
                border-color: #0d6efd;
                background-color: #e7f1ff;
            }

            /* Aktif sayfa gölge ve renk */
            .pagination li.active span {
                background-color: #0d6efd;
                color: white;
                border-color: #0a58ca;
                box-shadow: 0 0 12px rgba(13, 110, 253, 0.7);
                font-weight: 800;
            }





        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Silme işlemi onayı
                const deleteForms = document.querySelectorAll('form[action][method="POST"]');
                deleteForms.forEach(form => {
                    form.addEventListener('submit', e => {
                        const confirmed = confirm('Silmek istediğinize emin misiniz?');
                        if (!confirmed) {
                            e.preventDefault();
                        }
                    });
                });
            });
        </script>
    @endpush
        <div style="margin-top: 15px;">
            {{ $menus->links('pagination::bootstrap-5') }}
        </div>
    @endsection
