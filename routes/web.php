<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

//BE
use App\Http\Controllers\BE\DashboardController;
use App\Http\Controllers\BE\CategoryController;
use App\Http\Controllers\BE\BrandController;
use App\Http\Controllers\BE\ProductController;
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
    return view('welcome');
});

//Auth
Route::get('login', [AuthController::class, 'index'])->name('fe.auth.login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/authorized/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

//BE
Route::prefix('admin')
    ->middleware(['auth', 'checkAdmin'])
    ->group(function (){
//        dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
//    brands
        Route::controller(BrandController::class)->group(function (){
            Route::get('get-brands','getBrand')->name('brands.getBrands');
            Route::get('brands','index')->name('brands.index');
            Route::post('create-brand','store')->name('brands.store');
            Route::get('edit-brand/{id}','edit')->name('brands.edit');
            Route::post('update-brand/{id}','update')->name('brands.update');
            Route::get('delete-brand/{id}','destroy')->name('brands.destroy');
        });
//    products
        Route::controller(ProductController::class)->group(function (){
            Route::get('get-products','getProduct')->name('products.getProducts');
            Route::get('products','index')->name('products.index');
            Route::get('create-product','create')->name('products.create');
            Route::post('create-product','store')->name('products.store');
            Route::get('edit-product/{id}','edit')->name('products.edit');
            Route::put('update-product/{id}','update')->name('products.update');
            Route::get('delete-product/{id}','destroy')->name('products.destroy');
        });
//    categories
        Route::controller(CategoryController::class)->group(function (){
            Route::get('get-categories','getCategory')->name('categories.getCategories');
            Route::get('categories','index')->name('categories.index');
            Route::post('create-category','store')->name('categories.store');
            Route::get('edit-category/{id}','edit')->name('categories.edit');
            Route::post('update-category/{id}','update')->name('categories.update');
            Route::get('delete-category/{id}','destroy')->name('categories.destroy');
        });
    });
