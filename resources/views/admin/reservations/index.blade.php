@extends('admin.layouts.app')

@section('content')
    <h1>Reservations List</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>  <!-- Buraya eklendi -->
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->name }}</td>
                <td>{{ $reservation->surname }}</td>
                <td>{{ $reservation->email }}</td>  <!-- Buraya eklendi -->
                <td>{{ $reservation->datetime }}</td>
                <td>{{ ucfirst($reservation->status) }}</td>
                <td>
                    @if ($reservation->status != 'approved')
                        <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                    @endif

                    @if ($reservation->status != 'rejected')
                        <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit" onclick="return confirm('Bu rezervasyonu reddetmek istediğinize emin misiniz?')">Reject</button>
                        </form>
                    @endif

                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Rezervasyonu silmek istediğinize emin misiniz?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No reservations found.</td></tr>

        @endforelse
        </tbody>
    </table>

@endsection
