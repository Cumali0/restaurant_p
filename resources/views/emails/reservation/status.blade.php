<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Rezervasyon Durumu</title>
    <style>
        body { margin:0;
            padding:20px;
            background-color:#f8f9fa;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color:#333;
        }

        .container {
            max-width:600px;
            margin:0 auto;
            background-color:#fff;
            padding:40px;
            border-radius:8px;
            box-shadow:0 2px 8px rgba(0,0,0,0.1);
        }

        h2 { font-weight:600;
            font-size:24px;
            margin-bottom:20px;
            border-bottom:2px solid #2575fc;
            padding-bottom:10px;
        }

        p { font-size:16px;
            line-height:1.5;
            margin-bottom:15px;
        }

        .status-approved {
            color:#2e7d32;
            font-weight:bold;
        }

        .status-rejected {
            color:#d32f2f;
            font-weight:bold;
        }

        .btn {
            background-color:#2575fc;
            color:#fff; padding:12px 28px;
            border-radius:5px; text-decoration:none;
            font-weight:600; font-size:16px;
            display:inline-block;
            margin:10px 0;
        }

        .qr-container {
            text-align:center;
            margin:30px 0;
        }

        .footer {
            font-size:14px;
            color:#777;
            border-top:1px solid #eee;
            padding-top:15px;
        }

        .details-table {
            width:100%;
            border-collapse:collapse;
            margin-bottom:20px;
        }

        .details-table th,
        .details-table td {

            text-align:left;
            padding:8px;
            border-bottom:1px solid #eee;
            font-size:15px;
        }

        .highlight
        {
            font-weight:bold;
        }

        .note {
            font-size:14px;
            color:#666;
            margin-top:10px;
        }

    </style>

</head>

<body>

<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <div class="container">
                <h2>Merhaba {{ $reservation->name }},</h2>

                <p>Rezervasyonunuzun durumu güncellenmiştir. Aşağıda detayları bulabilirsiniz:</p>

                <table class="details-table">
                    <tr>
                        <th>Durum</th>
                        <td class="{{ $reservation->status === 'approved' ? 'status-approved' : 'status-rejected' }}">{{ ucfirst($reservation->status) }}</td>
                    </tr>
                    <tr>
                        <th>Rezervasyon Tarihi</th>
                        <td>{{ \Carbon\Carbon::parse($reservation->datetime)->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Rezervasyon Süresi</th>
                        <td>{{ $reservation->end_datetime ? \Carbon\Carbon::parse($reservation->end_datetime)->format('d-m-Y H:i') : 'Belirtilmemiş' }}</td>
                    </tr>
                    <tr>
                        <th>Kişi Sayısı</th>
                        <td>{{ $reservation->people }}</td>
                    </tr>
                    <tr>
                        <th>Masa Numarası</th>
                        <td>{{ $reservation->table ? $reservation->table->name : '1' }}</td>
                    </tr>
                    <tr>
                        <th>Özel Notlar</th>
                        <td>{{ $reservation->message ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Toplam Tutar</th>
                        <td>{{ $reservation->total_price ?? '0 TL' }}</td>
                    </tr>
                    <tr>
                        <th>Ödeme Durumu</th>
                        <td>{{ $reservation->payment_status ?? 'Beklemede' }}</td>
                    </tr>
                    <tr>
                        <th>Ödeme Yöntemi</th>
                        <td>{{ $reservation->payment_method ?? '-' }}</td>
                    </tr>
                </table>

                @if($reservation->status === 'approved')
                    <p class="status-approved">Rezervasyonunuz onaylanmıştır. Sizi ağırlamaktan mutluluk duyarız!</p>
                @elseif($reservation->status === 'rejected')
                    <p class="status-rejected">Maalesef rezervasyonunuz reddedilmiştir. Anlayışınız için teşekkür ederiz.</p>
                @endif

                <div class="qr-container">
                    {!! $qrCode !!}
                    <p class="note">QR kodu tarayarak rezervasyon detaylarınızı görüntüleyebilirsiniz.</p>
                </div>

                <p>Rezervasyon linkiniz:</p>
                <p><a href="{{ url('/dashboard/reservations/'.$reservation->id) }}">{{ url('/dashboard/reservations/'.$reservation->id) }}</a></p>

                <a href="{{ route('reservation.thankyou') }}" class="btn">Ana Sayfa</a>

                <hr style="margin:30px 0; border-color:#eee;" />

                <h3>Ek Bilgiler</h3>
                <p style="font-size:15px; line-height:1.6;">

                    - Rezervasyonunuzu iptal etmek veya değiştirmek isterseniz lütfen <a href="{{ url('/contact') }}">iletişim</a> sayfasından bizimle iletişime geçin.<br>

                    - Rezervasyonunuzu onaylamak için mail veya telefonla teyit alındı.<br>

                    - QR kodu yalnızca bir kez kullanmanız yeterlidir. Masaya geldiğinizde görevli tarafından taratabilirsiniz.<br>

                    - Bu mail otomatik olarak gönderilmiştir, lütfen cevaplamayın.<br>

                    - Rezervasyonunuz ile ilgili sorular için bizimle <a href="{{ url('/support') }}">destek</a> sayfasından iletişime geçebilirsiniz.
                </p>

                <div class="footer">
                    Saygılarımızla,<br />
                    <strong>{{ config('app.name') }}</strong><br />
                    <span>Adres: Örnek Sokak No:12, İstanbul</span><br />
                    <span>Telefon: +90 123 456 7890</span><br />
                    <span>Email: info@example.com</span>
                </div>
            </div>
        </td>
    </tr>

</table>

</body>

</html>
