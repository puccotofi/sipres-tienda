<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.cat_suppliers.index', compact('suppliers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cat_suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->only([
            'name', 'contact_name', 'phone', 'phone2', 'email', 'address'
        ]));

        return redirect()->route('admin.suppliers.index')
                        ->with('success', 'Proveedor creado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Supplier $supplier)
    {
        return view('admin.cat_suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->only([
            'name', 'contact_name', 'phone', 'phone2', 'email', 'address'
        ]));

        return redirect()->route('admin.suppliers.index')
                        ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Supplier $supplier)
    {
        if ($supplier->products()->exists()) {
            return redirect()
                ->route('admin.suppliers.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene productos asociados.');
        } else {
            $supplier->delete();

            return redirect()
                ->route('admin.suppliers.index')
                ->with('deleted', 'Proveedor eliminado correctamente.');
        }
    }
    public function products(Supplier $supplier)
    {
        $products = $supplier->products()->with('brand', 'category')->get();

        return view('admin.cat_products.index', [
            'products' => $products,
            'title' => 'Productos del proveedor: ' . $supplier->name,
            'showBrand' => true,
            'readOnly' => false
        ]);
    }
}
