@extends('layouts.app')

@section('content')
    <h2>Ön Sipariş - Rezervasyon #{{ $reservation->id }}</h2>
    <input type="hidden" id="reservation_id" value="{{ $reservation->id }}">
    <div id="menu-container">
        @foreach($menus as $menu)
            <div class="menu-item">
                <strong>{{ $menu->name }}</strong> - {{ $menu->price }}₺
                <input type="number" min="1" value="1" class="menu-quantity" data-menu-id="{{ $menu->id }}">
                <button class="add-to-cart" data-menu-id="{{ $menu->id }}">Sepete Ekle</button>
            </div>
        @endforeach
    </div>

    <h3>Sepet</h3>
    <ul id="cart-items">
        @foreach($cart as $item)
            <li>{{ $item['name'] }} x{{ $item['quantity'] }} - {{ $item['total_price'] }}₺</li>
        @endforeach
    </ul>
    <p>Toplam: <span id="cart-total">{{ array_sum(array_column($cart, 'total_price')) ?? 0 }}</span>₺</p>

    <button type="button" id="finalize-cart">Siparişi Tamamla</button>

    <script>
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function() {
                const menuId = this.dataset.menuId;
                const quantityInput = document.querySelector(`.menu-quantity[data-menu-id="${menuId}"]`);
                const quantity = parseInt(quantityInput.value);

                fetch(`/reservation/{{ $reservation->id }}/add-to-cart`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ menu_id: menuId, quantity: quantity })
                })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) updateCartDisplay(data.cart);
                    });
            });
        });

        function updateCartDisplay(cartData) {
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            cartItems.innerHTML = '';
            let total = 0;
            cartData.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.name} x${item.quantity} - ${item.total_price}₺`;
                cartItems.appendChild(li);
                total += item.total_price;
            });
            cartTotal.textContent = total.toFixed(2);
        }

        const finalizeBtn = document.getElementById('finalize-cart');

        if(finalizeBtn) { // Eğer element varsa listener ekle
            finalizeBtn.addEventListener('click', function() {
                const reservationIdInput = document.getElementById('reservation_id');
                if(!reservationIdInput) return;

                const reservationId = reservationIdInput.value;

                fetch(`/reservation/${reservationId}/finalize-preorder`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                    .then(res => res.json())
                    .then(data => {
                        window.location.href = `/reservation/${reservationId}/checkout`;
                    })
                    .catch(err => console.error(err));
            });
        }

    </script>
@endsection
