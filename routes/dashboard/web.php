<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\LogoutController;
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
        
            //user routes
            Route::prefix('users')->middleware(['permission:read_users'])->group(function(){
                //read users
                Route::get('index' , [UserController::class , 'index'])->name('dashboard.users.index');
                //create users
                Route::middleware(['permission:create_users'])
                ->get('create' , [UserController::class , 'create'])->name('dashboard.users.create');
                
                Route::post('store' , [UserController::class , 'store'])->name('dashboard.users.store');
                //update users
                Route::middleware(['permission:update_users'])
                ->get('edit/{user}' , [UserController::class , 'edit'])->name('dashboard.users.edit');

                Route::post('update/{user}' , [UserController::class , 'update'])->name('dashboard.users.update');
                //delete users
                Route::middleware(['permission:delete_users'])
                ->get('destroy/{id}' , [UserController::class , 'destroy'])->name('dashboard.users.destroy');

            });
            //end user routes
        });

        //end dashboard routes


        
    });
