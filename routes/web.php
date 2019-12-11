<?php

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


use App\Models\Attribute;
use App\Models\brand;
use App\Models\Color;
use App\Models\Tag;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
   return 2 == 2
       ? 'true'
       : 'false' ;


//    return view('admin.test');
})->name('test');


Route::get('/query', function () {

    \Illuminate\Support\Facades\DB::enableQueryLog();

    $attr = Attribute::findOrFail(3);
    $attr->attributeValues()->delete();
    $attr->delete();



    $query = \Illuminate\Support\Facades\DB::getQueryLog();
    dd($query);

})->name('test');

Route::get('/w0', function () {

    if (session()->has('order_id')) {
        $x = substr(str_replace(',', '', Cart::total()), 0, -2);
        dd($x);
    }
})->name('login');

Route::get('/w', function () {
    return view('admin.log-in');
})->name('w');


/********************---------------FRONT ROUTES------------------************************/
Route::get('/', 'Front\homeController@home')->name('home');
Route::get('/show/{slug}', 'Front\homeController@show')->name('front.show');


/*---------------COMMENTS------------------*/
Route::post('comments', '\Laravelista\Comments\CommentController@store');
Route::match(['put', 'post'], 'comments/{comment}', '\Laravelista\Comments\CommentController@update');
//Route::put('comments/{comment}', '\Laravelista\Comments\CommentController@update');
//Route::post('comments/{comment}', '\Laravelista\Comments\CommentController@reply');


/*---------------CHECKOUT------------------*/
Route::get('/inter-checkout', 'Front\checkOutController@interCheckOut')->name('front.inter.checkout');
Route::get('/checkout', 'Front\checkOutController@index')->name('front.checkout');
Route::post('/checkout/check-discount', 'Front\checkOutController@checkDiscount')->name('front.checkout.checkDiscount');
Route::post('/checkout', 'Front\checkOutController@store')->name('front.checkout.store');
Route::post('/checkout/address', 'Front\checkOutController@saveAddress')->name('front.address.store');
Route::post('/checkout/orderStatus', 'Front\checkOutController@saveOrderStatus')->name('front.order.saveStatus');


/*---------------LISTS------------------*/
Route::match(['get', 'post'], '/products', 'Front\homeController@productsList')->name('front.productsList');
Route::match(['get', 'post'], '/products/{list}/{slug}', 'Front\homeController@list')->where([
    'list' => '[A-za-z]+',
//    'slug' => '[A-Za-z0-9]+'
])->name('front.lists');

/*---------------CART------------------*/
Route::resource('/cart', 'Front\cartController')->except(['create', 'edit', 'update']);
Route::post('/cart/edit', 'Front\cartController@update')->name('cart.update');
Route::get('/carts/clear', 'Front\cartController@clear')->name('cart.clear');


/*---------------SEARCh------------------*/
Route::get('/search/{query}', 'Front\homeController@search')->name('front.search')->where(
    ['query' => '[A-za-z]+']);


/*---------------***************ADMIN ROUTES******************------------------*/
Route::group(['prefix' => 'admin'], function () {

    Route::get('/cat', function () {
        return view('admin.category.index');
    })->name('cat');

    /*---------------SEARCH------------------*/
    Route::post('/search', 'Admin\dashboardController@search')->name('admin.search');

    /*---------------DASHBOARD------------------*/
    Route::get('/dashboard', 'Admin\dashboardController@index')->name('admin.dashboard');

    /*---------------Products Routes------------------*/
    Route::resource('product', 'Admin\productController');
    Route::post('product/sort', 'Admin\productController@sort')->name('product.index.sort');
    Route::get('product/index/trash', 'Admin\productController@withTrash')->name('product.index.trash');
    Route::get('product/index/restore/{id}', 'Admin\productController@restore')->name('product.restore');
    Route::get('product/tags/{tag}', 'Admin\productController@productTags')->name('products.tags');

    /*---------------ATTRIBUTES ROUTES------------------*/
    Route::resource('attribute','Admin\attributeController')->except(['index','show']);
    Route::delete('attribute/value/{id}','Admin\attributeController@deleteValue')->name('attribute.deleteValue');
    //when create new attribute calling from show product
    Route::get('/attribute/createNew/{id}', 'Admin\attributeController@createNew')->name('attribute.createNew');

    /*---------------PHOTOS Routes------------------*/
    Route::resource('photo', 'Admin\PhotoController');

    /*---------------CATEGORIES ROUTE------------------*/
    Route::resource('category', 'Admin\categoryController')->except(['show', 'edit', 'update']);

    /*---------------BRAND ROUT------------------*/
    Route::resource('brand', 'Admin\brandController')->except(['show']);

    /*---------------GIFT CARD------------------*/
    Route::resource('giftCard', 'Admin\giftCardController')->except(['show']);

    /*---------------****ORDERS****------------------*/
    Route::get('orders', 'Admin\orderController@index')->name('order.index');
    Route::get('not-sent-orders', 'Admin\orderController@notSent')->name('order.not_sent');
    Route::get('orders/{id}', 'Admin\orderController@show')->name('order.show');
    Route::delete('orders/{id}', 'Admin\orderController@destroy')->name('order.destroy');
    Route::delete('orders/orders-status/{id}', 'Admin\orderController@detailDestroy')->name('order.detail.destroy');
    Route::get('orders/status/{id}/{status}', 'Admin\orderController@status')->name('order.status');
//    Route::post('orders','Admin\orderController@sent')->name('order.sent');

    /*---------------****COMMENTS****------------------*/
    Route::get('comments', '\Laravelista\Comments\CommentController@index')->name('comments.index');
    Route::get('comments/new', '\Laravelista\Comments\CommentController@new')->name('comments.new');
    Route::get('comments/{comment}', '\Laravelista\Comments\CommentController@approve')->name('comment.approve');
    Route::delete('comments/{comment}', '\Laravelista\Comments\CommentController@destroy');


});
