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
        // Fetch users with the 'admin' role, applying search filters if provided
        $users = User::role('admin')
            ->when($request->search, function($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                             ->orWhere('last_name', 'like', '%' . $request->search . '%');
            })
            ->latest()->paginate(4);

        // Prepare delete confirmation details
        $title = __('site.delete') . ' ' . __('site.user') . ' !';
        $text = __('site.delete_confirmation_message');
        confirmDelete($title, $text);

        // Return the index view with users
        return view('dashboard.users.index', compact('users'));
    }//end of index

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the create view for users
        return view('dashboard.users.create');
    }//end of create

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'first_name' => 'required|min:2|max:50|string',
            'last_name' => 'required|min:2|max:50|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|confirmed',
            'image' => 'mimes:jpg,jpeg,png',
            'permissions' => 'required|min:1',
        ]);

        // Prepare user data for creation
        $request_data = $request->except('password', 'password_confirmation', 'permissions', 'image');
        $request_data['password'] = bcrypt($request->password);

        // Handle user image upload
        if ($request->has('image')) {
            $file = uploadImage('users', $request->image);
            $request_data['image'] = $file;
        }

        // Create the user
        $user = User::create($request_data);
        $user->assignRole('admin'); // Assign role to the user
        $user->syncPermissions($request->permissions); // Sync permissions

        // Provide success or error feedback
        if ($user) {
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.users.index');
        } else {
            Alert::error(__('site.error'), __('site.error_found')); 
        }
    }//end of store

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the user by ID
        $user = User::all()->find($id);

        // Check if the user exists
        if (!$user) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        } else {
            // Return the edit view with user data
            return view('dashboard.users.edit', compact('user'));
        }
    }//end of edit

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);
        
        // Check if the user exists
        if (!$user) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        } else {
            // Validate incoming request data for update
            $request->validate([
                'first_name' => 'required|min:2|max:50|string',
                'last_name' => 'required|min:2|max:50|string',
                'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
                'image' => 'mimes:jpg,jpeg,png',
            ]);

            // Prepare data for updating
            $request_data = $request->except('permissions', 'image');

            // Handle user image upload
            if ($request->has('image')) {
                $file = uploadImage('users', $request->image);
                $request_data['image'] = $file;

                // Delete old photo
                $image = Str::after($user->image, 'images');
                $image = base_path('public/images' . $image);
                
                if (file_exists($image) && $image !== base_path('public/images/users/default.png')) {
                    unlink($image);
                }
                // End delete old photo
            }

            // Update the user and sync permissions
            $user->update($request_data);
            $user->hasRole('admin');
            $user->syncPermissions($request->permissions);

            // Provide success or error feedback
            if ($user) {
                Alert::success(__('site.success'), __('site.updated_successfully'));
                return redirect()->route('dashboard.users.index');
            } else {
                Alert::error(__('site.error'), __('site.error_found'));
            }
        }//end of else
    }//end of update

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);
        
        // Check if the user exists
        if (!$user) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->route('dashboard.users.index');
        } else {
            // Delete photo
            $image = Str::after($user->image, 'images');
            $image = base_path('public/images' . $image);
            if (file_exists($image) && $image !== base_path('public/images/users/default.png')) {
                unlink($image);
            }
            // End delete photo

            // Delete the user
            $user->delete();
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.users.index');
        }//end of else

    }//end of destroy
    
}//end of controller
