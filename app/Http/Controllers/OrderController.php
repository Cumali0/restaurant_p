<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function paymentPage(Order $order)
    {
        return view('payment', compact('order'));
    }
}

