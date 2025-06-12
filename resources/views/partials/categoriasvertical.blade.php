<div class="col-xxl-3 col-xl-4 d-none d-xl-block">
    <div class="p-sticky">
        <div class="category-menu">
            <h3>Compra por Categorías</h3>
            <ul class="border-bottom-0">
                @foreach ($categories as $category)
                    <li>
                        <div class="category-list d-flex align-items-center gap-2 py-2">
                            <img src="{{ full_asset('storage/' . $category->icon) }}" class="blur-up lazyload" alt="{{ $category->name }}" width="30" height="30">
                            <h5 class="mb-0">
                                <a href="{{ route('categories.products', $category->id) }}" class="text-dark text-decoration-none">
                                    {{ $category->name }}
                                </a>
                            </h5>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>