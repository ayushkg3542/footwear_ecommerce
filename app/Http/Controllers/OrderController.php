<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orders;
use App\Models\Review;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderDetails($encryptedOrderId)
{
    try {
        $orderId = decrypt($encryptedOrderId);
        $order = Orders::with('orderItems.product')->findOrFail($orderId);

        $productIds = $order->orderItems->pluck('product_id')->toArray();

        $existingReviews = Review::where('user_id', auth()->id())
            ->where('order_id', $order->id)
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id'); 

        return view('order_details', compact('order', 'existingReviews'));
    } catch (\Exception $e) {
        return redirect()->route('dashboard')->with('error', 'Invalid Order!');
    }
}

public function storeReview(Request $request){
    try{
        $request->validate([
            'rating' => 'required',
            'review' => 'nullable',
            'order_id' => 'required',
            'product_id' => 'required',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
        return response()->json(['status'=>'success','message'=>'Thank your review']);

    }catch(\Exception $e){
        return response()->json(['status'=>'success','message' => 'Error while storing review', $e->getMessage()]);
    }
}
}
