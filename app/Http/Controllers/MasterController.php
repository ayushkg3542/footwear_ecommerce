<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\ColorCode;
use App\Models\Orders;
use App\Models\SubCategory;
use App\Models\ShippingCharge;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Storage;



use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function category()
    {
        $adminuser = Auth::guard('admin')->user();
        $categories = Category::get();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count(); 
        return view('admin.category', compact('adminuser', 'categories','todayOrders','orderCount'));
    }

    public function storeCategory(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'category' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3072', // max 3MB
        ]);

        $categoryName = $request->category;
        $slug = $request->slug;
        $status = $request->status;

        // Check if the category already exists
        $query = Category::where('category', $categoryName)->first();
        if ($query) {
            return response()->json(['status' => 'fail', 'message' => 'This category already exists', 'error' => 'category']);
        }

        // Initialize new category instance
        $category = new Category;
        $category->category = $categoryName;
        $category->slug = $slug;
        $category->status = $status;

        // Check if a thumbnail image was uploaded
        if ($request->hasFile('thumbnail_image')) {
            // Handle the image upload
            $file = $request->file('thumbnail_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('category_images', $filename, 'public'); // Save in storage/app/public/category_images

            $category->thumbnail_image = $filePath; // Store relative path
        }

        // Save the category
        $category->save();

        return response()->json(['status' => 'success', 'message' => 'Category added successfully']);
    }



    public function getCategory(Request $request)
    {
        $id = $request->dataid;
        $details = Category::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $details]);
    }

    public function modifyCategory(Request $request)
    {
        $id = $request->id;
        $categoryName = $request->category;
        $slug = $request->slug;
        $status = $request->status;

        try {
            $category = Category::findOrFail($id);
            $category->category = $categoryName;
            $category->slug = $slug;
            $category->status = $status;

            // Handle file upload if a new image is provided
            if ($request->hasFile('thumbnail_image')) {
                $file = $request->file('thumbnail_image');
                $filename = time() . '_' . $file->getClientOriginalName();

                // Store the file and get the path in the same way
                $filePath = $file->storeAs('category_images', $filename, 'public'); // Save in storage/app/public/category_images

                // Delete the old image if it exists
                if ($category->thumbnail_image && Storage::disk('public')->exists($category->thumbnail_image)) {
                    Storage::disk('public')->delete($category->thumbnail_image); // Remove the old image file
                }

                // Save new image path to the database
                $category->thumbnail_image = $filePath; // Store relative path
            }

            $category->save();

            return response()->json(['status' => 'success', 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating category data: ', ['error' => $e]);

            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to modify data. Please try again later.',
                'error' => $e->getMessage()
            ]);
        }
    }

    // SUBCATEGORY

    public function subcategory()
    {
        $adminuser = Auth::guard('admin')->user();
        $categories = Category::get();
        $subcategories = SubCategory::with('category')->get();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count(); 
        return view('admin.subcategory', compact('adminuser', 'categories', 'subcategories','todayOrders','orderCount'));
    }

    public function storesubCategory(Request $request)
    {

        $categoryName = $request->category_id;
        $subcategoryName = ucwords($request->subcategory);
        $status = $request->status;

        $query = SubCategory::where(['subcategory' => $subcategoryName])->first();
        if ($query) {
            return response()->json(['status' => 'fail', 'message' => 'This is already exists', 'error' => 'subcategory']);
        } else {
            $subcategory = new SubCategory;
            $subcategory->category_id = $categoryName;
            $subcategory->subcategory = $subcategoryName;
            $subcategory->status = $status;

            $subcategory->save();

            return response()->json(['status' => 'success', 'SubCategory Added Successfully']);
        }
    }

    public function getsubCategory(Request $request)
    {
        $id = $request->dataid;
        $details = SubCategory::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $details]);
    }

    public function modifysubCategory(Request $request)
    {
        $id = $request->id;
        $categoryName = $request->category_id;
        $status = $request->status;


        try {
            $category = SubCategory::findOrFail($id);
            $category->category_id = $categoryName;
            $category->status = $status;
            $category->save();

            return response()->json(['status' => 'success', 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating loan purpose data: ', ['error' => $e]);

            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to modify data. Please try again later.',
                'error' => $e->getMessage()
            ]);
        }
    }




    // 

    // =================================================================================================================================================================

    // BRANDS //

    public function brand()
    {
        $adminuser = Auth::guard('admin')->user();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count(); 
        $brands = Brand::get();
        return view('admin.brand', compact('adminuser', 'brands','todayOrders','orderCount'));
    }

    public function storeBrand(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'brand' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $brandName = $request->brand;
        $slug = $request->slug;
        $status = $request->status;

        $query = Brand::where('brand', $brandName)->first();
        if ($query) {
            return response()->json(['status' => 'fail', 'message' => 'This brand already exists', 'error' => 'brand']);
        }

        // Initialize new category instance
        $brand = new Brand();
        $brand->brand = $brandName;
        $brand->slug = $slug;
        $brand->status = $status;
        // Save the brand
        $brand->save();

        return response()->json(['status' => 'success', 'message' => 'Brand added successfully']);
    }



    public function getBrand(Request $request)
    {
        $id = $request->dataid;
        $details = Brand::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $details]);
    }


    public function modifyBrand(Request $request)
    {
        $id = $request->id;
        $brandName = $request->brand;
        $slug = $request->slug;
        $status = $request->status;

        try {
            $brand = Brand::findOrFail($id);
            $brand->brand = $brandName;
            $brand->slug = $slug;
            $brand->status = $status;

            $brand->save();

            return response()->json(['status' => 'success', 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating category data: ', ['error' => $e]);

            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to modify data. Please try again later.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function color()
    {
        $adminuser = Auth::guard('admin')->user();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count(); 
        $colors = ColorCode::get();
        return view('admin.color', compact('adminuser', 'colors','todayOrders','orderCount'));
    }

    public function storeColor(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $colorName = $request->name;
        $code = $request->code;
        $status = $request->status;

        $query = ColorCode::where('code', $code)->first();
        if ($query) {
            return response()->json(['status' => 'fail', 'message' => 'This brand already exists', 'error' => 'code']);
        }

        // Initialize new category instance
        $color = new ColorCode();
        $color->name = $colorName;
        $color->code = $code;
        $color->status = $status;
        $color->save();

        return response()->json(['status' => 'success', 'message' => 'Color added successfully']);
    }



    public function getColor(Request $request)
    {
        $id = $request->dataid;
        $details = ColorCode::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $details]);
    }


    public function modifyColor(Request $request)
    {
        $id = $request->id;
        $colorName = $request->name;
        $code = $request->code;
        $status = $request->status;

        try {
            $color = ColorCode::findOrFail($id);
            $color->name = $colorName;
            $color->code = $code;
            $color->status = $status;

            $color->save();

            return response()->json(['status' => 'success', 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating color data: ', ['error' => $e]);

            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to modify data. Please try again later.',
                'error' => $e->getMessage()
            ]);
        }
    }

    // start manage CMS

    public function cmspage(){
        $adminuser = Auth::guard('admin')->user();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count();
        $cmspages = CmsPage::all();
        return view('admin.cmspageList',compact('adminuser','todayOrders','orderCount','cmspages'));
    }

    public function managecms(Request $request, $id = null){
        $adminuser = Auth::guard('admin')->user();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count();  
        $cmspage =null;
        if($id){
            $cmspage = CmsPage::find($id);
        }
        return view('admin.managecms',compact('adminuser','todayOrders','orderCount','cmspage'));
    }

    public function storecms(Request $request)
{
    $id = $request->cmspage_id; 
    $rules = [
        'title'       => 'required',
        'description' => 'required',
        'url'         => 'required|string|max:255|unique:cms_pages,url' . ($id ? ",$id" : ""),
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status'  => 'fail',
            'message' => $validator->errors()->first(),
        ], 400);
    }

    try {
        // If $id is present, update the existing CMS page
        if ($id) {
            $cmsPage = CmsPage::find($id);
            if (!$cmsPage) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'CMS Page not found!',
                ], 404);
            }
            $message = 'CMS Page updated successfully!';
        } else {
            // Otherwise, create a new CMS page
            $cmsPage = new CmsPage();
            $message = 'CMS Page created successfully!';
        }

        $cmsPage->title            = $request->title;
        $cmsPage->description      = $request->description;
        $cmsPage->url              = $request->url;
        $cmsPage->meta_title       = $request->meta_title;
        $cmsPage->meta_description = $request->meta_description;
        $cmsPage->meta_keywords    = $request->meta_keywords;
        $cmsPage->status           = $request->status;
        $cmsPage->save();

        return response()->json([
            'status'  => 'success',
            'message' => $message,
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'fail',
            'message' => 'Something went wrong. Please try again.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}


    // end manage CMS


    // Start Shipping Charges

    public function shippingCharge()
    {
        $adminuser = Auth::guard('admin')->user();
        $shippingCharges = ShippingCharge::all();
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count(); 
        return view('admin.shipping_charges', compact('adminuser', 'todayOrders','orderCount','shippingCharges'));
    }

    public function storeShippingCharge(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required',
            'status' => 'required|in:Active,Inactive',
        ]);

        $shipping_name = $request->name;
        $price = $request->price;
        $status = $request->status;

        // Check if the category already exists
        $query = ShippingCharge::where('name', $shipping_name)->first();
        if ($query) {
            return response()->json(['status' => 'fail', 'message' => 'This Shipping Charge already exists', 'error' => 'name']);
        }

        // Initialize new category instance
        $shippingCharge = new ShippingCharge;
        $shippingCharge->name = $shipping_name;
        $shippingCharge->price = $price;
        $shippingCharge->status = $status;

        // Save the shippingCharge
        $shippingCharge->save();

        return response()->json(['status' => 'success', 'message' => 'Shipping Charge added successfully']);
    }



    public function getShippingCharge(Request $request)
    {
        $id = $request->dataid;
        $details = ShippingCharge::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $details]);
    }

    public function modifyShippingCharge(Request $request)
    {
        $id = $request->id;
        $shipping_name = $request->name;
        $price = $request->price;
        $status = $request->status;

        try {
            $shippingCharge = ShippingCharge::findOrFail($id);
            $shippingCharge->name = $shipping_name;
            $shippingCharge->price = $price;
            $shippingCharge->status = $status;

            $shippingCharge->save();

            return response()->json(['status' => 'success', 'message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating category data: ', ['error' => $e]);

            return response()->json([
                'status' => 'fail',
                'message' => 'Failed to modify data. Please try again later.',
                'error' => $e->getMessage()
            ]);
        }
    }

    // =================================================================================================================================================================

    // DELETE FUNCTION

    // =================================================================================================================================================================

    public function deleteEntity(Request $request)
    {
        $deleteId = $request->confirmid;
        $type = $request->type;

        switch ($type) {
            case 'category':
                $deletedata = Category::find($deleteId);
                $message = 'Category Deleted Successfully';
                break;

            case 'subcategory':
                $deletedata = SubCategory::find($deleteId);
                $message = 'Subcategory Deleted Successfully';
                break;

            case 'brand':
                $deletedata = Brand::find($deleteId);
                $message = 'Brand Deleted Successfully';
                break;
            case 'color':
                $deletedata = ColorCode::find($deleteId);
                $message = 'Color Deleted Successfully';
                break;
            case 'shipping_charges':
                $deletedata = ShippingCharge::find($deleteId);
                $message = 'Charge Deleted Successfully';
                break;  

            default:
                return response()->json(['status' => 'fail', 'message' => 'Invalid type specified']);
        }

        // dd($deletedata);
        // die();

        if ($deletedata) {
            $deletedata->delete();
            return response()->json(['status' => 'success', 'message' => $message]);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Failed to delete data']);
        }
    }
    // =================================================================================================================================================================



}