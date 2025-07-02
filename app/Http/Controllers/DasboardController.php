<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class DasboardController extends Controller
{
    //
    public function index(Request $request)
    {
        //dd('DashboardController@index called');
        $start = $request->input('start_date', now()->subDays(60)->format('Y-m-d'));
        $end = $request->input('end_date', now()->format('Y-m-d'));

        $rawOrders = Order::whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $labels = $rawOrders->map(fn($item) => ucfirst(str_replace('_', ' ', $item->status)) . " ({$item->total})");
        $data = $rawOrders->pluck('total');
        $statusKeys = $rawOrders->pluck('status'); // ← esto

        return view('admin.admindashboard', compact('labels', 'data', 'statusKeys', 'start', 'end'));
    }

}
