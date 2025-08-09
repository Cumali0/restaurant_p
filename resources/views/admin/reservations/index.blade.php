@extends('admin.layouts.app')

@section('content')
    <h1>Reservations List</h1>


    {{-- Filtre formu --}}
    <form method="GET" action="{{ route('reservations.index') }}" class="mb-3 d-flex gap-2 align-items-center">

        <input type="text" name="table_id" placeholder="Masa Numarası" value="{{ request('table_id') }}" />

        <input type="text" name="name" placeholder="İsim veya Soyisim" value="{{ request('name') }}" />

        <input type="text" id="datetime" name="datetime_start" placeholder="Başlangıç Tarih & Saat" value="{{ request('datetime') }}" autocomplete="off" />
        <input type="text" id="end_datetime" name="datetime_end" placeholder="Bitiş Tarih & Saat" value="{{ request('end_datetime') }}" autocomplete="on" />

        <button type="submit">Filtrele</button>
        <a href="{{ route('reservations.index') }}" style="text-decoration:none; padding: 6px 10px; border: 1px solid #ccc; color:#333;">Temizle</a>
    </form>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Masa Numarası</th> <!-- Yeni sütun -->
            <th>İsim</th>
            <th>Soyad</th>
            <th>Email</th>  <!-- Buraya eklendi -->
            <th>Tarih ve Zaman</th>
            <th>Durum</th>
            <th>Seçimler</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->table_id}}</td> <!-- Masa numarası -->
                <td>{{ $reservation->name }}</td>
                <td>{{ $reservation->surname }}</td>
                <td>{{ $reservation->email }}</td>  <!-- Buraya eklendi -->
                <td>{{ $reservation->datetime }}</td>
                <td>{{ ucfirst($reservation->status) }}</td>
                <td>
                    @if ($reservation->status != 'approved')
                        <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit">Onaylamak</button>
                        </form>
                    @endif

                    @if ($reservation->status != 'rejected')
                        <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" onclick="return confirm('Bu rezervasyonu reddetmek istediğinize emin misiniz?')">Reddetmek</button>
                        </form>
                    @endif

                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Rezervasyonu silmek istediğinize emin misiniz?')">Silmek</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">No reservations found.</td></tr>

        @endforelse
        </tbody>
    </table>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        button {
            background-color: #007BFF;
            border: none;
            color: white;
            padding: 6px 12px;
            margin: 0 2px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        button.reject {
            background-color: #dc3545;
        }

        button.reject:hover {
            background-color: #a71d2a;
        }

        button.delete {
            background-color: #6c757d;
        }

        button.delete:hover {
            background-color: #4e555b;
        }


        table {
            border-collapse: collapse; /* Önemli: Kenarların birleşmesi için */
            width: 100%;
        }

        th, td {
            border-bottom: 1px solid #ddd; /* Açık gri alt çizgi */
            padding: 10px 15px; /* Yeterli iç boşluk */
            text-align: left;
        }

        tbody tr:last-child td {
            border-bottom: none; /* Son satır alt çizgisi isteğe bağlı */
        }

        thead th {
            background-color: #007BFF; /* Senin mavi başlık */
            color: white;
            border-bottom: 2px solid #0056b3; /* Başlık altında koyu çizgi */
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>

    <script>
        flatpickr("#datetime", {
            locale: "tr",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            allowInput: true,
        });
        flatpickr("#end_datetime", {
            locale: "tr",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            allowInput: true,
        });
    </script>
@endsection
