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


use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    Cart::update('3f98937baeb19acd123af99c4336f550',1);
    dd(Cart::content());

})->name('test');

Route::get('/w0', function () {
    return view('welcome');
})->name('login');

Route::get('/w', function () {
    return view('welcome');
})->name('w');


/********************---------------FRONT ROUTES------------------************************/
Route::get('/', 'Front\homeController@home')->name('home');
Route::get('/show/{slug}', 'Front\homeController@show')->name('front.show');


/*---------------COMMENTS------------------*/
Route::post('comments', '\Laravelista\Comments\CommentController@store');
Route::match(['put','post'],'comments/{comment}', '\Laravelista\Comments\CommentController@update');
//Route::put('comments/{comment}', '\Laravelista\Comments\CommentController@update');
//Route::post('comments/{comment}', '\Laravelista\Comments\CommentController@reply');


/*---------------CHECKOUT------------------*/
Route::get('/checkout', 'Front\checkOutController@index')->name('front.checkout');
Route::post('/checkout', 'Front\checkOutController@store')->name('front.checkout.store');


/*---------------LISTS------------------*/
Route::match(['get','post'],'/products', 'Front\homeController@productsList')->name('front.productsList');
Route::match(['get','post'],'/products/{list}/{slug}','Front\homeController@list')->where([
    'list' => '[A-za-z]+',
//    'slug' => '[A-Za-z0-9]+'
])->name('front.lists');

/*---------------CART------------------*/
Route::resource('/cart','Front\cartController')->except(['create','edit','update']);
Route::post('/cart/edit','Front\cartController@update')->name('cart.update');
Route::get('/carts/clear','Front\cartController@clear')->name('cart.clear');




/*---------------***************ADMIN ROUTES******************------------------*/
Route::group(['prefix' => 'admin'], function () {

    Route::get('/cat', function () {
        return view('admin.category.index');
    })->name('cat');

    /*---------------DASHBOARD------------------*/
    Route::get('/dashboard', 'Admin\dashboardController@index')->name('admin.dashboard');

    /*---------------Products Routes------------------*/
    Route::resource('product', 'Admin\productController');
    Route::get('product/sort/{sort?}', 'Admin\productController@sort')->name('product.index.sort');
    Route::get('product/sort/sort/{category_id}', 'Admin\productController@sortByCategory')->name('product.index.sortCat');
    Route::get('product/index/trash', 'Admin\productController@withTrash')->name('product.index.trash');
    Route::get('product/index/restore/{id}', 'Admin\productController@restore')->name('product.restore');
    /*---------------PHOTOS Routes------------------*/
    Route::resource('photo', 'Admin\PhotoController');

    /*---------------CATEGORIES ROUTE------------------*/
    Route::resource('category', 'Admin\categoryController')->except(['show','edit','update']);

    /*---------------BRAND ROUT------------------*/
    Route::resource('brand', 'Admin\brandController')->except(['show']);

    /*---------------GIFT CARD------------------*/
    Route::resource('giftCard', 'Admin\giftCardController')->except(['show']);

    /*---------------****ORDERS****------------------*/
    Route::get('orders', 'Admin\orderController@index')->name('order.index');
    Route::get('not-sent-orders', 'Admin\orderController@notSent')->name('order.not_sent');
    Route::get('orders/{id}', 'Admin\orderController@show')->name('order.show');
    Route::delete('orders/{id}', 'Admin\orderController@destroy')->name('order.destroy');
    Route::post('orders/{id}', 'Admin\orderController@detailDestroy')->name('order.detail.destroy');
    Route::get('orders/status/{id}/{status}', 'Admin\orderController@status')->name('order.status');
//    Route::post('orders','Admin\orderController@sent')->name('order.sent');

    /*---------------****COMMENTS****------------------*/
    Route::get('comments', '\Laravelista\Comments\CommentController@index')->name('comments.index');
    Route::get('comments/new', '\Laravelista\Comments\CommentController@new')->name('comments.new');
    Route::get('comments/{comment}', '\Laravelista\Comments\CommentController@approve')->name('comment.approve');
    Route::delete('comments/{comment}', '\Laravelista\Comments\CommentController@destroy');


});
