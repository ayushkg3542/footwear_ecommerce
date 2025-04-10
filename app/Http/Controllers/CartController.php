<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DiscountCoupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // dd($request->all());
        // die();
        $productId = $request->product_id;
        $product = Product::find($productId);
    
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product Not Found']);
        }
    
        if (auth()->check()) {
            $userId = auth()->id();
            $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
    
            if ($cart) {
                $cart->increment('qty');
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'qty' => 1,
                    'status' => 'pending',
                ]);
            }
    
            $cartCount = Cart::where('user_id', $userId)->sum('qty');
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] += 1;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'qty' => 1,
                ];
            }
            session()->put('cart', $cart);
    
            // Get updated cart count for guest user
            $cartCount = array_sum(array_column($cart, 'qty'));
        }
    
        // Store cart count in session
        session()->put('cart_count', $cartCount);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Product Added to Cart',
            'cart_count' => $cartCount
        ]);
    }
    

    public function cart()
    {
        $cartProducts = Cart::where('status', 'pending')
            ->where('user_id', auth()->id())
            ->with('product')
            ->get();
    
        return view('cart', compact('cartProducts'));
    }

    public function removeCart(Request $request)
    {
        $cartId = $request->cart_id;
    
        if (auth()->check()) {
            // If user is logged in, remove from database cart
            $cartItem = Cart::find($cartId);
            if (!$cartItem) {
                return response()->json(['status' => 'error', 'message' => 'Product not found in cart']);
            }
    
            try {
                $cartItem->delete();
                
                // Get updated cart count from DB
                $cartCount = Cart::where('user_id', auth()->id())->sum('qty');
    
                // Store the updated count in session
                session(['cart_count' => $cartCount]);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Product removed from cart',
                    'cart_count' => $cartCount
                ]);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Error removing product from cart']);
            }
        } else {
            // If user is a guest, remove from session cart
            $cart = session()->get('cart', []);
            if (!isset($cart[$cartId])) {
                return response()->json(['status' => 'error', 'message' => 'Product not found in cart']);
            }
    
            unset($cart[$cartId]); // Remove product from session
            session()->put('cart', $cart);
    
            // Update session cart count
            $cartCount = array_sum(array_column($cart, 'qty'));
            session(['cart_count' => $cartCount]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart',
                'cart_count' => $cartCount
            ]);
        }
    }
    

    public function updateCartQuantity(Request $request)
    {
        $cartId = $request->cart_id;
        $newQty = $request->quantity;
    
        if (auth()->check()) {
            // If user is logged in, update DB
            $cartItem = Cart::find($cartId);
            if (!$cartItem) {
                return response()->json(['status' => 'error', 'message' => 'Product not found in cart']);
            }
    
            if ($newQty <= 0) {
                $cartItem->delete();
                $totalPrice = 0;
            } else {
                $cartItem->update(['qty' => $newQty]);
                $totalPrice = $cartItem->product->new_price * $newQty;
            }
    
            // Get the updated cart count from DB
            $cartCount = Cart::where('user_id', auth()->id())->sum('qty');
            // dd($cartCount);
            session(['cart_count' => $cartCount]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated',
                'cart_count' => $cartCount,
                'total_price' => number_format($totalPrice, 2)  // Add this line

            ]);
        } else {
            // Guest user - update session
            $cart = session()->get('cart', []);
            if (isset($cart[$cartId])) {
                if ($newQty <= 0) {
                    unset($cart[$cartId]);
                    $totalPrice = 0;
                } else {
                    $cart[$cartId]['qty'] = $newQty;
                    $totalPrice = $cart[$cartId]['price'] * $newQty;
                }
            }
    
            session()->put('cart', $cart);
            $cartCount = array_sum(array_column($cart, 'qty'));
            // dd($cartCount);
            // die();
            session(['cart_count' => $cartCount]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated',
                'cart_count' => $cartCount,
                'total_price' => number_format($totalPrice, 2)  // Add this line

            ]);
        }
    }

    public function checkout() {
        $user = auth()->user();
    
        if (!$user || !$user->id) {
            return redirect()->route('home')->with('error', 'User not found.');
        }
    
        $address = \DB::table('user_addresses')->where('user_id', $user->id)->first();
        $cartItems = \DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $user->id)
            ->select('products.title', 'products.new_price', 'carts.qty')
            ->get();
    
        return view('checkout', compact('user', 'address', 'cartItems'));
    }
    

    public function checkoutStore(Request $request)
    {
        $orderDetails = [
            'products' => $request->cartItems, // Ensure cart items are passed in the request
            'subtotal' => $request->subtotal,
            'shipping' => 50,
            'total' => $request->subtotal + 50
        ];

        Session::put('order_details', $orderDetails);
        return response()->json(['message' => 'Order stored successfully']);
    }

    public function applyCoupon(Request $request){
        $code = strtoupper($request->coupon_code);

        if ($code !== 'SHOP123') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.'
            ]);
        }
    
        // Get the first active coupon from the database
        $coupon = DiscountCoupon::where('status', 'Active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
    
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not available currently.'
            ]);
        }
    
        // Example: Get cart subtotal (adjust this logic based on your actual cart data)
        $cartItems = \DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', auth()->id())
            ->select('products.new_price', 'carts.qty')
            ->get();
    
        $subtotal = $cartItems->sum(fn($item) => $item->new_price * $item->qty);
    
        $discountPercent = (float) $coupon->{'discount_percentage'};
        $discountAmount = ($subtotal * $discountPercent) / 100;
    
        $maxAmount = (float) ($coupon->{'max_amount'} ?? $coupon->{'upto_amount'});
        $finalDiscount = min($discountAmount, $maxAmount);
    
        $shipping = 50;
        $total = $subtotal - $finalDiscount + $shipping;
    
        // Store in session
        session()->put('discount', $finalDiscount);
        session()->put('applied_coupon', $code);
    
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => number_format($finalDiscount, 2),
            'total' => number_format($total, 2)
        ]);
    }

    public function removeCoupon()
{
    session()->forget(['applied_coupon', 'discount']);
    return response()->json(['success' => true, 'message' => 'Coupon removed successfully.']);
}
    
}
// 