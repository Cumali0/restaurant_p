@extends('layouts.app')

@section('title', 'Rezervasyon Tamamlandı')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-50 to-green-100">
        <div class="bg-white shadow-lg rounded-2xl p-10 max-w-lg text-center animate-fade-in">
            <!-- İkon -->
            <div class="flex justify-center mb-6">
                <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
            </div>

            <!-- Başlık -->
            <h1 class="text-3xl font-bold text-gray-800">Rezervasyonunuz Onaylandı ✅</h1>
            <p class="mt-4 text-gray-600 leading-relaxed">
                Teşekkür ederiz! Rezervasyon talebiniz başarıyla alındı.
                Rezervasyon detaylarınız kısa süre içinde
                <span class="font-semibold">e-posta</span> adresinize gönderilecektir.
            </p>

            <!-- Buton -->
            <a href="{{ url('/') }}"
               class="inline-block mt-6 px-6 py-3 bg-green-500 text-white font-medium rounded-full shadow hover:bg-green-600 transition">
                Ana Sayfaya Dön
            </a>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            0% { opacity: 0; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-in-out;
        }
    </style>
@endsection
