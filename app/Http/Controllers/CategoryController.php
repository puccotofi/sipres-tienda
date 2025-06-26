<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.cat_categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cat_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        // Verifica que el slug sea único
        $slug = $this->makeUniqueSlug($slug);

        $iconPath = "iconpath/default.png"; // Ruta por defecto si no se sube una imagen

        // Si se sube un archivo de icono, lo guardamos
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $iconPath,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    // Método auxiliar privado para garantizar slugs únicos
    private function makeUniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }
        return $slug;
    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.cat_categories.edit', compact('category'));
    }
   


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $slug = $this->makeUniqueSlug($slug, $category->id);

        // Reemplazar ícono si se carga uno nuevo
        
        $iconPath = "iconpath/default.png"; // Ruta por defecto si no se sube una imagen

        // Si se sube un archivo de icono, lo guardamos
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('categories', 'public');
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'icon' => $iconPath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        } else {
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }

            $category->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('deleted', 'Categoría eliminada correctamente.');
        }
    }
     /**
     * Muestra los productos de una categoría específica.
     */
    public function show(string $id)
    {
        //.

        $category = Category::where('id', $id)->firstOrFail();
        $products = $category->products()->where('status', 'active')->paginate(12);
        return view('categories.show', compact('category', 'products'));
    }
    // funcion para mostrar los productos de una categoría específica en el panel de administración
    public function products(Category $category)
    {
        $products = $category->products()->with('category')->get();
        //dd("estoy en el controlador de marcas y tengo " . $products->count() . " productos");
       return view('admin.cat_products.index', [
            'products' => $products,
            'title' => 'Productos de la Categoria: ' . $category->name,
            'showBrand' => false,
            'readOnly' => false // Puedes hacer true si solo es visualización
        ]);
    }
}
