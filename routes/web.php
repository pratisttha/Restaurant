<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('login');
});

//User
Route::controller(UserController::class)->group(function () {
    Route::get('/users/register', 'create');
    Route::get('/users', 'index');
    Route::post('/users/store', 'store');
    Route::get('/users/{user}/edit', 'edit');
    Route::put('/users/{user}', 'update');
    Route::delete('/users/{user}', 'destroy');
    Route::get('/users/login', 'login');
    Route::post('/logout', 'logout' );
    Route::post('/users/authenticate', 'authenticate');
});

//Inventory
Route::controller(InventoryController::class)->group(function () {
    Route::get('/inventory','index');
    Route::post('/category/store','category_store');
    Route::get('/inventory/category/add','categories');
    Route::get('/inventory/categories/{category}/edit','category_edit');
    Route::put('/category/{category}','category_update');
    Route::post('/item/store','store');
    Route::get('/inventory/items/{item}/edit','item_edit');
    Route::delete('/items/{item}/delete','item_delete');
    Route::put('/item/{item}','item_update');
    Route::get('/inventory/item/add','item');
});


//Kitchen 
Route::controller(KitchenController::class)->group(function () {
    Route::get('/kitchen','index');
});

//Tables
Route::controller(TableController::class)->group(function () {
    Route::get('/tables','view');
    Route::get('/tables/add','show');
    Route::post('/tables/store','store');
    Route::get('/tables/{table}','reserve');
    Route::post('/tables/{table}/reserve','reserve_update');
});

//orders 
Route::controller(OrderController::class)->group(function () {
    Route::get('/orders','view');
    Route::get('/orders/add','show');
    Route::post('/orders/store','store');
    Route::get('/orders/{order}/additems','additems');
 
});

//Order Bill
Route::controller(InvoiceController::class)->group(function(){
    Route::get('/invoices','index');
    Route::get('/invoices/{order}','show');
});
