<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ShopController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products',   AdminProductController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('orders',     AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('users',      UserController::class);
});

// Public Shop Routes
Route::get('/',                        [ShopController::class, 'home'])->name('user.home');
Route::get('/shop',                    [ShopController::class, 'index'])->name('user.shop');
Route::get('/shop/{product:slug}',     [ShopController::class, 'show'])->name('user.products.show');

// Auth Required Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [OrderController::class, 'profile'])->name('user.profile');

    // Cart
    Route::get('/cart',                [CartController::class, 'index'])->name('user.cart');
    Route::post('/cart/{product}',     [CartController::class, 'add'])->name('user.cart.add');
    Route::patch('/cart/{cartItem}',   [CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/{cartItem}',  [CartController::class, 'remove'])->name('user.cart.remove');
    Route::delete('/cart',             [CartController::class, 'clear'])->name('user.cart.clear');

    // Orders
    Route::get('/checkout',            [OrderController::class, 'checkout'])->name('user.checkout');
    Route::post('/orders',             [OrderController::class, 'store'])->name('user.orders.store');
    Route::get('/orders',              [OrderController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{order}',      [OrderController::class, 'show'])->name('user.orders.show');
});
