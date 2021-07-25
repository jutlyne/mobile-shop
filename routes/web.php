<?php

//Use Controller Admin
use App\Http\Controllers\Admin\AdminBrandProductController;
use App\Http\Controllers\Admin\AdminCatPostController;
use App\Http\Controllers\Admin\AdminCatProductController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminIndexController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminSaleController;
use App\Http\Controllers\Admin\AdminUserController;
//Use Controller Public
use App\Http\Controllers\Esmart\IndexController;
use App\Http\Controllers\Esmart\PostController;
use App\Http\Controllers\Esmart\ProductController;
//use Controller Auth
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Esmart\CartController;
use App\Http\Controllers\Esmart\CheckoutController;
use App\Http\Controllers\Esmart\CommentController;
use App\Http\Controllers\Esmart\SearchController;
use App\Http\Controllers\Esmart\UserController;
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

Route::pattern('slug', '(.*)');
Route::pattern('id', '[0-9]+');

/* ------------- Public -------------*/

Route::prefix('/')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('esmart.index.index');
    //Product
    Route::get('/san-pham', [ProductController::class, 'index'])->name('esmart.product.index');
    Route::get('/san-pham/{slug}-{id}', [ProductController::class, 'cat'])->name('esmart.product.cat');
    Route::get('/thuong-hieu/{slug}-{id}', [ProductController::class, 'brand'])->name('esmart.product.brand');
    Route::get('/san-pham/{slug}-{id}.html', [ProductController::class, 'detail'])->name('esmart.product.detail');
    //Post
    Route::get('/tin-tuc', [PostController::class, 'index'])->name('esmart.post.index');
    Route::get('/tin-tuc/{slug}-{id}', [PostController::class, 'cat'])->name('esmart.post.cat');
    Route::get('/tin-tuc/{slug}-{id}.html', [PostController::class, 'detail'])->name('esmart.post.detail');
    //Cart
    Route::get('/show-cart-ajax', [CartController::class, 'showCart'])->name('esmart.cart.show');
    Route::get('/add-cart/{id?}', [CartController::class, 'addCart'])->name('esmart.cart.add');
    Route::get('/add-cart-detail', [CartController::class, 'addCartDetail'])->name('esmart.cart.add-cart');
    Route::get('/edit-cart', [CartController::class, 'editCart'])->name('esmart.cart.edit');
    Route::get('/show-cart', [CartController::class, 'showAllCart'])->name('esmart.cart.show-cart');
    Route::get('/del-item-cart', [CartController::class, 'delItemCart'])->name('esmart.cart.del-item-cart');
    Route::get('/del-cart', [CartController::class, 'delCart'])->name('esmart.cart.del-cart');
    //Checkout
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('esmart.checkout.checkout');
    Route::post('/checkout', [CheckoutController::class, 'postCheckout'])->name('esmart.checkout.checkout');
    Route::get('/payment', [CheckoutController::class, 'payment'])->name('esmart.checkout.payment');
    Route::post('/payment', [CheckoutController::class, 'postPayment'])->name('esmart.checkout.payment');
    Route::post('/add-order', [CheckoutController::class, 'addOrder'])->name('esmart.checkout.add-order');
    Route::get('/dat-hang-thanh-cong/{code?}', [CheckoutController::class, 'notification'])->name('esmart.checkout.notification');
    //User
    Route::prefix('/user')->middleware('checkUserLogin')->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('esmart.user.profile');
        Route::post('/profile', [UserController::class, 'postProfile'])->name('esmart.user.profile');
        Route::get('/address', [UserController::class, 'address'])->name('esmart.user.address');
        Route::post('/address', [UserController::class, 'postAddress'])->name('esmart.user.address');
        Route::get('/password', [UserController::class, 'password'])->name('esmart.user.password');
        Route::post('/password', [UserController::class, 'postPassword'])->name('esmart.user.password');
        Route::get('/get-district', [UserController::class, 'getDistrict'])->name('esmart.user.getdistrict');
        Route::get('/get-ward', [UserController::class, 'getWard'])->name('esmart.user.getward');
        Route::get('/view-order', [UserController::class, 'viewOrder'])->name('esmart.user.vieworder');
        Route::get('/view-order-detail/{id}', [UserController::class, 'viewOrderDetail'])->name('esmart.user.vieworderdetail');
        Route::get('/cancel-order', [UserController::class, 'cancelOrder'])->name('esmart.user.cancelorder');
        Route::get('/success-order', [UserController::class, 'successOrder'])->name('esmart.user.successorder');
    });
    //Comment
    Route::post('/comment', [CommentController::class, 'addComment'])->name('esmart.comment.add-comment');
    //Search
    Route::get('/tim-kiem', [SearchController::class, 'search'])->name('esmart.search.search');
    Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('esmart.search.autocomplete');
});;

/* ------------- Admin -------------*/
Route::prefix('/admin')->middleware('adminLogin')->group(function () {
    Route::get('/index', [AdminIndexController::class, 'index'])->name('admin.index.index');
    //Category Product
    Route::prefix('/cat-product')->middleware('role:1')->group(function () {
        Route::get('/', [AdminCatProductController::class, 'index'])->name('admin.cat-product.index');
        Route::post('/add', [AdminCatProductController::class, 'postAdd'])->name('admin.cat-product.add');
        Route::get('/edit', [AdminCatProductController::class, 'edit'])->name('admin.cat-product.edit');
        Route::post('/edit', [AdminCatProductController::class, 'postEdit'])->name('admin.cat-product.edit');
        Route::get('/del', [AdminCatProductController::class, 'del'])->name('admin.cat-product.del');
    });
    //Brand Product
    Route::prefix('/brand-product')->middleware('role:1')->group(function () {
        Route::get('/', [AdminBrandProductController::class, 'index'])->name('admin.brand-product.index');
        Route::post('/add', [AdminBrandProductController::class, 'postAdd'])->name('admin.brand-product.add');
        Route::get('/edit', [AdminBrandProductController::class, 'edit'])->name('admin.brand-product.edit');
        Route::post('/edit', [AdminBrandProductController::class, 'postEdit'])->name('admin.brand-product.edit');
        Route::get('/del', [AdminBrandProductController::class, 'del'])->name('admin.brand-product.del');
    });
    //Product
    Route::prefix('/product')->group(function () {
        Route::get('/list-product', [AdminProductController::class, 'list'])->name('admin.product.list-product');
        Route::get('/add-product', [AdminProductController::class, 'add'])->name('admin.product.add-product');
        Route::post('/add-product', [AdminProductController::class, 'postAdd'])->name('admin.product.add-product');
        Route::get('/edit-product/{id}', [AdminProductController::class, 'edit'])->name('admin.product.edit-product');
        Route::post('/edit-product/{id}', [AdminProductController::class, 'postEdit'])->name('admin.product.edit-product');
        Route::get('/del-product/{id}', [AdminProductController::class, 'del'])->name('admin.product.del-product');
        Route::get('/del-gallery', [AdminProductController::class, 'delGallery'])->name('admin.gallery.del');
        Route::get('/change-status-product', [AdminProductController::class, 'changeStatusProduct'])->name('admin.product.change-status-product');
        Route::get('/change-popular-product', [AdminProductController::class, 'changePopularProduct'])->name('admin.product.change-popular-product');
    });
    //Cat Post
    Route::prefix('/cat-post')->middleware('role:1')->group(function () {
        Route::get('/', [AdminCatPostController::class, 'index'])->name('admin.cat-post.index');
        Route::post('/add', [AdminCatPostController::class, 'postAdd'])->name('admin.cat-post.add');
        Route::get('/edit', [AdminCatPostController::class, 'edit'])->name('admin.cat-post.edit');
        Route::post('/edit', [AdminCatPostController::class, 'postEdit'])->name('admin.cat-post.edit');
        Route::get('/del', [AdminCatPostController::class, 'del'])->name('admin.cat-post.del');
    });
    //Post
    Route::prefix('/post')->group(function () {
        Route::get('/list-post', [AdminPostController::class, 'list'])->name('admin.post.list-post');
        Route::get('/add-post', [AdminPostController::class, 'add'])->name('admin.post.add-post');
        Route::post('/add-post', [AdminPostController::class, 'postAdd'])->name('admin.post.add-post');
        Route::get('/edit-post/{id}', [AdminPostController::class, 'edit'])->name('admin.post.edit-post');
        Route::post('/edit-post/{id}', [AdminPostController::class, 'postEdit'])->name('admin.post.edit-post');
        Route::get('/del-post/{id}', [AdminPostController::class, 'del'])->name('admin.post.del-post');
        Route::get('/change-status-post', [AdminPostController::class, 'changeStatusPost'])->name('admin.post.change-status-post');
    });

    //Sale
    Route::prefix('/sale')->group(function () {
        Route::get('/list-sale', [AdminSaleController::class, 'index'])->name('admin.sale.list-sale');
        Route::get('/info/{id}', [AdminSaleController::class, 'info'])->name('admin.sale.info');
        Route::get('/add-sale', [AdminSaleController::class, 'add'])->name('admin.sale.add-sale')->middleware('role:1');
        Route::post('/add-sale', [AdminSaleController::class, 'postAdd'])->name('admin.sale.add-sale')->middleware('role:1');
        Route::get('/add-item/{id}', [AdminSaleController::class, 'addItem'])->name('admin.sale.add-item')->middleware('role:1');
        Route::get('/remove-item/{id}', [AdminSaleController::class, 'removeItem'])->name('admin.sale.remove-item')->middleware('role:1');
        Route::get('/edit-sale/{id}', [AdminSaleController::class, 'edit'])->name('admin.sale.edit-sale')->middleware('role:1');
        Route::post('/edit-sale/{id}', [AdminSaleController::class, 'postEdit'])->name('admin.sale.edit-sale')->middleware('role:1');
    });

    //Users
    Route::prefix('/user')->group(function () {
        Route::get('/list-user', [AdminUserController::class, 'list'])->name('admin.user.list-user');
        Route::get('/add-user', [AdminUserController::class, 'add'])->name('admin.user.add-user')->middleware('role:1');
        Route::post('/add-user', [AdminUserController::class, 'postAdd'])->name('admin.user.add-user')->middleware('role:1');
        Route::get('/edit-user/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit-user')->middleware('role:1');
        Route::post('/edit-user/{id}', [AdminUserController::class, 'postEdit'])->name('admin.user.edit-user')->middleware('role:1');
        Route::get('/del-user/{id}', [AdminUserController::class, 'del'])->name('admin.user.del-user')->middleware('role:1');
    });
    //Order
    Route::prefix('/order')->group(function () {
        Route::get('/list-order', [AdminOrderController::class, 'list'])->name('admin.order.list-order');
        Route::get('/detail-order/{id}', [AdminOrderController::class, 'detail'])->name('admin.order.detail-order');
        Route::post('/detail-order/{id}', [AdminOrderController::class, 'postDetail'])->name('admin.order.detail-order');
        Route::get('/member', [AdminOrderController::class, 'member'])->name('admin.order.member');
    });
    //Comment
    Route::prefix('/comment')->group(function () {
        Route::get('/list-comment', [AdminCommentController::class, 'list'])->name('admin.comment.list-comment');
        Route::get('/change-status', [AdminCommentController::class, 'changeStatus'])->name('admin.comment.change-status');
        Route::post('/reply-comment', [AdminCommentController::class, 'replyComment'])->name('admin.comment.reply-comment');
        Route::get('/del-comment', [AdminCommentController::class, 'delComment'])->name('admin.comment.del-comment');
    });
});

/* -------------Auth-----------------*/
Route::prefix('/auth')->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('auth.auth.register');
    Route::post('/register', [AuthController::class, 'postRegister'])->name('auth.auth.register');
    Route::get('/login', [AuthController::class, 'login'])->name('auth.auth.login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.auth.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.auth.logout');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.auth.reset-password');
    Route::post('/reset-password', [AuthController::class, 'postResetPassword'])->name('auth.auth.reset-password');
    Route::get('/check-code', [AuthController::class, 'checkCode'])->name('auth.auth.check-code');
    Route::post('/check-code', [AuthController::class, 'postCheckCode'])->name('auth.auth.check-code');
    Route::get('/change-password', [AuthController::class, 'changePassword'])->name('auth.auth.change-password');
    Route::post('/change-password', [AuthController::class, 'postChangePassword'])->name('auth.auth.change-password');
});

/* ------------- Redirect Route -------------*/
Route::get('/admin', function () {
    return redirect()->route('admin.index.index');
});
Route::get('/admin/product', function () {
    return redirect()->route('admin.product.list-product');
});
Route::get('/auth', function () {
    return redirect()->route('auth.auth.login');
});
Route::get('/user', function () {
    return redirect()->route('esmart.user.profile');
});

/* ------------- Summernote -------------*/
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
