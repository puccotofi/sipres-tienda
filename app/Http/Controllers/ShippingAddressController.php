<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ShippingAddress;

class ShippingAddressController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'country' => 'required',
        ]);

        ShippingAddress::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
        ]);

        return redirect()->back()->with('success', 'Dirección agregada correctamente.');
    }

    public function storeAddress(Request $request){
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'country' => 'required',
        ]);

        ShippingAddress::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
        ]);

        return redirect()->back()->with('success', 'Dirección guardada correctamente.');
    }

    public function updateAddress(Request $request, $id){
        $address = ShippingAddress::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'country' => 'required',
        ]);

        $address->update($request->all());

        return redirect()->back()->with('success', 'Dirección actualizada.');
    }

    public function destroyAddress($id){
        $address = ShippingAddress::where('user_id', auth()->id())->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Dirección eliminada.');
    }

}
