<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::role('admin')
        ->when($request->search , function($query) use ($request){
            return $query->where('first_name' , 'like' , '%' . $request->search . '%')
            ->orWhere('last_name' , 'like' , '%' . $request->search . '%');
        })->latest()->paginate(4);

        // $users = User::role('admin')->get();

        return view('dashboard.users.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:2|max:50|string',
            'last_name' => 'required|min:2|max:50|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png',
            'permissions' => 'required|min:1',
        ]);

        $request_data = $request->except('password' , 'password_confirmation' , 'permissions' , 'image');
        $request_data['password'] = bcrypt($request->password);

        if($request->has('image')){
            $file = uploadImage('users' , $request->image);
            $request_data['image'] = $file;
        }


        $user = User::create($request_data);

        $user->assignRole('admin');
        $role = Role::findByName('admin');
        $role->syncPermissions($request->permissions);

        if($user){
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.users.index');
        }else{
            Alert::error(__('site.error'), __('site.error_found')); 
        }

       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::all()->find($id);

        if(!$user){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        }else{
            return view('dashboard.users.edit' , compact('user'));
        }
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , $id)
    {
        $user = User::find($id);
        if(!$user){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        }else{

            $request->validate([
                'first_name' => 'required|min:2|max:50|string',
                'last_name' => 'required|min:2|max:50|string',
                'email' => 'required|email:rfc,dns|unique:users,email,'. $user->id,
                'image' => 'mimes:jpg,jpeg,png',
            ]);
    
            $request_data = $request->except('permissions' , 'image');

            if($request->has('image')){
                $file = uploadImage('users' , $request->image);
                $request_data['image'] = $file;

                //delete old photo
            $image = Str::after($user->image , 'images');
            $image = base_path('public/images'.$image);
            unlink($image);
            //end delete old photo
            }

            $user->update($request_data);
    
            $user->syncPermissions($request->permissions);
            
    
            if($user){
                Alert::success(__('site.success'), __('site.updated_successfully'));
                return redirect()->route('dashboard.users.index');
            }else{
                Alert::error(__('site.error'), __('site.error_found'));
            }
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        }else{

            if($user->image != 'default.png'){
                //delete photo
            $image = Str::after($user->image , 'images');
            $image = base_path('public/images'.$image);
            if(file_exists($image))
            unlink($image);
            //end delete photo
            }

            $user->delete();
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.users.index');
        }
    }
}
