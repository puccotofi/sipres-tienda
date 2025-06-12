<div class="title">
    <h2>Explora por categorías</h2>
    <span class="title-leaf">
       
    </span>
</div>
<div class="category-slider-2 product-wrapper no-arrow">
    @foreach($categories as $category)
        <div>
            <a href="{{ route('categories.products', $category->id) }}" class="category-box category-dark">
                <div>
                    <img src="{{ full_asset('storage/' . $category->icon) }}" class="blur-up lazyload" alt="{{ $category->name }}">
                    <h5>{{ $category->name }}</h5>
                </div>
            </a>
        </div>
    @endforeach
</div>