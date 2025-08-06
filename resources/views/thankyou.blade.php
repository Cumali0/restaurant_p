@extends('layouts.app')

@section('title', 'Teşekkürler')

@section('content')
    <div class="container text-center mt-5 p-4 rounded shadow-sm" style="max-width: 500px; background: #f9fafb;">
        <h1 style="font-weight: 700; color: #2c3e50;">🎉 Teşekkürler!</h1>
        <p class="mt-3" style="color: #555; font-size: 1.125rem;">
            Rezervasyonunuz başarıyla gönderildi.
        </p>
        <a href="{{ url('/') }}"
           class="btn btn-primary mt-4 px-5 py-2"
           style="background: linear-gradient(90deg, #4a90e2, #357ABD); border: none; box-shadow: 0 4px 8px rgba(53, 122, 189, 0.4); transition: background 0.3s ease;">
            Ana Sayfaya Dön
        </a>
    </div>
@endsection
