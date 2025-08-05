@extends('admin.layouts.app')

@section('title', 'Masa Yönetimi')

@section('content')
    <div class="table-page">
        <h2>Masa Yönetimi</h2>
        <div class="view-toggle">
            <button id="tableViewBtn" class="btn btn-secondary active">📋 Tablo</button>
            <button id="gridViewBtn" class="btn btn-secondary">🟢 Görsel</button>
            <button class="btn btn-primary" onclick="openAddModal()">➕ Yeni Masa Ekle</button>
        </div>

        @if(session('success'))
            <div class="alert success-alert">{{ session('success') }}</div>
        @endif

        <div id="tableView">

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Kapasite</th>
                <th>Durum</th>
                <th>Kat</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tables as $table)
                <tr>
                    <td>{{ $table->id }}</td>
                    <td>{{ $table->name }}</td>
                    <td>{{ $table->capacity }}</td>
                    <td>
                        <span class="status-badge {{ $table->status }}">{{ ucfirst($table->status) }}</span>
                    </td>
                    <td>{{ $table->floor }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                                onclick="openEditModal({{ $table->id }}, '{{ $table->name }}', {{ $table->capacity }}, '{{ $table->status }}', {{ $table->floor ?? 'null' }})">
                            ✏ Düzenle
                        </button>
                        <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Masa silinsin mi?')">🗑 Sil</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

        <!-- Görsel görünüm -->
        <div id="gridView" style="display:none;">
            <div class="tables-grid">
                @foreach($tables as $table)
                    <div class="table-icon {{ $table->status }}"
                         title="Kapasite: {{ $table->capacity }} - Kat: {{ $table->floor }}">
                        {{ $table->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Yapıları -->
    <div class="modal" id="addModal" style="display:none;">
        <div class="modal-content">
            <h3>Yeni Masa Ekle</h3>
            <form action="{{ route('tables.store') }}" method="POST" class="modal-form">
                @csrf
                <input type="text" name="name" placeholder="Masa Adı" required />
                <input type="number" name="capacity" placeholder="Kapasite" required />
                <select name="status">
                    <option value="available">Uygun</option>
                    <option value="booked">Rezerve</option>
                </select>
                <input type="number" name="floor" placeholder="Kat" />
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-success">Kaydet</button>
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">İptal</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="editModal" style="display:none;">
        <div class="modal-content">
            <h3>Masa Düzenle</h3>
            <form id="editForm" method="POST" class="modal-form">
                @csrf
                @method('PUT')
                <input type="text" id="editName" name="name" required />
                <input type="number" id="editCapacity" name="capacity" required />
                <select id="editStatus" name="status">
                    <option value="available">Uygun</option>
                    <option value="booked">Rezerve</option>
                </select>
                <input type="number" id="editFloor" name="floor" />
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">İptal</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Genel sayfa stili */
        .table-page {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .table-page h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Butonlar */
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            user-select: none;
        }

        .btn-primary {
            background-color: #4b6cb7;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #3a54a1;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 0.85rem;
        }

        /* Tablo stili */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead tr {
            background-color: #4b6cb7;
            color: white;
            text-align: left;
        }

        .table th, .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Status badge */
        .status-badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #fff;
            text-transform: capitalize;
            display: inline-block;
        }

        .status-badge.available {
            background-color: #28a745;
        }

        .status-badge.booked {
            background-color: #dc3545;
        }

        /* Inline form (sil butonu için) */
        .inline-form {
            display: inline;
        }

        /* Modal stili */
        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            width: 380px;
            box-shadow: 0 5px 15px rgb(0 0 0 / 0.3);
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #222;
            font-weight: 700;
            text-align: center;
        }

        .modal-form input,
        .modal-form select {
            width: 100%;
            padding: 8px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .modal-form input:focus,
        .modal-form select:focus {
            outline: none;
            border-color: #4b6cb7;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-between;
        }

        .modal-buttons button {
            width: 48%;
        }

        /* Alert mesajı */
        .success-alert {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        /* Toggle Butonları */
        .view-toggle {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .btn-secondary.active {
            background-color: #4b6cb7;
            color: white;
        }

        /* Görsel Masa Grid */
        .tables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .table-icon {
            width: 80px;
            height: 80px;
            background-color: #28a745;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .table-icon.booked {
            background-color: #dc3545;
        }
        .table-icon:hover {
            transform: scale(1.1);
        }
    </style>

    <script>


        // Toggle Görünüm
        document.addEventListener('DOMContentLoaded', function () {
            const tableViewBtn = document.getElementById('tableViewBtn');
            const gridViewBtn = document.getElementById('gridViewBtn');
            const tableView = document.getElementById('tableView');
            const gridView = document.getElementById('gridView');

            tableViewBtn.addEventListener('click', () => {
                tableView.style.display = 'block';
                gridView.style.display = 'none';
                tableViewBtn.classList.add('active');
                gridViewBtn.classList.remove('active');
            });

            gridViewBtn.addEventListener('click', () => {
                tableView.style.display = 'none';
                gridView.style.display = 'block';
                gridViewBtn.classList.add('active');
                tableViewBtn.classList.remove('active');
            });
        });

        function openAddModal() {
            document.getElementById('addModal').style.display = 'flex';
        }
        function closeAddModal() {
            document.getElementById('addModal').style.display = 'none';
        }

        function openEditModal(id, name, capacity, status, floor) {
            document.getElementById('editModal').style.display = 'flex';
            document.getElementById('editName').value = name;
            document.getElementById('editCapacity').value = capacity;
            document.getElementById('editStatus').value = status;
            document.getElementById('editFloor').value = floor;
            document.getElementById('editForm').action = '/admin/tables/' + id;
        }
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>

@endsection
