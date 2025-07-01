<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use App\Models\OrderItem;
Use App\Models\Order; // Assuming you have an Order model
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $orders = Order::latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Vista de los detalles de una orden específica.
     */

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product','shippingAddress','histories.user']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function addProduct(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $price = $product->price;
        $ivaproduct = $product->price2; 
        $iva = round(($ivaproduct) * $quantity, 2);
        $subTotal = round(($price) * $quantity, 2);
        $subTotal+= $iva; // Sumar IVA al subtotal

        $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $price,
            'iva' => $iva,
            'subtotal' => $subTotal,
        ]);

        // Actualizar totales de la orden
        $order->iva = $order->orderItems()->sum('iva');
        $order->total_price = $order->orderItems()->sum('subtotal');
        $order->save();

         History::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'action' => 'Adición de producto',
            'comment' => 'Producto agregado: ' . $product->name . ' (Cantidad: ' . $quantity . ')',
        ]);
        return redirect()->route('admin.orders.show', $order)->with('success', 'Producto agregado al pedido.');
    }
    public function removeProduct(Order $order, OrderItem $orderItem)
    {
        // Asegurar que el producto pertenece a la orden
        if ($orderItem->order_id !== $order->id) {
            abort(403, 'No autorizado');
        }

        $orderItem->delete();

        // Recalcular totales
        $order->iva = $order->orderItems()->sum('iva');
        $order->total_price = $order->orderItems()->sum('subtotal');
        $order->save();
        History::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'action' => 'Eliminación de producto',
            'comment' => 'Producto eliminado: ' . $orderItem->product->name,
        ]);

        return redirect()->route('admin.orders.show', $order)
                        ->with('deleted', 'Producto eliminado del pedido.');
    }

    public function editShippingAddress(Order $order)
    {
        $order->load('user.shippingAddresses');
        $addresses = $order->user->shippingAddresses;
        //dd($addresses);
        return view('admin.orders.addresses', compact('order', 'addresses'));
    }
    public function updateShippingAddress(Order $order, ShippingAddress $address)
    {
        // Validar que la dirección pertenece al usuario del pedido
        if ($address->user_id !== $order->user_id) {
            abort(403, 'No autorizado');
        }

        // asignar la dirección de envío al pedido
        $order->user_address_id = $address->id;
        $order->save();

        return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Dirección de envío actualizada.');
    }
    public function storeShippingAddress(Request $request, Order $order)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
        ]);

        $order->user->shippingAddresses()->create([
            'user_id' => $order->user_id,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => 'Mexico', // Puedes cambiar esto si es necesario
        ]);

        return redirect()->route('admin.orders.addresses', $order)
                        ->with('success', 'Dirección registrada correctamente.');
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:recibida,en_cotizacion,cotizada,enviada,entregada,pagada,cerrada,cancelada',
        ]);

        $order->status = $request->status;
        $order->save();

        History::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'action' => 'Cambio de estatus',
            'comment' => 'Se cambió el estatus a: ' . $request->status,
        ]);

        return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Estatus actualizado correctamente.');
    }

    public function addNote(Request $request, Order $order)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        History::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'action' => 'Nota manual',
            'comment' => $request->comment,
        ]);

        return redirect()->route('admin.orders.show', $order)
                        ->with('success', 'Nota registrada correctamente.');
    }
    public function print(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'shippingAddress']);

        $pdf = Pdf::loadView('admin.orders.pdforder', compact('order'))
                ->setPaper('letter');

        return $pdf->stream('pedido_' . $order->id . '.pdf');
    }
}
