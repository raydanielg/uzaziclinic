@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.05) 0%, rgba(255,255,255,0) 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4 animate__animated animate__fadeInUp">
            <div>
                <h1 class="fw-bold mb-2">Clinic Shop</h1>
                <p class="text-muted mb-0">Quality medical supplies and wellness products delivered to your door.</p>
            </div>
            <a href="{{ route('shop.cart') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold shadow-sm position-relative">
                <i class="fas fa-shopping-cart me-2"></i>CART
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">0</span>
            </a>
        </div>

        @php
            $products = [
                ['id' => 1, 'name' => 'Digital Thermometer', 'price' => 15000, 'category' => 'Equipment', 'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=60'],
                ['id' => 2, 'name' => 'First Aid Kit', 'price' => 45000, 'category' => 'Emergency', 'image' => 'https://images.unsplash.com/photo-1603398938378-e54ecb44638c?auto=format&fit=crop&w=800&q=60'],
                ['id' => 3, 'name' => 'Surgical Masks (50pcs)', 'price' => 10000, 'category' => 'Protection', 'image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=800&q=60'],
                ['id' => 4, 'name' => 'Hand Sanitizer 500ml', 'price' => 8000, 'category' => 'Hygiene', 'image' => 'https://images.unsplash.com/photo-1584483766114-2cea6facdf57?auto=format&fit=crop&w=800&q=60'],
                ['id' => 5, 'name' => 'Blood Pressure Monitor', 'price' => 85000, 'category' => 'Equipment', 'image' => 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?auto=format&fit=crop&w=800&q=60'],
                ['id' => 6, 'name' => 'Vitamin C Supplements', 'price' => 12000, 'category' => 'Wellness', 'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=800&q=60'],
            ];
        @endphp

        <div class="row g-4">
            @foreach($products as $i => $product)
            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp" style="animation-delay: {{ $i * 0.1 }}s;">
                <div class="card border-0 shadow-sm rounded-4 h-100 product-card overflow-hidden">
                    <div class="product-img-box position-relative">
                        <img src="{{ $product['image'] }}" class="card-img-top" alt="{{ $product['name'] }}" style="height: 220px; object-fit: cover;">
                        <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-green-soft text-green-700 fw-bold">{{ $product['category'] }}</span>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1">{{ $product['name'] }}</h5>
                        <p class="text-green-600 fw-bold h5 mb-3">TSh {{ number_format($product['price']) }}</p>
                        <button class="btn btn-green w-100 rounded-3 py-2 fw-bold add-to-cart" 
                                data-id="{{ $product['id'] }}" 
                                data-name="{{ $product['name'] }}" 
                                data-price="{{ $product['price'] }}">
                            <i class="fas fa-cart-plus me-2"></i>ADD TO CART
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .bg-green-soft { background-color: rgba(22, 163, 74, 0.1); }
    .product-card { transition: all 0.3s ease; }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .product-img-box { overflow: hidden; }
    .product-img-box img { transition: all 0.5s ease; }
    .product-card:hover .product-img-box img { transform: scale(1.1); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = JSON.parse(localStorage.getItem('clinic_cart')) || [];
    updateCartCount();

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                qty: 1
            };

            const existing = cart.find(item => item.id === product.id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push(product);
            }

            localStorage.setItem('clinic_cart', JSON.stringify(cart));
            updateCartCount();
            
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart',
                    text: `${product.name} has been added.`,
                    showConfirmButton: false,
                    timer: 1500,
                    confirmButtonColor: '#16a34a'
                });
            }
        });
    });

    function updateCartCount() {
        const count = cart.reduce((total, item) => total + item.qty, 0);
        document.querySelectorAll('.cart-count').forEach(el => el.innerText = count);
    }
});
</script>
@endsection
