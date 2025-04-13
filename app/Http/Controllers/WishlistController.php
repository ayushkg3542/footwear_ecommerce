<?php

namespace App\Http\Controllers;

use App\Models\DiscountCoupon;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function wishlist(){
        if(!auth()->check()){
            return redirect()->route('account.login')->with('error', 'You need to login to view your wishlist');
        }
        $userId = auth()->id();

        $wishlistItems = Wishlist::where('user_id',$userId)->with('product')->get();
        $deals = DiscountCoupon::where('deal_of_week', 1)->with('product.firstImage')->get();

        return view('wishlist', compact('wishlistItems','deals'));
    }

    public function addToWishlist(Request $request){
        if(!auth()->check()){
            return response()->json(['status'=>'error','message'=>'You need to log in first']);
        }

        $user = auth()->user();
        $productId = $request->product_id;

        $existingWishlist = Wishlist::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->first();

        if($existingWishlist){
            return response()->json(['status'=>'error','message'=>'Product already in wishlist']);
        }

        try{
            Wishlist::create(['user_id'=>$user->id,'product_id'=>$productId]);
            return response()->json(['status'=>'success','message'=>'Product Added to Wishlist']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','message'=>'Error Adding Product to Wishlist' . $e->getMessage()]);
        }
    }

    public function removeFromWishlist(Request $request){
        if(!auth()->check()){
            return response()->json(['status'=>'error','message'=>'You need to log in first']);
        }

        $userId = auth()->id();
        $productId = $request->product_id;
        $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if($wishlistItem){
            $wishlistItem->delete();
            return response()->json(['status'=>'success','message'=>'Product removed from wishlist']);
        }else{
            return response()->json(['status'=>'error','message'=>'Product not found in wishlist']);
        }
    }
}
