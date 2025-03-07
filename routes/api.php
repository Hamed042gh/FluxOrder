<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/orders',[OrderController::class,'orders']);
    Route::get('/order/{id}',[OrderController::class,'showOrder']);
    Route::post('/orders',[OrderController::class, 'storeOrder']);
    Route::put('/order/{id}',[OrderController::class, 'updateOrder']);
    Route::delete('/order/{id}',[OrderController::class,'destroyOrder']);
});

