@extends('admin.layouts.app')

@section('title', 'Rezervasyon Analizi')

@section('content')
    <div style="max-width: 1000px; margin: 0 auto; padding: 20px;">

        <h1>Rezervasyon Analizi</h1>

        <div class="charts-container  " style="    height: 340px; width: 1400px; margin-top: 175px;">
            <div class="chart-box">
                <h2>Günlük Rezervasyonlar (Son 30 Gün)</h2>
                <canvas id="dailyChart"   style="  display: block;     box-sizing: border-box;  height: 254px;  width: 508px;"></canvas>
            </div>

            <div class="chart-box">
                <h2>Aylık Rezervasyonlar (Son 12 Ay)</h2>
                <canvas id="monthlyChart"  style="  display: block;     box-sizing: border-box;  height: 254px;  width: 508px;" ></canvas>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .charts-container {
            display: flex;
            justify-content: center;
            gap: 40px;  /* Grafikleri birbirinden ayıran boşluk */
            flex-wrap: wrap; /* Küçük ekranlarda alt alta geçecek */
        }

        .chart-box {
            flex: 1 1 450px; /* Esnek genişlik, min 450px */
            max-width: 675px;
            text-align: center; /* Başlık ve grafik ortalanır */
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .chart-box:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            position: relative;
            z-index: 10;
        }

        .chart-box h2 {
            margin-bottom: 15px;
            font-weight: 600;
            color: #34495e;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.3rem;
        }

        /* Responsive için */
        @media (max-width: 1000px) {
            .charts-container {
                flex-direction: column;
                align-items: center;
            }

            .chart-box {
                max-width: 90vw;
                margin-bottom: 30px;
            }
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
