<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request){
        $categories = Category::all();
        $products = Product::when($request->search , function($q) use ($request){

            return $q->whereTranslationLike('name' ,'%' . $request->search . '%');

        })->when($request->category_id , function($q) use ($request){
            return $q->where('category_id' , $request->category_id);

        })->latest()->paginate(4);

        $title = __('site.delete'). ' ' . __('site.product') . ' !';
        $text = __('site.delete_confirmation_message');
        confirmDelete($title, $text);

        return view('dashboard.products.index' , compact('categories' , 'products'));
    }


    public function create(){
        $categories = Category::all();

        return view('dashboard.products.create' , compact('categories'));
    }

    public function store(Request $request){
        $rules = [];
        //validation_rules
        foreach(config('translatable.locales') as $locale){
            $rules["$locale.name"] = 'required';
            $rules["$locale.description"] = 'required';
        }

        $rules['category_id'] = 'required';
        $rules['purchase_price'] = 'required';
        $rules['sale_price'] = 'required';
        $rules['stock'] = 'required';

        $validatedData = $request->validate($rules);

        $request_data = $request->all();

        if($request->has('image')){
            $file = uploadImage('products' , $request->image);
            $request_data['image'] = $file;
        }


        $product = Product::create($request_data);

        if($product){
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.products.index');
        }else{
            Alert::error(__('site.error'), __('site.error_found')); 
        }

    }


    public function edit($id){
        $categories = Category::all();
        $product = Product::find($id);

        if(!$product){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.products.index');
        }else{
            return view('dashboard.products.edit' , compact('categories' , 'product'));
        }
    }


    public function update(Request $request , $id){
        $product = Product::find($id);

        if(!$product){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.products.index');
            
        }else{

            $rules = [];
        //validation_rules
        foreach(config('translatable.locales') as $locale){
            $rules["$locale.name"] = ['required' ,
            Rule::unique('product_translations' , 'name')->ignore($product->id ,'product_id')];

            $rules["$locale.description"] = 'required';
        }

        $rules['category_id'] = 'required';
        $rules['purchase_price'] = 'required';
        $rules['sale_price'] = 'required';
        $rules['stock'] = 'required';

        $validatedData = $request->validate($rules);

        $request_data = $request->all();

        if($request->has('image')){
            $file = uploadImage('users' , $request->image);
            $request_data['image'] = $file;

            //delete old photo
        $image = Str::after($product->image , 'images');
        $image = base_path('public/images'.$image);
        unlink($image);
        //end delete old photo
        }


        $product->update($request_data);

        if($product){
            Alert::success(__('site.success'), __('site.updated_successfully'));
            return redirect()->route('dashboard.products.index');
        }else{
            Alert::error(__('site.error'), __('site.error_found')); 
        }

        }
        
    }


    public function destroy($id){

        $product = Product::find($id);
        if(!$product){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        }else{

            if($product->image != 'default.png'){
                //delete photo
            $image = Str::after($product->image , 'images');
            $image = base_path('public/images'.$image);
            if(file_exists($image))
            unlink($image);
            //end delete photo
            }

            $product->delete();
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.products.index');
        }
    }
}
