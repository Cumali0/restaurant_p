<!DOCTYPE html>
<html lang="tr">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ön Sipariş - Rezervasyon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:#f0f4f8;
            color:#222;
            margin:0;
            padding:20px;
        }

        h2,h3 {
            text-align:center;
            color:#1a202c;
            margin-top:10px;
        }

        /* Kategori barı sticky */
        .category-bar {
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
            gap:12px;
            padding:10px 0;
            margin:0 auto 20px auto;
            max-width:900px;
            overflow-x:auto;
            scrollbar-width:none;
            position:sticky;
            top:0;
            z-index:100;
            background:#f0f4f8;
        }
        .category-bar::-webkit-scrollbar {
            display:none;
        }

        .category-btn {
            padding:8px 20px;
            border:none;
            border-radius:25px;
            background: linear-gradient(135deg,#6a11cb,#2575fc);
            color:white;
            cursor:pointer;
            font-weight:bold;
            transition:0.3s;
            flex:0 0 auto;
        }

        .category-btn.active {
            background: linear-gradient(135deg,#ff6f61,#ffb347);
        }

        .category-btn:hover {
            opacity:0.85;
            transform:translateY(-2px);
        }

        /* Flex layout: menüler + sepet */
        .main-content {
            display:flex;
            gap:30px;
            justify-content:center;
            align-items:flex-start;
            flex-wrap:wrap;
        }

        /* Menü kartları grid */
        #menu-container {
            display:grid;
            grid-template-columns:repeat(4,220px);
            gap:20px;
            justify-content:center;
            max-height:80vh;
            overflow-y:auto;
            scrollbar-width:none;
        }
        #menu-container::-webkit-scrollbar { display:none; }

        .menu-item {
            background:#fff8e1;
            border-radius:12px;
            text-align:center;
            box-shadow:0 6px 15px rgba(0,0,0,0.1);
            overflow:hidden;
            cursor:pointer;
            transition:transform 0.3s, box-shadow 0.3s;
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        .menu-item:hover {
            transform:translateY(-5px);
            box-shadow:0 12px 30px rgba(0,0,0,0.2);
        }

        .menu-item img {
            width:100%;
            height:140px;
            object-fit:cover;
            transition: transform 0.3s;
        }

        .menu-item:hover img {
            transform: scale(1.08);
        }

        .menu-info {
            padding:12px;
            width:100%;
            display:flex;
            flex-direction:column;
            align-items:center;
        }

        .menu-info strong {
            font-size:16px;
            margin-bottom:5px;
            color:#333;
        }

        .menu-info .price {
            font-weight:bold;
            margin-bottom:10px;
            color:#1a202c;
        }

        .menu-quantity {
            width:50px;
            padding:4px;
            text-align:center;
            margin-bottom:10px;
            border-radius:5px;
            border:1px solid #ccc;
        }

        .add-to-cart {
            padding:6px 12px;
            border:none;
            border-radius:5px;
            background:#ff6f61;
            color:white;
            cursor:pointer;
            font-weight:bold;
            transition: background 0.2s;
        }

        .add-to-cart:hover {
            background:#e65c50;
        }

        /* Sepet */
        #cart-container {
            width:350px;
            position:sticky;
            top:20px;
            max-height:80vh;
            overflow-y:auto;
            scrollbar-width:none;
            background:#fff;
            padding:15px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }
        #cart-container::-webkit-scrollbar {
            display:none;
        }

        #cart-items {
            list-style:none;
            padding:0;
            margin:10px 0;
        }

        #cart-items li {
            background:#f7f7f7;
            border-radius:6px;
            padding:8px 12px;
            margin-bottom:5px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            font-size:14px;
            color:#333;
        }
        .cart-controls button {
            margin:0 4px;
            padding:4px 8px;
            border:none;
            border-radius:4px;
            cursor:pointer;
            font-weight:bold;
        }

        .cart-controls .increase {
            background:#28a745;
            color:white;
        }

        .cart-controls .decrease {
            background:#ffc107;
            color:white;
        }
        .cart-controls .remove {
            background: #dc3545;
            color: white;
        }

        #cart-total {
            display:block;
            text-align:right;
            font-weight:bold;
            margin-bottom:5px;
            font-size:16px;
            color:#1a202c;
        }

        #cart-summary
        {
            text-align:right;
            font-size:14px;
            color:#555;
            margin-bottom:10px;
        }

        #finalize-cart, #empty-cart {
            display:block;
            margin:5px auto;
            padding:10px 20px;
            font-size:16px;
            font-weight:bold;
            color:white;
            background:#007bff;
            border:none;
            border-radius:6px;
            cursor:pointer;
            transition:background 0.2s, transform 0.2s;
        }

        #finalize-cart:hover, #empty-cart:hover {
            background:#0056b3;
            transform:translateY(-2px);
        }

        /* Modal */
        #order-modal {
            display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.5);
            justify-content:center;
            align-items:center;
        }

        #order-modal .modal-content {
            background:#fff;
            padding:20px;
            border-radius:8px;
            width:90%;
            max-width:400px;
            text-align:center;
        }

        #order-modal button {
            margin:10px;
            padding:8px 16px;
        }

        @media(max-width:1100px) {
            #menu-container {
                grid-template-columns:repeat(3,220px);
            }
        }

        @media(max-width:900px){
            #menu-container {
                grid-template-columns:repeat(2,220px);
            }
            #cart-container {
                width:90%;
                margin-top:20px;
                position:static;
            }
        }

        @media(max-width:600px){
            #menu-container {
                grid-template-columns:1fr;
            }
        }


    </style>
</head>
<body>

<h2>Ön Sipariş - Rezervasyon <span id="reservation-id"></span></h2>
<input type="hidden" id="reservation_id" value="{{ $reservation->id }}">

<input type="hidden" id="reservation_token" value="{{ $reservation->preorder_token }}">

<div id="filter-container" class="category-bar"></div>

<div class="main-content">
    <div id="menu-container"></div>

    <div id="cart-container">
        <h3>Sepet</h3>
        <ul id="cart-items"></ul>
        <p id="cart-summary">0 ürün, 0₺</p>
        <p>Toplam: <span id="cart-total">0</span>₺</p>

        <div style="text-align:center; margin-bottom:10px;">
            <label><input type="radio" name="payment" value="Banka" checked> Banka Kartı</label>
            <label><input type="radio" name="payment" value="kredi"> Kredi Kartı</label>
        </div>

        <button id="empty-cart">Sepeti Boşalt</button>
        <button type="button" id="finalize-cart">Siparişi Tamamla</button>
    </div>
</div>

<!-- Modal -->
<div id="order-modal">
    <div class="modal-content">
        <h3>Sipariş Özeti</h3>
        <div id="modal-items"></div>
        <p id="modal-total"></p>
        <p id="modal-payment"></p>
        <button id="confirm-order">Onayla</button>
        <button id="cancel-order">İptal</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuContainer = document.getElementById('menu-container');
        const filterContainer = document.getElementById('filter-container');
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        const cartSummary = document.getElementById('cart-summary');
        const reservationToken = document.getElementById('reservation_token').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const cart = [];
        const menus = @json($menus);

        // Kategori filtreleri
        const categories = ['Tüm Menü', ...new Set(menus.map(m => m.category))];
        categories.forEach(cat => {
            const btn = document.createElement('button');
            btn.textContent = cat;
            btn.className = 'category-btn' + (cat === 'Tüm Menü' ? ' active' : '');
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                renderMenus(cat);
            });
            filterContainer.appendChild(btn);
        });

        function renderMenus(category = 'Tüm Menü') {
            menuContainer.innerHTML = '';
            menus.forEach(menu => {
                if (category !== 'Tüm Menü' && menu.category !== category) return;
                const imgUrl = "{{ asset('storage') }}/" + menu.image;
                const div = document.createElement('div');
                div.className = 'menu-item';
                div.innerHTML = `
            <img src="${imgUrl}" alt="${menu.name}">
            <div class="menu-info">
                <strong>${menu.name}</strong>
                <span class="price">${menu.price}₺</span>
                <div style="display:flex; gap:5px; align-items:center;">
                    <button class="decrease" style="padding:2px 6px;">-</button>
                    <input type="number" min="1" value="1" class="menu-quantity" data-menu-id="${menu.id}" style="width:40px; text-align:center;"/>
                    <button class="increase" style="padding:2px 6px;">+</button>
                </div>
                <button class="add-to-cart" data-menu-id="${menu.id}">Sepete Ekle</button>
            </div>`;
                menuContainer.appendChild(div);
            });
            attachMenuControls();
        }

        function attachMenuControls() {
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.addEventListener('click', function() {
                    const menuItem = this.closest('.menu-item');
                    const menuId = parseInt(this.dataset.menuId);
                    const name = menuItem.querySelector('strong').textContent;
                    const price = parseFloat(menuItem.querySelector('.price').textContent.replace('₺', ''));
                    const quantity = parseInt(menuItem.querySelector('.menu-quantity').value);

                    const existing = cart.find(i => i.id === menuId);
                    if (existing) existing.quantity += quantity;
                    else cart.push({id: menuId, name, price, quantity});

                    updateCartDisplay();
                });
            });

            document.querySelectorAll('.increase').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = btn.previousElementSibling;
                    input.value = parseInt(input.value) + 1;
                });
            });
            document.querySelectorAll('.decrease').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = btn.nextElementSibling;
                    input.value = Math.max(1, parseInt(input.value) - 1);
                });
            });
        }

        function animateTotal(oldValue, newValue) {
            const duration = 300;
            const start = performance.now();
            const diff = newValue - oldValue;
            function step(timestamp) {
                const progress = Math.min((timestamp - start) / duration, 1);
                const current = oldValue + diff * progress;
                cartTotal.textContent = current.toFixed(2);
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        function syncCartToBackend() {
            fetch(`/reservation/${reservationToken}/update-cart`, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json'},
                body: JSON.stringify({cart})
            })
                .then(res => res.json())
                .then(data => console.log(data.message))
                .catch(err => console.error(err));
        }

        function updateCartDisplay() {
            cartItems.innerHTML = '';
            cart.forEach((item, index) => {
                const li = document.createElement('li');
                li.innerHTML = `
            ${item.name}
            <div class="cart-controls">
                <button class="decrease" data-index="${index}">-</button>
                ${item.quantity}
                <button class="increase" data-index="${index}">+</button>
                - ${(item.price * item.quantity).toFixed(2)}₺
                <button class="remove" data-index="${index}">Sil</button>
            </div>`;
                cartItems.appendChild(li);
            });

            const oldTotal = parseFloat(cartTotal.textContent) || 0;
            const newTotal = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
            animateTotal(oldTotal, newTotal);

            const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);
            cartSummary.textContent = `${totalItems} ürün, ${newTotal.toFixed(2)}₺`;

            cartItems.querySelectorAll('.increase').forEach(btn => {
                btn.addEventListener('click', () => {
                    cart[btn.dataset.index].quantity++;
                    updateCartDisplay();
                });
            });
            cartItems.querySelectorAll('.decrease').forEach(btn => {
                btn.addEventListener('click', () => {
                    const idx = btn.dataset.index;
                    if (cart[idx].quantity > 1) cart[idx].quantity--;
                    else cart.splice(idx, 1);
                    updateCartDisplay();
                });
            });
            cartItems.querySelectorAll('.remove').forEach(btn => {
                btn.addEventListener('click', () => {
                    cart.splice(btn.dataset.index, 1);
                    updateCartDisplay();
                });
            });

            syncCartToBackend();
        }

        document.getElementById('empty-cart').addEventListener('click', () => {
            if(cart.length === 0) return;
            if(confirm('Sepeti tamamen boşaltmak istiyor musunuz?')) {
                cart.length = 0;
                updateCartDisplay();
                fetch(`/reservation/${reservationToken}/empty-cart`, {
                    method: 'POST',
                    headers: {'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json'}
                });
            }
        });

        // Modal ve finalize
        const modal = document.getElementById('order-modal');
        const modalItems = document.getElementById('modal-items');
        const modalTotal = document.getElementById('modal-total');
        const modalPayment = document.getElementById('modal-payment');
        const confirmOrder = document.getElementById('confirm-order');
        const cancelOrder = document.getElementById('cancel-order');

        document.getElementById('finalize-cart').addEventListener('click', () => {
            if(cart.length === 0){ alert('Sepetiniz boş!'); return; }
            modalItems.innerHTML = cart.map(i => `${i.name} x ${i.quantity} - ${(i.price*i.quantity).toFixed(2)}₺`).join('<br>');
            const totalPrice = cart.reduce((sum, i) => sum + i.price*i.quantity, 0);
            modalTotal.textContent = `Toplam: ${totalPrice.toFixed(2)}₺`;
            const payment = document.querySelector('input[name="payment"]:checked').value;
            modalPayment.textContent = `Ödeme: ${payment}`;
            modal.style.display='flex';
        });

        confirmOrder.addEventListener('click', e => {
            e.preventDefault();
            const payment = document.querySelector('input[name="payment"]:checked').value;
            fetch(`/reservation/${reservationToken}/finalize-preorder`, {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json'},
                body: JSON.stringify({cart: cart, payment: payment})
            })
                .then(res => res.json())
                .then(data => {
                    if(data.redirect_url){
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message);
                        cart.length = 0;
                        updateCartDisplay();
                        modal.style.display = 'none';
                    }
                })
                .catch(err => console.error(err));
        });

        cancelOrder.addEventListener('click', () => { modal.style.display='none'; });

        // --- YENİ: Backend'den mevcut cart'ı yükle ---
        function loadCart() {
            fetch(`/reservation/${reservationToken}/get-cart`)
                .then(res => res.json())
                .then(data => {
                    cart.length = 0;
                    data.items.forEach(item => cart.push(item));
                    updateCartDisplay();
                })
                .catch(err => console.error(err));
        }

        renderMenus();
        loadCart(); // <<< sayfa açılınca sepet backend’den yükleniyor
        window.addEventListener("beforeunload", function (event) {
            const reservationId = document.getElementById('reservation_id').value;
            if (!reservationId) return;

            // Sayfa reload ise tokeni silme
            if (performance.getEntriesByType("navigation")[0].type === "reload") return;

            // Tokeni silmek için beacon gönder
            const formData = new FormData();
            formData.append('reservation_id', reservationId);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            navigator.sendBeacon(`/reservation/${reservationId}/abandon-cart`, formData);

            // Tarayıcıya kendi mesajımızı vermek istiyoruz

        });




    });
</script>


</body>
</html>
