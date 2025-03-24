<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{
    public function customers(Request $request){
        $todayOrders = Orders::whereDate('created_at', today())->with('orderItems.product')->get();
        $orderCount = $todayOrders->count(); 
        $adminuser = Auth::guard('admin')->user();
        $customerList = User::where('role',3)->count();
        $newCustomerCount = User::whereDate('created_at', today())->count();
        $query = User::where('role', 3)
        ->withCount('orders') 
        ->withSum('orders', 'total_amount') 
        ->with(['orders' => function ($query) {
            $query->latest()->limit(1); 
        }]);

        if($request->has('search')){
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('name','LIKE',"%{$search}%")
                ->orWhere('email','LIKE',"%{$search}%");
            });
        }

        $customers = $query->get();        

        foreach ($customers as $customer) {
            $latestOrder = $customer->orders->first(); // Get latest order
            if ($latestOrder && $latestOrder->address) {
                $address = json_decode($latestOrder->address, true);
                $customer->state = $address['state'] ?? 'N/A';
                $customer->country = $address['country'] ?? 'N/A';
                $customer->last_order_date = $latestOrder->created_at->format('Y-m-d H:i:s');
            } else {
                $customer->state = 'N/A';
                $customer->country = 'N/A';
                $customer->last_order_date = 'N/A';

            }
            $customer->last_seen = $customer->updated_at ? $customer->updated_at->diffForHumans() : 'N/A';

        }

        if($request->ajax()){
            return response()->json(['customers'=>$customers]);
        }

        return view('admin.customers',compact('todayOrders','orderCount','adminuser','customerList','newCustomerCount','customers'));
    }
}
