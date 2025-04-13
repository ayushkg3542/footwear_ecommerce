<?php

namespace App\Http\Controllers;
use App\Mail\OrderStatusMail;
use App\Models\Orders;
use App\Models\Review;
use Auth;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function orderList(Request $request)
{
    $query = Orders::with('orderItems.product', 'user');
    
    if ($request->has('id') && $request->id != '') {
        $query->where('id', $request->id);
    }

    if ($request->has('name') && $request->name != '') {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%');
        });
    }

    if ($request->has('from_date') && $request->from_date != '') {
        $query->whereDate('created_at', '>=', $request->from_date);
    }

    if ($request->has('to_date') && $request->to_date != '') {
        $query->whereDate('created_at', '<=', $request->to_date);
    }


    $orders = $query->get();

    // Stats (same as before)
    $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
    $orderCount = $todayOrders->count();  
    $totalOrderCount = Orders::count();
    $pendingOrder = Orders::where('status','pending')->count();
    $completedOrder = Orders::where('status','delivered')->count();
    $orderRefunded = Orders::where('status','redunded')->count();
    $adminuser = Auth::guard('admin')->user();

    // AJAX response with only table rows
    if ($request->ajax()) {
        return response()->json([
            'html' => view('admin.searchedOrderList', compact('orders'))->render()
        ]);
    }

    return view('admin.orderList', compact(
        'adminuser',
        'todayOrders',
        'orderCount',
        'orders',
        'totalOrderCount',
        'pendingOrder',
        'completedOrder',
        'orderRefunded'
    ));
}


    public function orderDetails($order){
        try {
            $orderId = decrypt($order); 
        } catch (\Exception $e) {
            abort(404);
        }
            $orderDetails = Orders::with('orderItems.product', 'user')
                    ->where('id', $orderId)
                    ->firstOrFail();
            $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
            $orderCount = $todayOrders->count();  
            $adminuser = Auth::guard('admin')->user();
            return view('admin.orderDetails', compact('adminuser','todayOrders','orderCount','orderDetails'));
    }

    public function updateOrderStatus(Request $request){
        $request->validate([
            'order_id' => 'required',
            'status' => 'required'
        ]);

        $order = Orders::find($request->order_id);
        $order->status = $request->status;

        if($request->status == 'shipped'){
            $order->shipped_date = now();
        }elseif($request->status == 'delivered'){
            $order->delivery_date = now();
        }

        $order->save();

        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusMail($order));
        }

        return response()->json(['message'=>'Order status updated successfully']);
    }



}