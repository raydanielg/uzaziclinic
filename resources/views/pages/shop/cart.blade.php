@extends('layouts.landing')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="fw-bold mb-4 animate__animated animate__fadeInUp">Your Shopping Cart</h1>
        
        <div class="row g-4">
            <div class="col-lg-8 animate__animated animate__fadeInLeft">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 border-0">Product</th>
                                        <th class="py-3 border-0 text-center">Qty</th>
                                        <th class="py-3 border-0 text-end">Price</th>
                                        <th class="px-4 py-3 border-0 text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    <!-- Items will be loaded by JS -->
                                </tbody>
                            </table>
                        </div>
                        <div id="empty-cart-msg" class="p-5 text-center d-none">
                            <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Your cart is empty</h5>
                            <a href="{{ route('shop.index') }}" class="btn btn-green mt-3 px-4 rounded-pill fw-bold">CONTINUE SHOPPING</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 animate__animated animate__fadeInRight">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold" id="cart-subtotal">TSh 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Delivery</span>
                            <span class="text-success fw-bold">FREE</span>
                        </div>
                        <hr class="opacity-10">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Total</span>
                            <span class="h5 fw-bold text-green-600" id="cart-total">TSh 0</span>
                        </div>
                        <a href="{{ route('shop.checkout') }}" id="checkout-btn" class="btn btn-green w-100 rounded-3 py-3 fw-bold d-none">
                            PROCEED TO CHECKOUT <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('clinic_cart')) || [];
    const container = document.getElementById('cart-items');
    const emptyMsg = document.getElementById('empty-cart-msg');
    const checkoutBtn = document.getElementById('checkout-btn');
    let total = 0;

    if (cart.length === 0) {
        emptyMsg.classList.remove('d-none');
    } else {
        checkoutBtn.classList.remove('d-none');
        cart.forEach(item => {
            const itemTotal = item.price * item.qty;
            total += itemTotal;
            container.innerHTML += `
                <tr>
                    <td class="px-4 py-4 border-0">
                        <div class="fw-bold text-dark">${item.name}</div>
                        <small class="text-muted">TSh ${item.price.toLocaleString()}</small>
                    </td>
                    <td class="py-4 border-0 text-center">${item.qty}</td>
                    <td class="py-4 border-0 text-end text-muted">TSh ${item.price.toLocaleString()}</td>
                    <td class="px-4 py-4 border-0 text-end fw-bold">TSh ${itemTotal.toLocaleString()}</td>
                </tr>
            `;
        });

        document.getElementById('cart-subtotal').innerText = 'TSh ' + total.toLocaleString();
        document.getElementById('cart-total').innerText = 'TSh ' + total.toLocaleString();
    }
});
</script>
@endsection
