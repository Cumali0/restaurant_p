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
                <td>{{ $reservation->datetime }}</td>
                <td>{{ ucfirst($reservation->status) }}</td>
                <td>
                    @if ($reservation->status != 'approved')
                        <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>
                    @endif
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No reservations found.</td></tr>
        @endforelse
        </tbody>
    </table>

@endsection
