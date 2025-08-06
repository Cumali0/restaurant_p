@extends('admin.layouts.app')

@section('title', 'Rezervasyon Analizi')

@section('content')
    <h1>Rezervasyon Analizi</h1>
    <div class="charts-container">
        <div class="chart-box">
            <h2>Günlük Rezervasyonlar (Son 30 Gün)</h2>
            <canvas id="dailyChart"></canvas>
        </div>
        <div class="chart-box">
            <h2>Aylık Rezervasyonlar (Son 12 Ay)</h2>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            color: #2c3e50;
            line-height: 1.6;
        }
        .charts-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 40px 20px;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }
        .chart-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            flex: 1 1 500px;
            max-width: 600px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .chart-box:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            z-index: 10;
            position: relative;
        }
        canvas {
            width: 100% !important;
            height: 400px !important;
            border-radius: 8px;
            background: #fff;
        }
        h1 {
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            font-size: 3rem;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        h2 {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.3rem;
            font-size: 1.5rem;
        }
        .chart-legend {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            font-size: 0.9rem;
        }
        .chart-legend div {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        .chart-legend span {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin-right: 5px;
            border-radius: 50%;
        }
        .legend-daily {
            background-color: rgba(54, 162, 235, 1);
        }
        .legend-monthly {
            background-color: rgba(255, 159, 64, 1);
        }
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 15px;
        }
        .btn-refresh, .btn-export {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }
        .btn-export {
            background-color: #27ae60;
        }
        .btn-refresh:hover {
            background-color: #2980b9;
        }
        .btn-export:hover {
            background-color: #1e8449;
        }
        .filters {
            max-width: 1200px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }
        .filters select, .filters input {
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        const dailyChart = new Chart(ctxDaily, {
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
                    pointBackgroundColor: '#3498db',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        backgroundColor: '#2c3e50',
                        titleColor: '#ecf0f1',
                        bodyColor: '#ecf0f1'
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    }
                }
            }
        });

        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Aylık Rezervasyon Sayısı',
                    data: monthlyCounts,
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        backgroundColor: '#2c3e50',
                        titleColor: '#ecf0f1',
                        bodyColor: '#ecf0f1'
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    }
                }
            }
        });

        document.querySelector('.btn-refresh')?.addEventListener('click', () => {
            location.reload();
        });

        document.querySelector('.btn-export')?.addEventListener('click', () => {
            const dailyImg = dailyChart.toBase64Image();
            const monthlyImg = monthlyChart.toBase64Image();
            const a = document.createElement('a');
            a.href = dailyImg;
            a.download = 'daily_reservations_chart.png';
            a.click();
            const b = document.createElement('a');
            b.href = monthlyImg;
            b.download = 'monthly_reservations_chart.png';
            b.click();
        });
    </script>
@endpush
