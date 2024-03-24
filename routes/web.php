<?php

use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Catalog\BrandController;
use App\Http\Controllers\Catalog\CategoryController;
use App\Http\Controllers\Catalog\ProductController;
use App\Http\Controllers\Catalog\VariantTypeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\HomeImagesController;
use App\Http\Controllers\Home\AboutUsController;


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
        Route::resource('categories', CategoryController::class);
        Route::resource('variant-types', VariantTypeController::class);

// Display a listing of the product.
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Show the form for creating a new product.
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Store a newly created product in storage.
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Display the specified product.
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Show the form for editing the specified product.
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Update the specified product in storage.
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Remove the specified product from storage.
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
    Route::prefix('home')->name('home.')->group(function () {
        Route::resource('home-images', HomeImagesController::class);

        Route::get('/about-us', [AboutUsController::class, 'index'])->name('about-us.index');

// Show the form for creating a new resource.
        Route::get('/about-us/create', [AboutUsController::class, 'create'])->name('about-us.create');

// Store a newly created resource in storage.
        Route::post('/about-us', [AboutUsController::class, 'store'])->name('about-us.store');

// Show the form for editing the specified resource.
        Route::get('/about-us/{aboutUs}/edit', [AboutUsController::class, 'edit'])->name('about-us.edit');

// Update the specified resource in storage.
        Route::put('/about-us/{aboutUs}', [AboutUsController::class, 'update'])->name('about-us.update');

// Remove the specified resource from storage.
        Route::delete('/about-us/{aboutUs}', [AboutUsController::class, 'destroy'])->name('about-us.destroy');
    });





    
});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
