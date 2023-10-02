<?php

use App\Http\Controllers\BE\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//BE
use App\Http\Controllers\BE\DashboardController;
use App\Http\Controllers\BE\CategoryController;
use App\Http\Controllers\BE\BrandController;
use App\Http\Controllers\BE\ProductController;
use App\Http\Controllers\BE\UserController;
use App\Http\Controllers\BE\PermissionController;
use App\Http\Controllers\BE\RoleController;
//fe
use App\Http\Controllers\FE\HomeController;
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




//language
Route::middleware(['language'])->group(function () {
    Route::get('language/{locale}', [App\Http\Controllers\LanguageController::class, 'index'])->name('fe.language.index');
    Route::get('/', [HomeController::class, 'index'])->name('fe.home.index');

    //Auth
    Route::get('login', [AuthController::class, 'index'])->name('fe.auth.login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::get('/auth/facebook/redirect', [AuthController::class, 'redirectToFacebook'])->name('facebook.redirect');
    Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback'])->name('facebook.callback');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('fe.auth.register');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register');
    Route::get('/privacy_policy',function (){
        return 'privacy_policy';
    });
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
//FE
    Route::get('/danh-muc/{slug}', [App\Http\Controllers\FE\CategoryController::class, 'getProductBySlug'])->name('fe.category.getProductBySlug');
    Route::get('thuong-hieu/{slug}', [App\Http\Controllers\FE\BrandController::class, 'getProductBySlug'])->name('fe.brand.getProductBySlug');
    Route::get('san-pham/{slug}', [App\Http\Controllers\FE\ProductController::class, 'show'])->name('fe.product.show');
    Route::get('san-pham', [App\Http\Controllers\FE\ProductController::class, 'index'])->name('fe.product.index');


//comment
    Route::post('add-comment', [App\Http\Controllers\FE\ProductController::class, 'storeComment'])->name('fe.comment.store');
    Route::get('get-comments/{id}', [App\Http\Controllers\FE\ProductController::class, 'getComments'])->name('fe.comment.getComments');
//search
    Route::get('search', [App\Http\Controllers\FE\ProductController::class, 'search'])->name('fe.search.index');

    Route::post('/add-cart', [App\Http\Controllers\FE\CartController::class, 'saveCartSession'])->name('client.cart.add');
    Route::get('/get-cart', [App\Http\Controllers\FE\CartController::class, 'getCartSession'])->name('client.cart.getCartSession');
    Route::get('/delete-cart/{key}', [App\Http\Controllers\FE\CartController::class, 'delCartbyKey'])->name('client.cart.deleteCartSession');
    Route::get('/update-cart', [App\Http\Controllers\FE\CartController::class, 'update'])->name('client.cart.updateCartSession');
    Route::get('/cart', [App\Http\Controllers\FE\CartController::class, 'index'])->name('client.cart.index');
//checkout
    Route::get('/checkout', [App\Http\Controllers\FE\OrderController::class, 'index'])->name('client.order.index');
    Route::post('/checkout', [App\Http\Controllers\FE\OrderController::class, 'store'])->name('client.order.store');
    Route::post('/payment', [App\Http\Controllers\FE\OrderController::class, 'payment'])->name('client.order.payment');
    Route::get('/checkout-payment', [App\Http\Controllers\FE\OrderController::class, 'checkoutPayment'])->name('client.order.checkoutPayment');
});


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
//    orders
        Route::controller(OrderController::class)->group(function (){
            Route::get('orders','index')->name('orders.index');
            Route::get('order/{id}','show')->name('orders.show');
            Route::get('print/{id}','print')->name('orders.printOrder');
            Route::put('update-order/{id}','update')->name('orders.update');
            Route::put('accept-order/{id}','accept')->name('orders.accept');
            Route::get('create-order','create')->name('orders.create');
            Route::post('create-order','store')->name('orders.store');
        });
        //    users
        Route::resource('users', UserController::class);
        //   roles
        Route::controller(RoleController::class)->group(function (){
            Route::get('get-roles',[RoleController::class, 'getRole'])->name('roles.getRoles');
            Route::get('roles','index')->name('roles.index');
            Route::post('create-role','store')->name('roles.store');
            Route::get('edit-role/{id}','edit')->name('roles.edit');
            Route::post('update-role/{id}','update')->name('roles.update');
            Route::get('delete-role/{id}','destroy')->name('roles.destroy');
        });

        //   permissions
        Route::resource('permissions', PermissionController::class);
    });
