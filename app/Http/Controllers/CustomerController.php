<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Visit;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Main view Customers
    public function view()
    {
        if (Auth::guest()) {
            return redirect('login');
        }
        return view('customers.index', [
            'customers' => Customer::paginate(3),
            'visits' => Visit::all()
        ]);
    }

}