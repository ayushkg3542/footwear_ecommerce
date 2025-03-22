<?php

namespace App\Http\Controllers;
use App\Models\Orders;
use Auth;

use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function orderList(){
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count();  
        $adminuser = Auth::guard('admin')->user();
        return view('admin.orderList', compact('adminuser' ,'todayOrders','orderCount'));
    }

    public function orderDetails(){
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count();  
        $adminuser = Auth::guard('admin')->user();
        return view('admin.orderDetails', compact('adminuser','todayOrders','orderCount'));
    }
}
