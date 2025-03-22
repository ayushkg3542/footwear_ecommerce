<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderDetails($encryptedOrderId)
{
    try {
        $orderId = decrypt($encryptedOrderId);
        $order = Orders::with('orderItems.product')->findOrFail($orderId);

        return view('order_details', compact('order'));
    } catch (\Exception $e) {
        return redirect()->route('dashboard')->with('error', 'Invalid Order!');
    }
}
}
