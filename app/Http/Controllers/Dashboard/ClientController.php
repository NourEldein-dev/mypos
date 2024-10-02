<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    // Display a listing of clients
    public function index(Request $request) {
        $clients = Client::when($request->search, function($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('mobile', 'like', '%' . $request->search . '%')
                ->orWhere('address', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);

        $title = __('site.delete') . ' ' . __('site.client') . ' !';
        $text = __('site.delete_confirmation_message');
        confirmDelete($title, $text);

        return view('dashboard.clients.index', compact('clients'));
    } // end of index

    // Show the form for creating a new client
    public function create() {
        return view('dashboard.clients.create');
    } // end of create

    // Store a newly created client in storage
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|unique:clients,mobile|regex:/(01)[0-9]{9}/|digits:11',
            'second_mobile' => 'nullable|numeric|unique:clients,second_mobile|regex:/(01)[0-9]{9}/|digits:11',
            'address' => 'required',
        ]);

        $clients = Client::create($request->all());

        if ($clients) {
            Alert::success(__('site.success'), __('site.added_successfully'));
            return redirect()->route('dashboard.clients.index');
        } else {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        }
    } // end of store

    // Show the form for editing the specified client
    public function edit($id) {
        $client = Client::find($id);

        if (!$client) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        } else {
            return view('dashboard.clients.edit', compact('client'));
        }
    } // end of edit

    // Update the specified client in storage
    public function update(Request $request, $id) {
        $client = Client::find($id);

        if (!$client) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        } else {
            $request->validate([
                'name' => 'required',
                'mobile' => 'required|numeric|regex:/(01)[0-9]{9}/|digits:11|unique:clients,mobile,' . $client->id,
                'second_mobile' => 'nullable|regex:/(01)[0-9]{9}/|digits:11|numeric|unique:clients,second_mobile,' . $client->id,
                'address' => 'required',
            ]);

            $client->update($request->all());

            if ($client) {
                Alert::success(__('site.success'), __('site.updated_successfully'));
            }
            return redirect()->route('dashboard.clients.index');
        } // end of else
    } // end of update

    // Remove the specified client from storage
    public function destroy($id) {
        $client = Client::find($id);

        if (!$client) {
            Alert::error(__('site.error'), __('site.error_found'));
            return redirect()->back();
        } else {
            $client->delete();

            if ($client) {
                Alert::success(__('site.success'), __('site.deleted_successfully'));
            }
            return redirect()->route('dashboard.clients.index');
        } // end of else
    } // end of destroy
} // end of controller
