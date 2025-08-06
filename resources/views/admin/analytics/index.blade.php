@extends('admin.layouts.app')

@section('title', 'Rezervasyon Analizi')

@section('content')
    <div style="max-width: 900px; margin: 0 auto; padding: 20px;">
        <h1 style="margin-bottom: 30px;">Rezervasyon Analizi</h1>

        <h2 style="margin-top: 20px; margin-bottom: 15px;">Günlük Rezervasyonlar (Son 30 Gün)</h2>
        <canvas id="dailyChart" width="600" height="300"></canvas>

        <h2 style="margin-top: 40px; margin-bottom: 15px;">Aylık Rezervasyonlar (Son 12 Ay)</h2>
        <canvas id="monthlyChart" width="600" height="300"></canvas>
    </div>

@endsection

@push('styles')
    <style>
        canvas {
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 10px;
            max-width: 100%;
            height: auto !important;

            /* Hover efektleri için geçiş */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        /* Hover'da büyü ve gölge artışı */
        canvas:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            z-index: 10;
            position: relative;
        }

        /* Başlıklar için biraz daha stil */
        h1 {
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        h2 {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.3rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dailyData = @json($dailyReservations);
        const monthlyData = @json($monthlyReservations);

        const dailyLabels = dailyData.map(item => item.date);
        const dailyCounts = dailyData.map(item => item.count);

        const monthlyLabels = monthlyData.map(item => item.month);
        const monthlyCounts = monthlyData.map(item => item.count);

        const ctxDaily = document.getElementById('dailyChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Günlük Rezervasyon Sayısı',
                    data: dailyCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, precision: 0 }
                }
            }
        });

        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Aylık Rezervasyon Sayısı',
                    data: monthlyCounts,
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, precision: 0 }
                }
            }
        });
    </script>
@endpush
