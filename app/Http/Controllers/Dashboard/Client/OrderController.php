<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new order for a client.
     */
    public function create(Client $client)
    {
        // Fetch categories with their associated products
        $categories = Category::with('products')->get();

        // Fetch orders for the client with associated products, paginated
        $orders = $client->orders()->with('products')->paginate(5);

        // Return the create order view with necessary data
        return view('dashboard.clients.orders.create', compact('client', 'categories', 'orders'));
    }//end of create

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request, Client $client)
    {
        // Validate incoming request data
        $request->validate([
            'products' => 'required|array',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Create a new order for the client
        $order = $client->orders()->create([]);

        // Attach products to the order
        $order->products()->attach($request->products);
        
        $total_price = 0;

        // Calculate total price and update product stocks
        foreach ($request->products as $id => $quantity) {
            $product = Product::find($id);
            $total_price += $product->sale_price * $quantity['quantity'];

            // Update product stock
            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);
        }

        // Update order with the total price
        $order->update([
            'total_price' => $total_price
        ]);

        // Provide success or error feedback
        if ($order) {
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.orders.index');
        } else {
            Alert::error(__('site.error'), __('site.error_found')); 
        }
    }//end of store

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Client $client, Order $order)
    {
        // Fetch categories with their associated products
        $categories = Category::with('products')->get();

        // Return the edit order view with necessary data
        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories'));
    }//end of edit

    /**
     * Get the products associated with a specific order.
     */
    public function getOrderProducts(Order $order)
    {
        // Fetch products associated with the order
        $products = $order->products()->get();

        // Map products to include their quantity from the pivot table
        $products = $products->map(function ($product) {
            $product->quantity = $product->pivot->quantity;
            return $product;
        });

        // Return products as JSON response
        return response()->json($products);
    }//end of getOrderProducts

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        // Find the order by ID
        $order = $order->find($order->id);
        
        // Check if the order exists
        if (!$order) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        } else {
            // Validate incoming request data for update
            $request->validate([
                'products' => 'required|array',
            ]);

            // Fetch the original products and their quantities
            $originalProducts = $order->products()->get();

            // Detach all products from the order
            $order->products()->detach();

            $total_price = 0;

            // Reattach products with updated quantities
            foreach ($request->products as $id => $quantity) {
                $product = Product::find($id);
                $total_price += $product->sale_price * $quantity['quantity'];

                // Calculate stock adjustment
                $originalQuantity = $originalProducts->find($id)->pivot->quantity ?? 0;
                $stockEdit = $originalQuantity - $quantity['quantity'];

                // Update product stock
                $product->update([
                    'stock' => $product->stock + $stockEdit
                ]);

                // Attach product with the new quantity
                $order->products()->attach($id, ['quantity' => $quantity['quantity']]);
            }//end of foreach

            // Update order with new total price
            $order->update([
                'total_price' => $total_price
            ]);

            // Provide success or error feedback
            if ($order) {
                Alert::success(__('site.success'), __('site.updated_successfully'));
                return redirect()->route('dashboard.orders.index');
            } else {
                Alert::error(__('site.error'), __('site.error_found'));
            }
        }//end of else

    }//end of update
    
}//end of controller
