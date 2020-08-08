<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });


// Home Page
Route::get('/', 'IndexController@index');

Route::match(['get', 'post'], '/admin', 'AdminController@login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Category / Listing Page
Route::get('/products/{url}', 'ProductsController@products');

// Product Detail Page
Route::get('/product/{id}', 'ProductsController@product');

// get product Attribute price
Route::get('/get-product-price', 'ProductsController@getProductPrice');

Route::group(['middleware' => ['auth']], function(){
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/settings', 'AdminController@settings');
    Route::get('/admin/check-pwd', 'AdminController@chkPassword');
    Route::match(['get', 'post'],'/admin/update-pwd', 'AdminController@updatePassword');

    // Categories Routes (Admin)
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories');
    
    // Products Routes (Admin)
    Route::match(['get', 'post'],'/admin/add-product', 'ProductsController@addProduct');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductsController@editProduct');
    Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct');
    Route::get('/admin/view-products', 'ProductsController@viewProducts');
    Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage');
    
    //  Products Attribute (Admin)
    Route::match(['get', 'post'],'/admin/add-attributes/{id}', 'ProductsController@addAttributes');
    Route::match(['get', 'post'],'/admin/edit-attributes/{id}', 'ProductsController@editAttributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute');

    // Product Alternate Images (Admin)
    Route::match(['get', 'post'],'/admin/add-images/{id}', 'ProductsController@addImages');
    Route::get('/admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage');
});

Route::get('/logout', 'AdminController@logout');
