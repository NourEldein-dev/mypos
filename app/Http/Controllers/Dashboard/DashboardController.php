<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $category_count = Category::count();
        $product_count = Product::count();
        $client_count = Client::count();
        $user_count = User::role('admin')->count();

        return view('dashboard.index' , compact('category_count' , 'product_count' , 'client_count' , 'user_count'));
    }//end of index



    public function getSalesData()
    {
        $salesData = Sales::select(DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as month'), DB::raw('SUM(amount) as total'))
                          ->groupBy('month')
                          ->orderBy('month')
                          ->pluck('total', 'month'); // Key: month, Value: total sales

        return response()->json($salesData);
    }//end of getSalesData

}//end of controller