@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Rezervasyon Listesi</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Tarih & Saat</th>
                <th>Kişi</th>
                <th>Mesaj</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->name }}</td>
                    <td>{{ $reservation->surname }}</td>
                    <td>{{ $reservation->datetime }}</td>
                    <td>{{ $reservation->people }}</td>
                    <td>{{ $reservation->message }}</td>
                    <td>
                        @if($reservation->status === 'approved')
                            ✅ Onaylandı
                        @else
                            ⏳ Beklemede
                        @endif
                    </td>
                    <td>
                        @if($reservation->status !== 'approved')
                            <form action="{{ route('admin.reservations.approve', $reservation->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Onayla</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
