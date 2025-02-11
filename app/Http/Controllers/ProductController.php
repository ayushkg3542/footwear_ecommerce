<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ColorCode;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
     // PRODUCTS //

     public function allProducts()
     {
         $user = Auth::user();
         return view('admin.allProducts', compact('user'));
     }


 
     public function addProducts()
     {
         $user = Auth::user();
         $categories = Category::where('status','Active')->get();
         $subcategories = SubCategory::where('status','Active')->get();
         $brands = Brand::where('status','Active')->get();
         $colors = ColorCode::where('status','Active')->get();
         return view('admin.addProducts', compact('user','brands','categories','subcategories','colors'));
     }

    public function storeProducts(Request $request){
        $request->validate([
            'title' => 'required|string',
            'slug'=>'required',
            'short_description'=>'required',
            'detail_description'=>'required',
            'shipping_returns'=>'required',
            'new_price'=>'required',
            'stock'=>'required',
            'category'=>'required',
            'sku'=>'required',
            'barcode'=>'required',
            'size'=>'required',
            'quantity'=>'required',
            'images.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try{
            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->short_description = $request->short_description;
            $product->detail_description = $request->detail_description;
            $product->shipping_returns = $request->shipping_returns;
            $product->new_price = $request->new_price;
            $product->old_price = $request->old_price;
            $product->stock = $request->stock;
            $product->category = $request->category;
            $product->subcategory = $request->subcategory;
            $product->brand = $request->brand;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->colors = $request->colors;
            $product->size = $request->size;
            $product->quantity = $request->quantity;

            $product->save();
        }catch(\Exception $e){
            

        }
    }

     public function getSubcategories(Request $request)
    {
        $categoryId = $request->category_id;
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json(['subcategories' => $subcategories]);
    }
 
     // =================================================================================================================================================================
 
}