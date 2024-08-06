<?php
// app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch today's orders
        $today = Carbon::today();
        $orders = Order::with('orderItems')->whereDate('created_at', $today)->get();

        // Calculate total sales from order items
        $totalSales = $orders->flatMap->orderItems->sum(function ($orderItem) {
            return $orderItem->quantity * $orderItem->price;
        });

        return view('report.index', [
            'orders' => $orders,
            'totalSales' => $totalSales
        ]);
    }
}

