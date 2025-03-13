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
         $adminuser = Auth::guard('admin')->user();

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
         return view('admin.allProducts', compact('adminuser','products'));
     }


 
     public function addProducts()
     {
         $adminuser = Auth::guard('admin')->user();

         $categories = Category::where('status','Active')->get();
         $subcategories = SubCategory::where('status','Active')->get();
         $brands = Brand::where('status','Active')->get();
         $colors = ColorCode::where('status','Active')->get();
         return view('admin.addProducts', compact('adminuser','brands','categories','subcategories','colors'));
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

    public function editProduct(Request $request, $id){
        $adminuser = Auth::guard('admin')->user();
        $productData = Product::find($id);
        if (!$productData) {
            return redirect()->route('productList')->with('error', 'Product not found');
        }
        $categories = Category::where('status','Active')->get();
        $subcategories = SubCategory::where('status','Active')->get();
        $brands = Brand::where('status','Active')->get();
        $colors = ColorCode::where('status','Active')->get();
        return view('admin.editProduct',compact('adminuser','productData','categories','subcategories','brands','colors'));
    }


    public function modifyProduct(Request $request, $id = null)
    {
        // dd($request->all());
        // die();
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required',
            'short_description' => 'required',
            'detail_description' => 'required',
            'shipping_returns' => 'required',
            'new_price' => 'required',
            'stock' => 'required',
            'category' => 'required',
            'sku' => 'required',
            'barcode' => 'required',
            'size' => 'required',
            'quantity' => 'required',
            'colors' => 'required|array',
            'colors.*' => 'integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deleted_images' => 'nullable|array' // array of filenames to be deleted
        ]);

        try {
            $product = Product::findOrFail($id);

            // Update basic fields
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

            // Handle deleted images
            if ($request->has('deleted_images')) {
                foreach ($request->deleted_images as $deletedImage) {
                    $productImage = ProductImage::where('product_id', $product->id)
                        ->where('images', $deletedImage)
                        ->first();

                    if ($productImage) {
                        $imagePath = public_path('product_images/' . $productImage->images);
                        if (file_exists($imagePath)) {
                            unlink($imagePath); // Delete file from storage
                        }
                        $productImage->delete(); // Delete record from DB
                    }
                }
            }

            // Handle new images upload
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
                'message' => 'Product updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during updating product details. Please try again later. ' . $e->getMessage()
            ]);
        }
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => 'fail', 'message' => 'Product not found']);
        }
    
        try {
            $product->delete();
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['status' => 'fail', 'message' => 'An error occurred']);
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