<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ColorCode;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
     // PRODUCTS //

     public function allProducts()
     {
         $user = Auth::user();
         $products = Product::select(
            'products.*',
            'categories.category as category_name',
            'sub_categories.subcategory as subcategory_name',
            'brands.brand as brand_name'
        )
        ->leftJoin('categories', 'products.category', '=', 'categories.id')
        ->leftJoin('sub_categories', 'products.subcategory', '=', 'sub_categories.id')
        ->leftJoin('brands', 'products.brand', '=', 'brands.id')
        ->get();
         return view('admin.allProducts', compact('user','products'));
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
        // dd($request->all());
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
            'colors' => 'required|array',
            'colors.*' => 'integer',    
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
            $product->colors = implode(',', $request->colors); 
            $product->size = $request->size;
            $product->quantity = $request->quantity;
            $product->status = $request->status;
            $product->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                    $image->move(public_path('product_images'), $imageName);
    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'images' => $imageName
                    ]);
                }
            }

            
            return response()->json([
                'status' => 'success',
                'message' => 'Product stored successfully!'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during storing product details. Please try again later.' . $e->getMessage()
            ]);

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