<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SubItemController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/items', [ItemController::class, 'index']);
Route::prefix('/item')->group(function(){
    Route::post('/store',[ItemController::class, 'store']);
    Route::put('/{id}' , [ItemController::class, 'update']);
    Route::delete('/{id}', [ItemController::class, 'destroy'] );
    Route::put('/all/{id}', [ItemController::class, 'updateAll']);
});

Route::get('/sub_item/{id}', [SubItemController::class, 'index']);
Route::prefix('/sub_item')->group(function(){
    Route::post('/store',[SubItemController::class, 'store']);
    Route::put('/{id}' , [SubItemController::class, 'update']);
    Route::delete('/{id}', [SubItemController::class, 'destroy'] );
});