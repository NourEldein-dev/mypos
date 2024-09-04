<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    public function index(Request $request){
        $clients = Client::when($request->search , function($q) use ($request) {

            return $q->where('name' , 'like' , '%' . $request->search . '%')
            ->orWhere('mobile' , 'like' , '%' . $request->search . '%')
            ->orWhere('address' , 'like' , '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('dashboard.clients.index' , compact('clients'));
    }


    public function create(){
        return view('dashboard.clients.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|unique:clients,mobile',
            'second_mobile' => 'nullable|numeric|unique:clients,second_mobile',
            'address' => 'required',
        ]);

        $clients = Client::create($request->all());

        if($clients){
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.clients.index');
        }else{
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }
    }


    public function edit($id){
        $client = Client::find($id);

        if(!$client){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }else{
            return view('dashboard.clients.edit' , compact('client'));
        }
    }

    public function update(Request $request , $id){
        $client = Client::find($id);

        if(!$client){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }else{
            
            $request->validate([
                'name' => 'required',
                'mobile' => 'required|numeric|unique:clients,mobile,' . $client->id ,
                'second_mobile' => 'nullable|numeric|unique:clients,second_mobile,' . $client->id ,
                'address' => 'required',
            ]);

            $client->update($request->all());

            if($client)
            Alert::success(__('site.success'), __('site.updated_successfully'));
            return redirect()->route('dashboard.clients.index');
            
        }
    }


    public function destroy($id){
        $client = Client::find($id);

        if(!$client){
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }else{
            
            $client->delete();

            if($client)
            Alert::success(__('site.success'), __('site.deleted_successfully'));
            return redirect()->route('dashboard.clients.index');
        }
    }
}
