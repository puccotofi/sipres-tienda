<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    public function index() {
        // Obtener los productos más vendidos
        $topSellingProducts = Product::withCount('orderItems') // Contar la cantidad de veces que un producto se vendió
            ->orderByDesc('order_items_count') // Ordenar por los más vendidos
            ->take(6) // Tomar solo 6 productos
            ->get();
        // Obtener las categorías
        $categories = Category::all();
        //obtener las marcas
        $brands = Brand::all();
        return view('welcome', compact('topSellingProducts', 'categories', 'brands'));
    }
}
