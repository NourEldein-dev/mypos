<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Display a listing of products with optional search and filter by category
    public function index(Request $request) {
        $categories = Category::all();

        // Fetch products based on search query and selected category
        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(4);

        // Confirmation delete from SweetAlert
        $title = __('site.delete') . ' ' . __('site.product') . ' !';
        $text = __('site.delete_confirmation_message');
        confirmDelete($title, $text);

        return view('dashboard.products.index', compact('categories', 'products'));
    } // end of index

    // Show the form for creating a new product
    public function create() {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    } // end of create

    // Store a newly created product in storage
    public function store(Request $request) {
        $rules = [];

        // Validation rules for product creation
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required';
            $rules["$locale.description"] = 'required';
        }

        $rules['category_id'] = 'required';
        $rules['purchase_price'] = 'required';
        $rules['sale_price'] = 'required';
        $rules['stock'] = 'required';

        // Validate the request data
        $validatedData = $request->validate($rules);
        $request_data = $request->all();

        // Handle image upload
        if ($request->has('image')) {
            $file = uploadImage('products', $request->image);
            $request_data['image'] = $file;
        }

        // Create the product
        $product = Product::create($request_data);

        if ($product) {
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.products.index');
        } else {
            Alert::error(__('site.error'), __('site.error_found'));
        }
    } // end of store

    // Show the form for editing the specified product
    public function edit($id) {
        $categories = Category::all();
        $product = Product::find($id);

        if (!$product) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.products.index');
        } else {
            return view('dashboard.products.edit', compact('categories', 'product'));
        }
    } // end of edit

    // Update the specified product in storage
    public function update(Request $request, $id) {
        $product = Product::find($id);

        if (!$product) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.products.index');
        } else {
            $rules = [];

            // Validation rules for product update
            foreach (config('translatable.locales') as $locale) {
                $rules["$locale.name"] = ['required'];
                $rules["$locale.description"] = 'required';
            }

            $rules['category_id'] = 'required';
            $rules['purchase_price'] = 'required';
            $rules['sale_price'] = 'required';
            $rules['stock'] = 'required';

            // Validate the request data
            $validatedData = $request->validate($rules);
            $request_data = $request->all();

            // Handle image upload
            if ($request->has('image')) {
                $file = uploadImage('products', $request->image);
                $request_data['image'] = $file;

                // Delete old photo
                $image = Str::after($product->image, 'images');
                $image = base_path('public/images' . $image);
                if ($image !== base_path('public/images/products/default.jpg')) {
                    unlink($image);
                }
                // End delete old photo
            }

            // Update the product
            $product->update($request_data);

            if ($product) {
                Alert::success(__('site.success'), __('site.updated_successfully'));
                return redirect()->route('dashboard.products.index');
            } else {
                Alert::error(__('site.error'), __('site.error_found'));
            }
        } // end of else
        
    } // end of update

    // Remove the specified product from storage
    public function destroy($id) {
        $product = Product::find($id);
        
        if (!$product) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        } else {
            // Delete photo
            $image = Str::after($product->image, 'images');
            $image = base_path('public/images' . $image);
            if (file_exists($image)) {
                if ($image !== base_path('public/images/products/default.jpg')) {
                    unlink($image);
                }
            }
            // End delete photo
            
            // Delete the product
            $product->delete();
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.products.index');
        } // end of else

    } // end of destroy

} // end of controller
