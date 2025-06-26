<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
 
class BrandController extends Controller
{
    //funcion para presentar productos por marca
 public function products(Brand $brand)
    {
        $products = $brand->products()->with('brand')->get();
        //dd("estoy en el controlador de marcas y tengo " . $products->count() . " productos");
       return view('admin.cat_products.index', [
            'products' => $products,
            'title' => 'Productos de la marca: ' . $brand->name,
            'showBrand' => false,
            'readOnly' => false // Puedes hacer true si solo es visualización
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $brands = Brand::all();
        return view('admin.cat_brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cat_brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'description' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $slug = $this->makeUniqueSlug($slug);
        /*
        $iconPath = null;
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->put("brands/{$filename}", $image);

            $iconPath = "brands/{$filename}";
        }
        */
        if ($request->hasFile('icon')) {
            // Guardar imagen original sin redimensionar
            $path = $request->file('icon')->store('brands', 'public');
            
        }

        Brand::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $path,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Marca creada exitosamente.');
    }

    private function makeUniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $counter = 1;

        while (Brand::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //.
    }

     public function show_products(string $id)
    {
        //.
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $brand = Brand::findOrFail($id);
         return view('admin.cat_brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $slug = $this->makeUniqueSlug($slug, $brand->id);

        if ($request->hasFile('icon')) {
            // Eliminar imagen anterior
            if ($brand->icon && Storage::disk('public')->exists($brand->icon)) {
                Storage::disk('public')->delete($brand->icon);
            }

            // Guardar imagen original sin redimensionar
            $path = $request->file('icon')->store('brands', 'public');
            $brand->icon = $path;
        }

        $brand->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $brand->icon,
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Marca actualizada exitosamente.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'No se puede eliminar la marca porque tiene productos asociados.');
        } else {
            if ($brand->icon && Storage::disk('public')->exists($brand->icon)) {
                Storage::disk('public')->delete($brand->icon);
            }
            $brand->delete();
            return redirect()
                ->route('admin.brands.index')
                ->with('deleted', 'Marca eliminada correctamente.');
        }
    }
    
}


