@extends('layouts.app') {{-- O el layout principal que uses --}}

@section('content')
<section class="product-section py-5">
    <div class="container-fluid-lg">
        <div class="title mb-4 text-center">
            <h2>{{ $category->name }}</h2>
            <p class="text-muted">Explora los productos de esta categoría</p>
        </div>

        @if($products->count())
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-box-4 p-3 bg-white rounded-3 shadow h-100 position-relative wow fadeInUp"
                            style="transition: box-shadow 0.3s ease, transform 0.3s ease;">
                            
                            <div class="product-image text-center mb-3">
                                <div class="label-flex position-absolute top-0 end-0 m-2">
                                    
                                    
                                </div>

                                <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
                                </a>

                                <ul class="option list-unstyled d-flex justify-content-center gap-2 mt-2">
                                    
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar a Favoritos">
                                        <button class="btn btn-light btn-sm rounded-circle"
                                            onclick="addToWishlist({{ $product->id }}, '{{ asset('storage/' . $product->image) }}', '{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}', '{{ $product->price }}' , '{{ $product->name }}')">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </li>
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Vista Rápida">
                                        <button class="btn btn-light btn-sm rounded-circle"
                                            data-bs-toggle="modal"
                                            data-bs-target="#quickViewModal"
                                            onclick="openQuickViewModal(this)"
                                            data-name="{{ $product->name }}"
                                            data-image="{{ asset('storage/' . $product->image) }}"
                                            data-price="{{ number_format($product->price, 2) }}"
                                            data-price2="{{ number_format($product->price2, 2) }}"
                                            data-description="{{ $product->description }}"
                                            data-brand="{{ $product->brand->name }}"
                                            data-code="PROD-{{ $product->id }}"
                                            data-url="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                            data-id="{{ $product->id }}"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </li>

                                </ul>
                            </div>

                            <div class="product-detail text-center">
                           
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
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="alert alert-info text-center">
                No hay productos disponibles en esta categoría.
            </div>
        @endif
    </div>
</section>
@endsection