<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CategoriesController;
use App\Http\Controllers\API\V1\ProductsController;
use App\Http\Controllers\API\V1\RatingsController;
use App\Http\Controllers\RegisterController;

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
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('/categories',CategoriesController::class);
    Route::resource('/products',ProductsController::class);
    Route::resource('/ratings',RatingsController::class);
    
    Route::post('/categories/update/{category:id}',[CategoriesController::class,'update']);
    Route::post('/products/update/{product:id}',[ProductsController::class,'update']);

    Route::get('categories/{category:id}/products', [CategoriesController::class, 'products']);
});