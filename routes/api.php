<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailOrderController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();

    });
});

//laundry
Route::get('/get-laundry', [LaundryController::class,'index']);
Route::get('/get-laundry/show/{user_id}', [LaundryController::class,'show']);

//order
Route::get('/get-order', [OrderController::class, 'index']);
Route::get('/get-order/show/{user_id}', [OrderController::class, 'show']);
Route::post('/add-order', [OrderController::class, 'store']);
Route::post('/update-order', [OrderController::class, 'update']);
Route::post('/update-status', [OrderController::class, 'ubahStatus']);

//items
Route::get('/get-items', [ItemsController::class, 'index']);
Route::post('/add-items', [ItemsController::class, 'store']);
Route::post('/update-items', [ItemsController::class, 'update']);
Route::get('/get-items/show/{laundry_id}', [ItemsController::class, 'show']);


//detail order
Route::get('/get-detail', [DetailOrderController::class, 'index']);
Route::get('/get-detail/show/{order_id}', [DetailOrderController::class, 'index']);
Route::post('/add-detail', [DetailOrderController::class, 'store']);
Route::post('/update-detail', [DetailOrderController::class, 'update']);



Route::get('/get-orderDate', [OrderController::class, 'getByDate']);
Route::get('/get-orderStatus', [OrderController::class, 'getByStatus']);
Route::get('/get-orderHistory', [OrderController::class, 'getHistoryOrder']);

Route::group(['middleware' => ['auth:sanctum', 'mitra']], function() {
    Route::post('/add-laundry', [LaundryController::class,'store']);
    // Route::get('/get-laundry', [LaundryController::class,'index']);
});
