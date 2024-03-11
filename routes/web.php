<?php

use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Catalog\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Catalog\CategoryGroupController;
use App\Http\Controllers\Catalog\CategoryController;
use App\Http\Controllers\ProductsController;

use App\Http\Controllers\Catalog\AttributeController;
use App\Http\Controllers\Catalog\AttributeGroupController;
use App\Http\Controllers\Sales\OrderController;
use App\Http\Controllers\VariantTypeController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
    });

 

    /// -------- catalog 

    Route::prefix('catalog')->name('catalog.')->group(function () {
        Route::resource('brands', BrandController::class);

        

    });

    



    
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
