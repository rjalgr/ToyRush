<div class="card product-card h-100 border-0 shadow-sm rounded-3">

    {{-- Image --}}
    <a href="{{ route('user.products.show', $product) }}" class="position-relative d-block overflow-hidden rounded-top-3">
        @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}"
                 class="card-img-top product-img"
                 alt="{{ $product->name }}"
                 style="height:200px;object-fit:cover;transition:transform .3s"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'">
        @else
            <div class="product-img d-flex align-items-center justify-content-center bg-light"
                 style="height:200px;font-size:4rem">🧸</div>
        @endif

        {{-- Badges --}}
        @if($product->sale_price)
            <span class="badge position-absolute top-0 start-0 m-2"
                  style="background:#FF6B35;font-size:.7rem">SALE</span>
        @endif
        @if($product->is_featured)
            <span class="badge position-absolute top-0 end-0 m-2"
                  style="background:#FFD700;color:#333;font-size:.7rem">⭐ Featured</span>
        @endif
    </a>

    {{-- Body --}}
    <div class="card-body d-flex flex-column p-3">
        <p class="text-muted mb-1" style="font-size:.75rem">{{ $product->category->name }}</p>
        <h6 class="fw-bold mb-2 lh-sm">
            <a href="{{ route('user.products.show', $product) }}"
               class="text-dark text-decoration-none stretched-link-off">
                {{ $product->name }}
            </a>
        </h6>

        <div class="mt-auto">
            {{-- Price + Stock --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    @if($product->sale_price)
                        <span class="text-decoration-line-through text-muted small">
                            ₱{{ number_format($product->price, 2) }}
                        </span>
                        <span class="d-block fw-bold" style="color:#FF6B35;font-size:1.05rem">
                            ₱{{ number_format($product->sale_price, 2) }}
                        </span>
                    @else
                        <span class="fw-bold" style="color:#FF6B35;font-size:1.05rem">
                            ₱{{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>
                @if($product->stock > 0)
                    <span class="badge bg-success-subtle text-success small">In Stock</span>
                @else
                    <span class="badge bg-danger-subtle text-danger small">Out of Stock</span>
                @endif
            </div>

            {{-- Action Button --}}
            @auth
                @if($product->stock > 0)
                    <form method="POST" action="{{ route('user.cart.add', $product) }}">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-cart-plus me-1"></i>Add to Cart
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-sm w-100" disabled>Out of Stock</button>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login to Buy
                </a>
            @endauth
        </div>
    </div>
</div>