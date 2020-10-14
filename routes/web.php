<?php

use App\Http\Controllers\UsersController;
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


Route::match(['get', 'post'], '/admin', 'AdminController@login');



// Index Page
Route::get('/', 'IndexController@index')->name('index')  ;

// Category / Listing Page
Route::get('/products/{url}', 'ProductsController@products');

// Product Detail Page
Route::get('/product/{id}', 'ProductsController@product');

// Add to Cart Route
Route::match(['get', 'post'], '/add-cart', 'ProductsController@addtocart');

// Cart Page
Route::match(['get', 'post'], '/cart', 'ProductsController@cart');

// Delete Product from Cart Page
Route::get('/cart/delete-product/{id}', 'ProductsController@deleteCartProduct');

// Update Product Quantity in Cart
Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductsController@updateCartQuantity');

// get product Attribute price
Route::get('/get-product-price', 'ProductsController@getProductPrice');

// Apply Coupon
Route::post('cart/apply-coupon', 'ProductsController@applyCoupon');

// Users Login/Register Page
Route::get('/login-register','UsersController@userLoginRegister');

// Forgot password
Route::match(['get','post'], 'forgot-password','UsersController@forgotPassword');

// Users Register Form Submit
Route::post('/user-register','UsersController@register');

// Confirm Account
Route::get('confirm/{code}','UsersController@confirmAccount');

// Users Logout
Route::get('/user-logout', 'UsersController@logout');

// Search Products
Route::match(['get', 'post'],'/search-product', 'ProductsController@searchProducts');

// Users Login
Route::post('/user-login', 'UsersController@login');


// All Routes after login
Route::group(['middleware' => ['frontlogin']],function(){
    // Users Account
    Route::match(['get','post'],'/account','UsersController@account');

    // Check User Current Password
    Route::post('/check-user-pwd', 'UsersController@chkUserPassword');

    // Update User Password
    Route::post('/update-user-pwd','UsersController@updatePassword');

    // Checkout Page
    Route::match(['get','post'],'/checkout','ProductsController@checkout');

    // Order review Page
    Route::match(['get','post'],'/order-review','ProductsController@orderReview');

    // Place Order Page
    Route::match(['get','post'],'/place-order','ProductsController@placeOrder');

    // Payment Page
    Route::get('/paiement','ProductsController@payment');

    // Checkout Payment Page
    Route::post('/paiement','ProductsController@checkoutPayment')->name('stripe.payment');

    // Thanks Page
    Route::get('/thanks','ProductsController@thanks');

    // Paypal Page
    // Route::get('/paypal','ProductsController@paypal');

    // Users Orders Page
    Route::get('/orders','ProductsController@userOrders');
    // User order Products details page
    Route::get('/orders/{id}','ProductsController@userOrdersDetails');

    // Paypal Thanks
    // Route::get('/paypal/thanks','ProductsController@thanksPaypal');

    // Paypal Cancel Page
    // Route::get('/paypal/cancel','ProductsController@cancelPaypal');



});

// Check if user already exists
Route::match([ 'get','post'],'/check-email', 'UsersController@checkEmail');


Route::group(['middleware' => ['adminlogin']], function(){
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
    
    // Coupon Routes
    Route::match([ 'get','post'],'/admin/add-coupon', 'CouponsController@addCoupon');
    Route::match(['get', 'post'],'/admin/edit-coupon/{id}', 'CouponsController@editCoupon');
    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');
    Route::get('admin/view-coupons', 'CouponsController@viewCoupons');

    // Admin Banners Routes
    Route::match(['get','post'],'/admin/add-banner', 'BannersController@addBanner');
    Route::match(['get','post'], '/admin/edit-banner/{id}', 'BannersController@editBanners');
    Route::get('/admin/view-banners','BannersController@viewBanners');
    Route::get('/admin/delete-banner/{id}', 'BannersController@deleteBanner');

    // Admin Orders Routes
    Route::get('/admin/view-orders', 'ProductsController@viewOrders');
 
    // Admin Order Details Route
    Route::get('/admin/view-orders/{id}', 'ProductsController@viewOrdersDetails');
    
    // Admin Order Invoice Route
    Route::get('/admin/view-orders-invoice/{id}', 'ProductsController@viewOrdersInvoice');

    // Upadate the order status
    Route::post('/admin/update-order-status','ProductsController@updateOrderStatus');

    // Admin User route
    Route::get('/admin/view-users','UsersController@viewUsers');
    
    // Add CMS Route
    Route::match(['get','post'], '/admin/add-cms-page', 'CmsPagecontroller@addCmsPage');

    // EDIT CMS Route
    Route::match(['get', 'post'],'/admin/edit-cms-page/{id}','CmsPageController@editCmsPage');

    // View CMS Page Route
    Route::get('admin/view-cms-pages', 'CmsPageController@viewCmsPages');

    // Delete CMS Route
    Route::get('admin/delete-cms-page/{id}', 'CmsPageController@deleteCmsPage');
    
});


Route::get('/logout', 'AdminController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Display Contact us Form Page
Route::match(['get','post'],'/page/contact','CmsPageController@contact');

// Display CMS Page
Route::match(['get','post'],'/page/{url}','CmsPageController@cmsPage');


