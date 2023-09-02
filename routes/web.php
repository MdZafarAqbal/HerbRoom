<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FixedBannerController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

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

// Register User
Route::view('/register', 'auth.register')->middleware('guest')->name('register.view');
Route::permanentRedirect('/signup', '/register')->name('signup.view');
Route::post('/register-user', RegisterController::class)->name('register');

// Verify Email
Route::view('/verify-email', 'auth.verify-email')->middleware(['auth', 'verified.not'])->name('verification.view');
Route::redirect('/email-verify', '/verify-email')->name('verify.email');
Route::get('/email-verify/{id}/{hash}', [VerificationController::class, 'verifyEmail'])->middleware(['auth', 'signed', 'verified.not'])->name('verification.verify');
Route::post('/resend-verification-email', [VerificationController::class, 'resendVerificationEmail'])->middleware(['auth', 'throttle:6,1', 'verified.not'])->name('verification.resend');

// Login User
Route::get('/login', [LoginController::class, 'loginView'])->name('login.view');
Route::permanentRedirect('/signin', '/login')->name('signin.view');
Route::post('/user-login', [LoginController::class, 'login'])->middleware('throttle:login')->name('login');

// Logout User
Route::redirect('/user-logout', '/logout')->name('logout.user');

// Reset password
Route::view('password-reset', 'auth.passwords.old-reset')->name('reset.password');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email.password');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('update.password');
Route::get('password-resets', [FrontendController::class, 'resetPasswordView'] )->name('reset.password.view');

// Main Pages
Route::middleware('verified')->group(function () {
  Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('product-detail/{slug}', 'productDetail')->name('product.detail');
    Route::get('/products', 'products')->name('products');
    Route::get('/product-cat/{slug}', 'catProducts')->name('cat.products');
    Route::get('/product-cat/{slug}/{subslug}', 'subcatProducts')->name('subcat.products');
  });
  Route::redirect('/home', '/')->name('index');
  Route::view('/about-us','main.pages.about-us')->name('about.us');
  Route::view('/contact','main.pages.contact')->name('contact');
  Route::view('/cart', 'main.pages.cart')->name('cart');
  Route::view('/checkout', 'main.pages.checkout')->name('checkout');
  Route::view('/faq', 'main.pages.faq')->name('faq');
  Route::view('/privacy-policy', 'main.pages.privacy-policy')->name('privacy.policy');
  Route::view('/terms-and-conditions', 'main.pages.terms-and-conditions')->name('terms.and.conditions');
});

Route::controller(FrontendController::class)->group(function () {
  Route::get('/logout', 'logout')->middleware('auth')->name('logout');
  Route::match(['get','post'], '/search', 'searchProducts')->name('product.search');
  Route::match(['get','post'], '/autocomplete-search', 'autocompleteSearch')->name('autocomplete.search');
  Route::match(['get','post'], '/sort', 'sortProducts')->name('sort.product');
  Route::get('/product-price', 'productPrice')->name('price.product');
  Route::get('/user-exists', 'existsUser')->name('exists.user');
});

Route::post('/order', CheckoutController::class)->name('order');

Route::controller(OrderController::class)->group(function () {
  Route::get('/income', 'incomeChart')->name('income.chart');
  Route::get('/sale/orders/{order}', 'saleInvoice')->name('sale.pdf');
  Route::get('/tax/orders/{order}', 'taxInvoice')->name('tax.pdf');
  Route::get('/order-track/{order_no}', 'trackOrder')->name('track.order');
  Route::get('/orders', 'userOrders')->name('orders');
  Route::get('/order-detail/{order_no?}', 'orderDetail')->name('order.detail');
  Route::get('/order-return/{order_no}', 'actionView')->name('return.view');
  Route::get('/order-return', 'returnOrder')->name('return.order');
  Route::get('/order-cancel/{order_no}', 'actionView')->name('cancel.view');
  Route::get('/order-cancel', 'cancelOrder')->name('cancel.order');
  Route::get('/action-email/{action}', 'actionEmail')->name('action.email');
});

Route::controller(ModalController::class)->group(function () {
  Route::get('/create-modal', 'createModal')->name('create.modal');
  Route::get('/create-sizes', 'createSizes')->name('create.sizes');
});

Route::resource('cart-items', CartItemController::class)->only([
  'store', 'update', 'destroy'
]);

Route::get('/states', [StateController::class, 'getStates'])->name('get.states');
Route::get('/cities', [CityController::class, 'getCities'])->name('get.cities');

Route::get('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');

// Wishlist
Route::delete('/wishlists/{product_id}', [WishlistController::class, 'destroy'])->name('wishlists.destroy');
Route::resource('wishlists', WishlistController::class)->only([
  'index', 'store'
]);

// Product Review
Route::post('/product/{slug}/review', [ReviewController::class, 'store'])->name('review.store');
// Coupon
Route::post('/coupon-store', [CouponController::class, 'storeCoupon'])->name('coupon.store');

// Payment
Route::match(['get','post'], '/stripe', [StripeController::class, 'payment'])->name('order.payment');
Route::post('/payment-refund', [StripeController::class, 'refund'])->name('refund.payment');

//Get SubCategory

// Backend section start
Route::prefix('/admin')->group(function () {
  Route::middleware(['auth', 'admin'])->group(function () {
    //ProductAttribute
    Route::match(['get','post'], '/product/edit-attributes/{id}', [ProductController::class, 'editAttribute'])->name('edit.attribute');
    
    Route::match(['get','post'], '/product/delete-attributes/{id}', [ProductController::class, 'deleteAttribute'])->name('delete.attribute');
    //Add Product Image
    Route::match(['get','post'], '/product/delete-images/{id}', [ProductController::class, 'deleteImage'])->name('delete.image');
    //Delete category
    Route::match(['get','post'], '/product/delete-category/{id}', [ProductController::class, 'deleteCategory'])->name('delete.category');
    //Delete Brand
    Route::match(['get','post'], '/product/delete-brand/{id}', [ProductController::class, 'deleteBrand'])->name('delete.brand');
    Route::post('/category/{id}/child', [CategoryController::class, 'getChildByParent']);
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::view('/file-manager', 'admin.layouts.file-manager')->name('file-manager');

    Route::resources([
      'banners' => BannerController::class,
      'brands' => BrandController::class,
      'categories' => CategoryController::class,
      'cities' => CityController::class,
      'countries' => CountryController::class,
      'coupons' => CouponController::class,
      'fixed-banners' => FixedBannerController::class,
      'forms' => FormController::class,
      'orders' => OrderController::class,
      'product-imports' => ImportController::class,
      'products' => ProductController::class,
      'reviews' => ReviewController::class,
      'states' => StateController::class,
      'subcategories' => SubCategoryController::class,
      'users' => UserController::class,
    ]);
    
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile/{id}', [AdminController::class, 'updateProfile'])->name('profile.update');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/setting/update', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Notification
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('delete.notification');

    // Password Change
    Route::view('/change-password', 'admin.layouts.changePassword')->name('password.change.view');
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('password.change');
  });
});
