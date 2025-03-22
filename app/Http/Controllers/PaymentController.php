<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payment;
use Auth;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => 'order_'.rand(1000, 9999),
            'amount' => $request->amount * 100, // Convert to paisa
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return response()->json(['order_id' => $order['id']]);
    }

    public function handlePayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        try {
            $payment = $api->payment->fetch($request->razorpay_payment_id);
            if ($payment->status == "captured") {
                $user = Auth::user();
                $userId = $user ? $user->id : null;
    
                $cartItems = Cart::where('user_id', $userId)->with('product')->get();
    
                // Store Order details
                $order = new Orders();
                $order->user_id = $userId;
                $order->total_amount = $payment->amount / 100;
                $order->shipping = 0; 
                $order->coupon_id = null;
                $order->coupon_code = null;
                $order->discount = 0; 
                $order->grand_total = $payment->amount / 100;
                $order->payment_method = 'prepaid';
                $order->payment_status = 'paid'; 
                $order->payment_id = $payment->id;
                $order->status = 'pending'; 
                $order->shipped_date = null;
                $order->courier_company = null;
                $order->tracking_id = null;
                $order->delivery_date = null;
                $order->name = $user->name;
                $order->email = $user->email;
                $order->phone = $user->phone;
                $order->country = 'India';
                $order->address = $user->address;
                $order->city = $user->city;
                $order->state = $user->state;
                $order->pincode = $user->pincode;
                $order->save();
    
                // Store Order Items
                $orderItems = [];
                foreach ($cartItems as $cartItem) {
                    $orderItem = new OrderItems();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $cartItem->product_id;
                    $orderItem->transactionid = $payment->id;
                    $orderItem->quantity = $cartItem->qty;
                    $orderItem->price = $cartItem->product->new_price;
                    $orderItem->total = $cartItem->qty * $cartItem->product->new_price;
                    $orderItem->save();
                    
                    $orderItems[] = $orderItem;
                }
    
                // Store Payment details
                $orderDetails = session('order_details', []);
                $paymentRecord = new Payment();
                $paymentRecord->user_id = $userId;
                $paymentRecord->razorpay_payment_id = $payment->id;
                $paymentRecord->order_id = $order->id;
                $paymentRecord->amount = $payment->amount / 100;
                $paymentRecord->currency = $payment->currency;
                $paymentRecord->status = $payment->status;
                $paymentRecord->product_details = json_encode($orderDetails);
                $paymentRecord->save();
    
                // Clear Cart
                Cart::where('user_id', $userId)->delete();
                session()->forget('cart_count');
    
                // Return JSON response instead of redirecting
                return response()->json([
                    'message' => 'Payment recorded successfully!',
                    'order' => $order,
                    'order_items' => $orderItems,
                    'payment' => $paymentRecord
                ]);
            } else {
                return response()->json([
                    'message' => 'Payment failed',
                    'status' => 'error'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}


// 