<?php

namespace App\Http\Controllers;

use App\Models\Brand;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
   
        return view('admin.cat_products.create', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'suppliers' => Supplier::orderBy('name')->get(),
            'title' => 'Crear Producto',
        ]);
    }

    public function store(Request $request)
    {
                $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:products,slug',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'price2' => 'nullable|numeric|min:0',
                'brand_id' => 'required|exists:brands,id',
                'category_id' => 'required|exists:categories,id',
                'suppliers' => 'nullable|array',
                'suppliers.*' => 'exists:suppliers,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            ]);

            $slug = $request->slug ?: Str::slug($request->name);
            $slug = $this->makeUniqueSlug($slug);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            $product = Product::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'price2' => $request->price2,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'image' => $imagePath,
            ]);
            // Sincronizar proveedores si se proporcionaron
            if ($request->has('suppliers')) {
                $product->suppliers()->sync($request->suppliers);
            }

            return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
        }

    private function makeUniqueSlug($baseSlug)
        {
            $slug = $baseSlug;
            $counter = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            return $slug;
        }//

    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();
        $categories = Category::all();
        //$product= Product::findOrFail($product->id);
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.cat_products.edit', compact('product', 'brands', 'categories','suppliers'))
            ->with('title', 'Editar Producto')
            ->with('showBrand', true) // Mostrar marcas
            ->with('readOnly', false); // Puedes hacer true si solo es visualización
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price2' => 'nullable|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'exists:suppliers,id',
        ]);
        
        $slug = $request->slug ?: Str::slug($request->name);
        $slug = $this->makeUniqueSlug($slug, $product->id);

        // Si subieron una nueva imagen
        if ($request->hasFile('image')) {
            // Borra imagen anterior si existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        $product->suppliers()->sync($request->suppliers ?? []);
        // Actualiza el resto de campos
        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'price2' => $request->price2,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'image' => $product->image,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }


   public function destroy(Product $product)
    {
        // Verifica si el producto tiene registros de ventas
        if ($product->orderItems()->exists()) {
            return redirect()
                ->route('admin.products.index')
                ->with('error', 'No se puede eliminar el producto porque tiene registros de ventas.');
        }else{
            // Elimina la imagen si existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            return redirect()
                ->route('admin.products.index')
                ->with('deleted', 'Producto eliminado correctamente.');
        }
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
