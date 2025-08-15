@extends('layouts.app')

@section('content')
    <div style="min-height:100vh; display:flex; justify-content:center; align-items:center; background:#f2f2f2; padding:20px;">
        <div style="max-width:450px; width:100%; background:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); padding:30px; position:relative; font-family:Arial, sans-serif; transition:0.3s;">
            <h2 style="text-align:center; margin-bottom:20px; color:#333; font-weight:600;">Ödeme Sayfası</h2>

            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Toplam Tutar:</strong> {{ number_format($order->total_price,2) }}₺</p>

            <h3 style="margin-top:20px; color:#333;">Ödeme Bilgileri</h3>
            <form id="payment-form" style="display:flex; flex-direction:column; gap:15px; transition:0.3s;">
                <!-- Ödeme Yöntemi -->
                <div>
                    <label><input type="radio" name="payment_method" value="banka" checked> Banka Kartı</label>
                    <label style="margin-left:15px;"><input type="radio" name="payment_method" value="kredi"> Kredi Kartı</label>
                </div>

                <!-- Minimalist Kart Görseli -->
                <div id="card-visual" style="display:flex; margin:15px 0; padding:20px; border-radius:12px; background:linear-gradient(135deg,#2c3e50,#34495e); color:white; font-family:monospace; height:140px; position:relative; box-shadow:0 4px 15px rgba(0,0,0,0.2); transition:0.3s;">

                    <!-- Kart tipi ikonu -->
                    <div id="card-type-icon" style="position:absolute; top:15px; right:20px; font-size:20px;">🏦</div>

                    <div style="position:absolute; top:15px; left:20px; font-size:12px; letter-spacing:1px;">KART SAHİBİ</div>
                    <div id="card-name" style="position:absolute; top:35px; left:20px; font-size:16px; font-weight:bold;">John Doe</div>
                    <div id="card-number-display" style="position:absolute; bottom:50px; left:20px; font-size:16px; letter-spacing:2px;">**** **** **** ****</div>
                    <div style="position:absolute; bottom:20px; left:20px; font-size:10px;">AA/YY</div>
                    <div id="card-expiry" style="position:absolute; bottom:20px; left:55px; font-size:10px;">--/--</div>
                    <div style="position:absolute; bottom:20px; right:20px; font-size:10px;">CVV</div>
                    <div id="card-cvv" style="position:absolute; bottom:20px; right:50px; font-size:10px;">***</div>
                </div>

                <!-- Kart Alanları -->
                <div id="card-fields" style="display:flex; flex-direction:column; gap:10px;">
                    <input type="text" name="card_number" placeholder="Kart Numarası (16 hane)" maxlength="16" style="padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                    <div style="display:flex; gap:10px;">
                        <input type="text" name="expiry" placeholder="AA/YY" maxlength="5" style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                        <input type="text" name="cvv" placeholder="CVV" maxlength="3" style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                    </div>
                    <input type="text" name="card_name" placeholder="Kart Sahibi Adı" style="padding:10px; border-radius:6px; border:1px solid #ccc; font-size:14px;">
                </div>

                <button type="submit" style="padding:12px; background:#34495e; color:white; border:none; border-radius:6px; cursor:pointer; font-weight:bold; font-size:15px; transition:0.3s;">Ödemeyi Tamamla</button>
            </form>

            <div id="success-message" style="display:none; margin-top:20px; text-align:center; color:#27ae60; font-weight:bold; font-size:16px; transition:0.3s;">
                Ödeme başarılı! Teşekkürler.
            </div>

            <!-- Spinner -->
            <div id="spinner" style="display:none; margin:20px auto 0; width:40px; height:40px; border:4px solid #ccc; border-top:4px solid #27ae60; border-radius:50%; animation:spin 1s linear infinite;"></div>
        </div>
    </div>

    <style>
        #card-visual {
            display:flex;
            margin:15px 0;
            padding:20px;
            border-radius:12px;
            background:linear-gradient(135deg,#2c3e50,#34495e);
            color:white;
            font-family:monospace;
            height:160px;
            position:relative;
            box-shadow:0 8px 20px rgba(0,0,0,0.3);
            transition: all 0.5s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        #card-visual.flip {
            transform: rotateY(180deg);
        }

        #card-type-icon {
            position:absolute;
            top:15px;
            right:20px;
            font-size:24px;
            transition: all 0.3s ease;
        }

        #card-fields input {
            transition: all 0.3s ease;
        }

        #card-number-display, #card-name, #card-expiry, #card-cvv {
            transition: all 0.3s ease;
        }

        /* Hover ve ışık efekti */
        #card-visual:hover {
            box-shadow: 0 16px 40px rgba(0,0,0,0.5), 0 0 30px rgba(255,255,255,0.1) inset;
        }

        /* Kart üzerine hafif ışık yansıması */
        #card-visual::before {
            content: "";
            position: absolute;
            top:0; left:0;
            width:100%; height:100%;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(0,0,0,0) 70%);
            pointer-events: none;
            z-index:1;
        }

        /* Mouse hareketi ile hafif 3D eğim */
        #card-visual.mouse-move {
            transform: rotateY(var(--rotateY, 0deg)) rotateX(var(--rotateX, 0deg));
        }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            const cardFields = document.getElementById('card-fields');
            const cardVisual = document.getElementById('card-visual');
            const form = document.getElementById('payment-form');
            const successMessage = document.getElementById('success-message');
            const spinner = document.getElementById('spinner');
            const cardTypeIcon = document.getElementById('card-type-icon');

            const cardNumberDisplay = document.getElementById('card-number-display');
            const cardExpiry = document.getElementById('card-expiry');
            const cardCVV = document.getElementById('card-cvv');
            const cardName = document.getElementById('card-name');

            // Sayfa açıldığında banka kartı alanını göster
            cardFields.style.display = 'flex';
            cardVisual.style.display = 'flex';
            cardTypeIcon.textContent = '🏦';

            paymentRadios.forEach(radio => {
                radio.addEventListener('change', () => {
                    cardVisual.classList.add('flip'); // animasyonlu geçiş

                    setTimeout(() => {
                        cardVisual.classList.remove('flip');

                        if(radio.value === 'banka'){
                            cardTypeIcon.textContent = '🏦';
                        } else if(radio.value === 'kredi'){
                            cardTypeIcon.textContent = '💳';
                        }

                        cardFields.style.display = 'flex';
                        cardVisual.style.display = 'flex';
                    }, 250); // flip süresi
                });
            });

            // Kart bilgilerini canlı göster
            form.card_number?.addEventListener('input', e => {
                let val = e.target.value.padEnd(16,'*');
                cardNumberDisplay.textContent = val.replace(/(.{4})/g, '$1 ').trim();
            });
            form.expiry?.addEventListener('input', e => cardExpiry.textContent = e.target.value || '--/--');
            form.cvv?.addEventListener('input', e => cardCVV.textContent = e.target.value.replace(/./g,'*') || '***');
            form.card_name?.addEventListener('input', e => cardName.textContent = e.target.value || 'John Doe');

            // Ödeme işlemi
            form.addEventListener('submit', function(e){
                e.preventDefault();
                const method = document.querySelector('input[name="payment_method"]:checked').value;

                if(method === 'banka' || method === 'kredi'){
                    const cardNumber = form.card_number.value.trim();
                    const expiry = form.expiry.value.trim();
                    const cvv = form.cvv.value.trim();
                    const name = form.card_name.value.trim();
                    if(cardNumber.length !== 16 || cvv.length !== 3 || expiry.length !== 5 || !name){
                        alert('Kart bilgilerini doğru giriniz!');
                        return;
                    }
                }

                form.style.display = 'none';
                spinner.style.display = 'block';
                successMessage.textContent = 'Ödeme işleniyor... Lütfen bekleyin.';
                successMessage.style.display = 'block';

                setTimeout(() => {
                    spinner.style.display = 'none';
                    successMessage.textContent = 'Ödeme başarılı! Teşekkürler.';
                }, 3000);
            });
        });
    </script>

@endsection
