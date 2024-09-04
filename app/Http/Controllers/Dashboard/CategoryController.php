<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //index method
    public function index(Request $request){
        $categories = Category::when($request->search , function($q) use ($request){

            return $q->whereTranslationLike('name' , '%' . $request->search . '%');

        })->latest()->paginate(6);

        return view('dashboard.categories.index' , compact('categories'));
    }

    //create method
    public function create(){
        return view('dashboard.categories.create');
    }

    //store method
    public function store(Request $request){

        $rules = [];
        foreach(config('translatable.locales') as $locale){
            $rules["$locale.name"] = 'required|unique:category_translations,name';
        }
        
        $validatedData = $request->validate($rules);

        $category = Category::create($validatedData);

        if($category){
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.categories.index');
        }else{
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }
    }

    //edit method
    public function edit($id){
        $category = Category::all()->find($id);

        if(!$category){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.categories.index');
        }else{
            return view('dashboard.categories.edit' , compact('category'));
        }
    }

    //update method
    public function update(Request $request , $id){
        $category = Category::find($id);

        if(!$category){

            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.categories.index');

        }else{
            $rules = [];
            foreach(config('translatable.locales') as $locale){
                $rules["$locale.name"] = ['required' ,
                 Rule::unique('category_translations' , 'name')->ignore($category->id ,'category_id')];
            }

            $validatedData = $request->validate($rules);
            $category = $category->update($validatedData);

            if($category){
                Alert::success(__('site.success'), __('site.updated_successfully'));
                return redirect()->route('dashboard.categories.index');
            }else{
                Alert::error(__('site.error'), __('site.error_found'));
            }
        }

    }

    //destroy method
    public function destroy($id){
        $category = Category::find($id);

        if(!$category){
            Alert::error(__('site.error'), __('site.error_found'));
        }else{

            $category->delete();
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.categories.index');
        }
    }
}
