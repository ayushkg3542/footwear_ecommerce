<?php

namespace App\Http\Controllers;

use App\Models\DiscountCoupon;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function couponList(){
        $adminuser = Auth::guard('admin')->user();
        $coupon = DiscountCoupon::get();
        return view('admin.manageCoupon',compact('adminuser','coupon'));
    }

    public function manageCoupon(Request $request, $id = null){
        $adminuser = Auth::guard('admin')->user();

        $products = Product::where('status','Active')->get();
        $coupon = null;
        if($id){
            $coupon = DiscountCoupon::with('product')->find($id);
        }

        return view('admin.addCoupon',compact('adminuser','products','coupon'));
    }


    public function storeCoupon(Request $request) {
        try {
            if ($request->has('discount_id')) {
                $discount = DiscountCoupon::find($request->discount_id);

                if (!$discount) {
                    return response()->json(['status' => 'fail', 'message' => 'Discount not found']);
                }

                if ($request->has('product_id')) {
                    $productid = $request->product_id;
                    $existingDiscount = DiscountCoupon::where('product_id', $productid)
                        ->where('id', '!=', $discount->id)
                        ->first();

                    if ($existingDiscount) {
                        return response()->json(['status' => 'fail', 'message' => 'Product already has a discount!']);
                    }

                    $discount->product_id = $productid;
                }

            } else {
                $productid = $request->product_id;
                $existingDiscount = DiscountCoupon::where('product_id', $productid)->first();
                if ($existingDiscount) {
                    return response()->json(['status' => 'fail', 'message' => 'Product already has a discount!']);
                }

                $discount = new DiscountCoupon;
                $discount->product_id = $productid;
            }

            // Validate discount percentage
            $discountpercentage = $request->discount_percentage;
            if ($discountpercentage == 0 || $discountpercentage > 100) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Please set Discount percentage between 1 and 100',
                    'errortype' => 'discounterror'
                ]);
            }

            // Format dates
            $discountstartdate = date('Y-m-d', strtotime($request->start_date));
            $discountenddate = date('Y-m-d', strtotime($request->end_date));

            // Save discount details
            $discount->start_date = $discountstartdate;
            $discount->end_date = $discountenddate;
            $discount->discount_percentage = $discountpercentage;
            $discount->upto_amount = $request->upto_amount;
            $discount->max_amount = $request->max_amount;
            $discount->status = $request->status;
            $discount->save();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'An error occurred while saving the discount: ' . $e->getMessage()
            ]);
        }
    }

}
