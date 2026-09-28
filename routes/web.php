<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Laravel 5.4 resolves controllers from the "App\Http\Controllers" namespace
| declared in RouteServiceProvider, so actions are given as "Class@method"
| strings rather than the [Class::class, 'method'] array syntax used by
| Laravel 8+.
|
*/

// ──────────────────────────────────────────────
// Public Routes
// ──────────────────────────────────────────────

Route::get('/', 'HomeController@index')->name('home');

Route::get('/shop', 'ShopController@index')->name('shop.index');
Route::get('/shop/category/{slug}', 'ShopController@category')->name('shop.category');
Route::get('/shop/{slug}', 'ShopController@show')->name('shop.show');

// ──────────────────────────────────────────────
// Cart Routes (no auth required)
// ──────────────────────────────────────────────

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/add', 'CartController@add')->name('cart.add');
Route::patch('/cart/{cartItem}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{cartItem}', 'CartController@remove')->name('cart.remove');

// ──────────────────────────────────────────────
// Authentication
// ──────────────────────────────────────────────

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('forgot-password', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('reset-password/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('reset-password', 'Auth\ResetPasswordController@reset')->name('password.store');

// ──────────────────────────────────────────────
// Auth-Required Routes
// ──────────────────────────────────────────────

Route::group(['middleware' => 'auth'], function () {

    // Role-aware dashboard entry point.
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    // Account profile (name / email / password / delete)
    Route::get('/profile', 'ProfileController@edit')->name('profile.edit');
    Route::patch('/profile', 'ProfileController@update')->name('profile.update');
    Route::put('/password', 'ProfileController@updatePassword')->name('password.update');
    Route::delete('/profile', 'ProfileController@destroy')->name('profile.destroy');

    // Checkout
    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
    Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
    Route::get('/checkout/confirmation/{order}', 'CheckoutController@confirmation')->name('checkout.confirmation');

    // Customer Dashboard
    Route::group(['prefix' => 'my-account'], function () {
        Route::get('/', 'CustomerDashboardController@index')->name('customer.dashboard');
        Route::get('/orders', 'CustomerDashboardController@orders')->name('customer.orders');
        Route::get('/orders/{order}', 'CustomerDashboardController@orderShow')->name('customer.orders.show');
        Route::get('/profile', 'CustomerDashboardController@profile')->name('customer.profile');
        Route::put('/profile', 'CustomerDashboardController@profileUpdate')->name('customer.profile.update');
    });
});

// ──────────────────────────────────────────────
// Admin Routes (auth + admin middleware)
// ──────────────────────────────────────────────

Route::group([
    'middleware' => ['auth', 'admin'],
    'prefix'     => 'admin',
    'namespace'  => 'Admin',
], function () {

    Route::get('/', 'DashboardController@index')->name('admin.dashboard');

    Route::resource('categories', 'CategoryController', [
        'names' => [
            'index'   => 'admin.categories.index',
            'create'  => 'admin.categories.create',
            'store'   => 'admin.categories.store',
            'show'    => 'admin.categories.show',
            'edit'    => 'admin.categories.edit',
            'update'  => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ],
    ]);

    Route::resource('products', 'ProductController', [
        'names' => [
            'index'   => 'admin.products.index',
            'create'  => 'admin.products.create',
            'store'   => 'admin.products.store',
            'show'    => 'admin.products.show',
            'edit'    => 'admin.products.edit',
            'update'  => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ],
    ]);

    // Product gallery management
    Route::post('/products/{product}/images', 'ProductController@addImages')->name('admin.products.images.add');
    Route::delete('/products/{product}/images/{image}', 'ProductController@removeImage')->name('admin.products.images.remove');

    // Orders
    Route::get('/orders', 'OrderController@index')->name('admin.orders.index');
    Route::get('/orders/{order}', 'OrderController@show')->name('admin.orders.show');
    Route::patch('/orders/{order}/status', 'OrderController@updateStatus')->name('admin.orders.update-status');

    // Customers
    Route::get('/customers', 'CustomerController@index')->name('admin.customers.index');
    Route::get('/customers/{customer}', 'CustomerController@show')->name('admin.customers.show');
});
