<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

    }


    public function create(){
        $clients = Client::all();

        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create' , compact('clients' , 'categories'));
    }
}
