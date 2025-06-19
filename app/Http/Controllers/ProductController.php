<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{

    public function index()
    {
         $products = Product::all();
        //dd("estoy en el controlador de marcas y tengo " . $products->count() . " productos");
       return view('admin.cat_products.index', [
            'products' => $products,
            'title' => 'Todos Los Productos ',
            'showBrand' => true,
            'readOnly' => false // Puedes hacer true si solo es visualización
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
 
    public function details($id, $slug){
        // Buscar el producto
        $product = Product::where('id', $id)->where('slug', $slug)->firstOrFail();

        // Obtener los 6 productos más vendidos
        $topSellingProducts = $this->getTopSellingProducts();

        return view('products.details', compact('product', 'topSellingProducts'));
    }

    public function getTopSellingProducts($limit = 6){
        //dd('Obteniendo los productos más vendidos con un límite de ' . $limit);
        return Product::withCount('orderItems') // Contar la cantidad de veces que un producto fue vendido
            ->orderByDesc('order_items_count') // Ordenar por los más vendidos
            ->take($limit) // Tomar solo los productos que se necesiten
            ->get();
    }

    public function shop(Request $request)
    {
        // Convertir las categorías en un array si están en formato "1,2,3"
        $categoriesFilter = $request->has('categories')
            ? explode(',', $request->input('categories'))
            : [];

        $brandsFilter = $request->has('brands')
            ? explode(',', $request->input('brands'))
            : [];

        $pricesFilter = $request->has('prices')
            ? explode(',', $request->input('prices'))
            : [];

        $ratingsFilter = $request->has('ratings')
            ? explode(',', $request->input('ratings'))
            : [];

        $search = $request->input('search'); // Obtener texto de búsqueda

        // Consultar productos con filtro de categorías múltiple
        $products = Product::with('category')
            ->when(!empty($categoriesFilter), function ($query) use ($categoriesFilter) {
                return $query->whereIn('category_id', $categoriesFilter);
            })
            ->when(!empty($brandsFilter), function ($query) use ($brandsFilter) {
                return $query->whereIn('brand_id', $brandsFilter);
            })
            ->when(!empty($pricesFilter), function ($query) use ($pricesFilter) {
                return $query->where(function ($q) use ($pricesFilter) {
                    foreach ($pricesFilter as $priceRange) {
                        [$min, $max] = explode('-', $priceRange);
                        $q->orWhereBetween('price', [(int)$min, (int)$max]);
                    }
                });
            })
            ->when(!empty($ratingsFilter), function ($query) use ($ratingsFilter) {
                return $query->whereIn('id', function ($subQuery) use ($ratingsFilter) {
                    $subQuery->select('product_id')
                        ->from('reviews')
                        ->groupBy('product_id')
                        ->havingRaw('AVG(rating) IN (' . implode(',', array_map('intval', $ratingsFilter)) . ')');
                });
            })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->paginate(12); // Se mantiene la paginación

        // Obtener todas las categorías para los filtros
        $categories = Category::all();
        $brands = Brand::all();

        return view('shop.index', compact('products','brands', 'categories', 'categoriesFilter', 'brandsFilter','pricesFilter','ratingsFilter', 'search'));
    }
}
