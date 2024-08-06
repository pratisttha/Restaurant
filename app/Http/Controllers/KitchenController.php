<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Tables;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KitchenController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return redirect('/login');
        } else {
            $orderItems = OrderItem::all();
            $pendings = OrderItem::where('status', 'pending')->where('type', 0)->paginate(5, ['*'], 'pendings');
            $cookings = OrderItem::where('status', 'cooking')->where('type', 0)->paginate(5, ['*'], 'cookings');
            $dones = OrderItem::where('status', 'done')->where('type', 0)->paginate(5, ['*'], 'dones');
            $items = Items::all();
            $tables = Tables::all();




            return view('kitchen.index', [
                'title' => 'Kitchen',
                'orderItems' => $orderItems,
                'pendings' => $pendings,
                'cookings' => $cookings,
                'dones' => $dones,
                'items' => $items,
                'tables' => $tables
            ]);
        }
    }
}
