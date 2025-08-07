@extends('admin.layouts.app')

@section('title', 'Profilim')

@section('content')
    <div class="container" style="max-width: 600px;">
        <h2>👤 Profil Güncelle</h2>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf

            <div class="mb-3">
                <label for="name">İsim</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="old_password">Mevcut Şifre</label>
                <input type="password" name="old_password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password">Yeni Şifre</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation">Yeni Şifre (Tekrar)</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>

    </div>



    <style>

        /* Container */
        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            margin-top: 40px;
        }

        /* Başlık */
        h2 {
            font-weight: 700;
            color: #222;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        /* Form label */
        label {
            font-weight: 600;
            color: #555;
        }

        /* Form kontrol (inputlar) */
        .form-control {
            border-radius: 8px;
            border: 1.7px solid #ced4da;
            padding: 10px 14px;
            font-size: 1rem;
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
            outline: none;
        }

        /* Başarılı mesaj */
        .alert-success {
            border-left: 5px solid #198754;
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* Hata mesajları */
        .alert-danger {
            border-left: 5px solid #dc3545;
            background-color: #f8d7da;
            color: #842029;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Buton */
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 12px 28px;
            font-size: 1.1rem;
            border-radius: 10px;
            font-weight: 700;
            transition: background-color 0.3s ease;
            box-shadow: 0 5px 15px rgba(13,110,253,0.4);
            cursor: pointer;
            user-select: none;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #0b5ed7;
            box-shadow: 0 6px 20px rgba(11,94,215,0.6);
            outline: none;
        }

        /* Form grup aralığı */
        .mb-3 {
            margin-bottom: 1.5rem;
        }

    </style>
@endsection
