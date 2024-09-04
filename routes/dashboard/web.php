<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\LogoutController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        //login route
        Route::get('login' , [LoginController::class , 'index'])->name('login');
        Route::post('authentication' , [LoginController::class , 'adminlogin'])->name('adminlogin');
        
        //logout route
        Route::get('logout' , [LogoutController::class , 'logout'])->name('logout');

        //start dashboard routes

        Route::middleware('auth')->prefix('dashboard')->group(function(){

            Route::get('index' , [DashboardController::class , 'index'])->name('dashboard.index');
        
            //users routes
            Route::prefix('users')->middleware(['permission:read_users'])->group(function(){
                //read users
                Route::get('index' , [UserController::class , 'index'])->name('dashboard.users.index');
                //create users
                Route::middleware(['permission:create_users'])
                ->get('create' , [UserController::class , 'create'])->name('dashboard.users.create');
                
                Route::post('store' , [UserController::class , 'store'])->name('dashboard.users.store');
                //update users
                Route::middleware(['permission:update_users'])
                ->get('edit/{id}' , [UserController::class , 'edit'])->name('dashboard.users.edit');

                Route::post('update/{id}' , [UserController::class , 'update'])->name('dashboard.users.update');
                //delete users
                Route::middleware(['permission:delete_users'])
                ->get('destroy/{id}' , [UserController::class , 'destroy'])->name('dashboard.users.destroy');

            });
            //end users routes


            //categories routes
            Route::prefix('categories')->middleware(['permission:read_categories'])->group(function(){
                //read categories
                Route::get('index' , [CategoryController::class , 'index'])->name('dashboard.categories.index');
                //create categories
                Route::middleware(['permission:create_categories'])
                ->get('create' , [CategoryController::class , 'create'])->name('dashboard.categories.create');
                
                Route::post('store' , [CategoryController::class , 'store'])->name('dashboard.categories.store');
                //update categories
                Route::middleware(['permission:update_categories'])
                ->get('edit/{id}' , [CategoryController::class , 'edit'])->name('dashboard.categories.edit');

                Route::post('update/{id}' , [CategoryController::class , 'update'])->name('dashboard.categories.update');
                //delete categories
                Route::middleware(['permission:delete_categories'])
                ->get('destroy/{id}' , [CategoryController::class , 'destroy'])->name('dashboard.categories.destroy');

            });
            //end categories routes


            //products routes
            Route::prefix('products')->middleware(['permission:read_products'])->group(function(){
                //read products
                Route::get('index' , [ProductController::class , 'index'])->name('dashboard.products.index');
                //create products
                Route::middleware(['permission:create_products'])
                ->get('create' , [ProductController::class , 'create'])->name('dashboard.products.create');
                
                Route::post('store' , [ProductController::class , 'store'])->name('dashboard.products.store');
                //update products
                Route::middleware(['permission:update_products'])
                ->get('edit/{id}' , [ProductController::class , 'edit'])->name('dashboard.products.edit');

                Route::post('update/{id}' , [ProductController::class , 'update'])->name('dashboard.products.update');
                //delete products
                Route::middleware(['permission:delete_products'])
                ->get('destroy/{id}' , [ProductController::class , 'destroy'])->name('dashboard.products.destroy');

            });
            //end products routes


            //clients routes
            Route::prefix('clients')->middleware(['permission:read_clients'])->group(function(){
                //read clients
                Route::get('index' , [ClientController::class , 'index'])->name('dashboard.clients.index');
                //create clients
                Route::middleware(['permission:create_clients'])
                ->get('create' , [ClientController::class , 'create'])->name('dashboard.clients.create');
                
                Route::post('store' , [ClientController::class , 'store'])->name('dashboard.clients.store');
                //update clients
                Route::middleware(['permission:update_clients'])
                ->get('edit/{id}' , [ClientController::class , 'edit'])->name('dashboard.clients.edit');

                Route::post('update/{id}' , [ClientController::class , 'update'])->name('dashboard.clients.update');
                //delete clients
                Route::middleware(['permission:delete_clients'])
                ->get('destroy/{id}' , [ClientController::class , 'destroy'])->name('dashboard.clients.destroy');

            });
            //end clients routes
        });

        //end dashboard routes


        
    });
