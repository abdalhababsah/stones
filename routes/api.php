<?php

use App\Actions\SamplePermissionApi;
use App\Actions\SampleRoleApi;
use App\Actions\SampleUserApi;
use App\Models\Cdr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductsApiController;
use App\Http\Controllers\Api\HomeImagesApiController;
use App\Http\Controllers\Api\ContactUsApiController;


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
Route::post('/contact-us', [ContactUsApiController::class, 'store']);

Route::get('/home-images', [HomeImagesApiController::class, 'index']);

Route::get('/products', [ProductsApiController::class, 'index'])->name('products.index');

// Route to get a specific product by ID in either English or Arabic
Route::get('/products/{id}', [ProductsApiController::class, 'show'])->name('products.show');

