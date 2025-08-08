

    @extends('admin.layouts.app')

    @section('title', 'Menü Yönetimi')

    @section('content')

        <div class="admin-menu-container">


            {{-- Kategoriye Göre Filtreleme --}}
            <form method="GET" action="{{ route('admin.menus.index') }}" class="mb-3 d-flex justify-content-center gap-2">
                <select name="category" class="form-select" onchange="this.form.submit()" style="max-width: 300px;">
                    <option value="">Tüm Kategoriler</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <noscript><button type="submit" class="btn btn-primary">Filtrele</button></noscript>
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

                    <div class="mt-3">{{ $menus->withQueryString()->links() }}</div>
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

    @endsection
