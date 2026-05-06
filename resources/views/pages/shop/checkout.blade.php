@extends('layouts.landing')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7 animate__animated animate__fadeInLeft">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold mb-4">Delivery & Account Details</h4>
                        
                        <form id="checkout-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
                                    <input type="text" name="name" class="form-control py-2 shadow-none border-light-subtle bg-light" required placeholder="Enter your full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
                                    <input type="email" name="email" class="form-control py-2 shadow-none border-light-subtle bg-light" required placeholder="you@example.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Phone Number</label>
                                    <input type="text" name="phone" class="form-control py-2 shadow-none border-light-subtle bg-light" required placeholder="+255...">
                                </div>
                                
                                @guest
                                <div class="col-12 mt-4 p-3 rounded-4 bg-green-soft">
                                    <p class="small text-green-700 fw-bold mb-3"><i class="fas fa-user-plus me-2"></i>Create an account to track your order</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">Set Password</label>
                                            <input type="password" name="password" class="form-control py-2 shadow-none border-light-subtle bg-white" placeholder="Minimum 8 characters">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control py-2 shadow-none border-light-subtle bg-white" placeholder="Repeat password">
                                        </div>
                                    </div>
                                </div>
                                @endguest

                                <div class="col-12 mt-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Delivery Address</label>
                                    <textarea name="address" rows="3" class="form-control shadow-none border-light-subtle bg-light" required placeholder="Your street, city, building..."></textarea>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <button type="submit" id="place-order-btn" class="btn btn-green w-100 rounded-3 py-3 fw-bold shadow-sm">
                                        PLACE ORDER NOW <i class="fas fa-check-circle ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 animate__animated animate__fadeInRight">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Order Summary</h5>
                        <div id="checkout-items" class="mb-4">
                            <!-- Items will be loaded by JS -->
                        </div>
                        <hr class="opacity-10">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Grand Total</span>
                            <span class="h5 fw-bold text-green-600" id="checkout-total">TSh 0</span>
                        </div>
                        <div class="p-3 rounded-3 bg-light border border-dashed text-center">
                            <i class="fas fa-truck text-muted me-2"></i>
                            <small class="text-muted">Estimated delivery within 24 hours.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cart = JSON.parse(localStorage.getItem('clinic_cart')) || [];
    const itemsContainer = document.getElementById('checkout-items');
    let total = 0;

    if (cart.length === 0) {
        window.location.href = "{{ route('shop.index') }}";
        return;
    }

    cart.forEach(item => {
        const itemTotal = item.price * item.qty;
        total += itemTotal;
        itemsContainer.innerHTML += `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="small">
                    <div class="fw-bold text-dark">${item.name} <span class="text-muted small">x${item.qty}</span></div>
                    <div class="text-muted">TSh ${item.price.toLocaleString()}</div>
                </div>
                <div class="fw-bold small">TSh ${itemTotal.toLocaleString()}</div>
            </div>
        `;
    });

    document.getElementById('checkout-total').innerText = 'TSh ' + total.toLocaleString();

    // Form Submission
    const form = document.getElementById('checkout-form');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('place-order-btn');
        const originalText = btn.innerHTML;

        try {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>PROCESSING...';

            const formData = new FormData(form);
            const response = await fetch("{{ route('shop.place-order') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                localStorage.removeItem('clinic_cart');
                Swal.fire({
                    icon: 'success',
                    title: 'Order Placed!',
                    text: data.message,
                    confirmButtonColor: '#16a34a'
                }).then(() => {
                    window.location.href = "{{ url('/home') }}";
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please check your details.', confirmButtonColor: '#16a34a' });
            }
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Network Error', text: 'Connection failed.', confirmButtonColor: '#16a34a' });
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
});
</script>

<style>
    .bg-green-soft { background: rgba(22, 163, 74, 0.08); }
</style>
@endsection
