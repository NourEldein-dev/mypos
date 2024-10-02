<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    // Display a listing of categories
    public function index(Request $request) {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->latest()->paginate(6);

        $title = __('site.delete') . ' ' . __('site.category') . ' !';
        $text = __('site.delete_confirmation_message');
        confirmDelete($title, $text);

        return view('dashboard.categories.index', compact('categories'));
    } // end of index

    // Show the form for creating a new category
    public function create() {
        return view('dashboard.categories.create');
    } // end of create

    // Store a newly created category in storage
    public function store(Request $request) {
        $rules = [];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|unique:category_translations,name';
        }
        
        $validatedData = $request->validate($rules);

        $category = Category::create($validatedData);

        if ($category) {
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.categories.index');
        } else {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }
    } // end of store

    // Show the form for editing the specified category
    public function edit($id) {
        $category = Category::all()->find($id);

        if (!$category) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.categories.index');
        } else {
            return view('dashboard.categories.edit', compact('category'));
        }
    } // end of edit

    // Update the specified category in storage
    public function update(Request $request, $id) {
        $category = Category::find($id);

        if (!$category) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.categories.index');
        } else {
            $rules = [];
            foreach (config('translatable.locales') as $locale) {
                $rules["$locale.name"] = [
                    'required',
                    Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')
                ];
            }

            $validatedData = $request->validate($rules);
            $categoryUpdated = $category->update($validatedData);

            if ($categoryUpdated) {
                Alert::success(__('site.success'), __('site.updated_successfully'));
                return redirect()->route('dashboard.categories.index');
            } else {
                Alert::error(__('site.error'), __('site.error_found'));
            }
        } // end of else
    } // end of update

    // Remove the specified category from storage
    public function destroy($id) {
        $category = Category::find($id);

        if (!$category) {
            Alert::error(__('site.error'), __('site.error_found'));
        } else {
            $category->delete();
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.categories.index');
        } // end of else
        
    } // end of destroy

} // end of controller
