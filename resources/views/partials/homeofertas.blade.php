<div class="title title-flex">
    <div>
        <h2>Ofertas</h2>
        <span class="title-leaf">
            <svg class="icon-width">
                <use xlink:href="{{ full_asset('assets/svg/discount.svg') }}"></use>
            </svg>
        </span>
        <p>No te pierdas esta oportunidad con un descuento especial solo por esta semana.</p>
            <!-- Product Section Start -->
            <section class="product-section">
                <div class="container">
                    @foreach ($topSellingProducts->chunk(3) as $chunk)
                        <div class="row">
                            @foreach ($chunk as $product)
                                <div class="col-lg-4 col-md-4 col-sm-4 mb-4">
                                    <div class="product-box-4 p-3 bg-white rounded-3 shadow-sm h-100 position-relative wow fadeInUp"
                                        style="transition: box-shadow 0.3s ease, transform 0.3s ease;">
                                        
                                        <div class="product-image text-center mb-3">
                                            <div class="label-flex position-absolute top-0 end-0 m-2">
                                                <button class="btn btn-light btn-sm rounded-circle"
                                                    onclick="addToWishlist({{ $product->id }}, '{{ asset('storage/' . $product->image) }}', '{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}', '{{ $product->price }}' , '{{ $product->name }}')">
                                                    <i class="fa-solid fa-heart text-danger"></i>
                                                </button>
                                                
                                            </div>

                                            <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                                            </a>

                                            <ul class="option list-unstyled d-flex justify-content-center gap-2 mt-2">
                                                <li data-bs-toggle="tooltip" title="Vista Rápida">
                                                    <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                                    class="btn btn-sm btn-outline-secondary rounded-circle">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </li>
                                                <li>
                        
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#vistarapida">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="product-detail text-center">
                                            <ul class="rating list-unstyled d-flex justify-content-center mb-2">
                                                @php $rating = round($product->reviews()->avg('rating')) @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li>
                                                        <i class="fa{{ $i <= $rating ? 's' : 'r' }} fa-star text-warning"></i>
                                                    </li>
                                                @endfor
                                            </ul>

                                            <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}" class="text-decoration-none text-dark">
                                                <h6 class="fw-semibold mb-1">{{ $product->name }}</h6>
                                            </a>

                                            <h6 class="price theme-color mb-3">
                                                ${{ number_format($product->price, 2) }}
                                                @if($product->price2)
                                                    <del class="text-muted ms-2">${{ number_format($product->price2, 2) }}</del>
                                                @endif
                                            </h6>

                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <button class="btn btn-outline-secondary btn-sm px-2"
                                                        onclick="updateQuantity({{ $product->id }}, 'minus')">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>

                                                <input class="form-control form-control-sm text-center" type="text"
                                                    id="qty-{{ $product->id }}" value="1" style="width: 50px;">

                                                <button class="btn btn-outline-secondary btn-sm px-2"
                                                        onclick="updateQuantity({{ $product->id }}, 'plus')">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>

                                                <button class="btn btn-primary btn-sm"
                                                        onclick="addToCart({{ $product->id }}, '{{ asset('storage/' . $product->image) }}', '{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}', '{{ $product->price }}', '{{ $product->name }}')">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>
            <!-- Product Section End -->
    </div>
</div>
<!-- Seccion de productos frecuentes -->