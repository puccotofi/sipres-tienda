<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Cart;

class UserController extends Controller
{
    public function dashboard(){
        $user = auth()->user();
        $userId = $user->id;
        $userRole = $user->role;

        $totalOrdenes = Order::where('user_id', $userId)->count();
        $totalPendientes = Cart::where('user_id', $userId)->count();
        $totalWishlist = Wishlist::where('user_id', $userId)->count();

        $orders = Order::with(['orderItems.product', 'shippingAddress', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        if ($userRole == 'admin') { 
            // Si el usuario es administrador, redirigir al dashboard de administrador
            //return view('admin.admindashboard', compact('user'));
            return redirect()->route('admin.admindashboard');
        } else {
            return view('dashboard', compact('user', 'totalOrdenes', 'totalPendientes', 'totalWishlist', 'orders'));
        }
    }

    public function updateProfile(Request $request){
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:6'
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }


}
