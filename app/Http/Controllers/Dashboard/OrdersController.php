<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OrdersController extends Controller
{
    // Display a listing of the orders
    public function index(Request $request) {
        // Fetch orders with client name matching the search query
        $orders = Order::whereHas('client', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);

        // Confirmation delete from SweetAlert
        $title = __('site.delete') . ' ' . __('site.order') . ' !';
        $text = __('site.delete_confirmation_message');
        confirmDelete($title, $text);

        return view('dashboard.orders.index', compact('orders'));
    } // end of index

    // Fetch products related to a specific order
    public function products(Order $order) {
        $products = $order->products()->get(); // Fetch products related to the order
        return response()->json($products); // Return products as JSON
    } // end of products

    // Remove the specified order and update product stock
    public function destroy(Order $order) {
        // Update the stock of each product related to the order
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        // Delete the order and show success alert
        $order->delete();
        Alert::success(__('site.success'), __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    } // end of destroy
    
} // end of controller
