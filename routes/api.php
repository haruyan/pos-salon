<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// v2 untuk android
Route::group(['prefix' => 'v2'], function() {
    Route::post('login', 'Api\UserController@login');
    Route::post('register', 'Api\UserController@register');
});

Route::group(['middleware' => 'auth:api'], function(){
    
Route::group(['prefix' => 'v2'], function() {
  
    Route::post('logout', 'Api\UserController@logout');
  
    Route::get('details', 'Api\UserController@details');
    Route::get('index','Api\UserController@index');

    // PRODUCT CATEGORY APIs
    Route::group(['prefix' => 'product-category'], function() {
        // product list
        Route::get('/','Api\Product_categoriesController@index');

        // product general search : keyword or category
        Route::get('/search','Api\Product_categoriesController@search');

        //product category create, edit, delete
        Route::post('/create','Api\Product_categoriesController@store');
        Route::post('/{id}','Api\Product_categoriesController@update');
        Route::delete('/{id}','Api\Product_categoriesController@destroy');

    });
  
    // PRODUCT APIs
    Route::group(['prefix' => 'products'], function() {                                                   
        // product list
        Route::get('/','Api\ProductController@index');
      
        // product general search : keyword or category
        Route::get('/search','Api\ProductController@search');
      
        // product create
        Route::post('/create','Api\ProductController@store');
        Route::post('/prices/get','Api\ProductController@productPrice');
    });

    // PROMO APIs
    Route::group(['prefix' => 'promo'], function() {
        // product list with ordering
        Route::get('/','Api\PromoController@index');
        Route::get('/bycode/{code}','Api\PromoController@detailByCode');
    });

    // MEMBER-CATEGORY APIs
    Route::group(['prefix' => 'member-category'], function() {
        Route::get('/','Api\MemberCategoryController@index');
        Route::get('/search','Api\MemberCategoryController@search');
        //product category create, edit, delete
        Route::post('/create','Api\MemberCategoryController@store');
        Route::post('/{id}','Api\MemberCategoryController@update');
        Route::delete('/{id}','Api\MemberCategoryController@destroy');
    });
    // MEMBER APIs
    Route::group(['prefix' => 'members'], function() {
        Route::get('/','Api\MemberController@index');
        Route::get('/search','Api\MemberController@search');
        Route::post('/create','Api\MemberController@store');
        Route::post('/{id}','Api\MemberController@update');
        Route::delete('/{id}','Api\MemberController@destroy');
    });

    // CODE APIs
    Route::group(['prefix' => 'code'], function() {
        Route::get('/','Api\CodePromoController@index');
    });
  
    // TRANSACTION APIs
    Route::group(['prefix' => 'transaction'], function() {
        Route::post('/', 'Api\TransactionsController@store');
        Route::get('/', 'Api\TransactionsController@index');
        Route::get('/show/{id}', 'Api\TransactionsController@show');
        Route::get('/search', 'Api\TransactionsController@search');
        Route::get('/{cashier}','Api\TransactionsController@cashier');
        Route::get('/member/{id}','Api\TransactionsController@member');
    });
    
    //REPORT APIs
    Route::get('/report', 'Api\StockController@reportMobile');
    Route::get('/report/sales', 'Api\SalesController@reportMobile');

    //STOCK APIs
    Route::group(['prefix' => 'stock'], function() {
        Route::post('/create','Api\StockController@store');
    });

 });
});

// v1 untuk axios
Route::group(['prefix' => 'v1'], function() {

    Route::get('user/{id}','Api\UserController@show');
    Route::get('product_categories/{id}','Api\Product_categoriesController@show');
    Route::get('products/{id}','Api\ProductController@show');
    Route::get('memberCat/{id}','Api\MemberCategoryController@show');
    Route::get('member/{id}','Api\MemberController@show');
    Route::get('price/{id}','Api\PriceController@show');
    Route::get('promos/{id}','Api\PromoController@show');
    Route::get('codepromo/{id}','Api\CodePromoController@show');
    Route::get('transactions/{id}','Api\TransactionsController@show');
    Route::get('stocks/{id}','Api\StockController@show');

    //STOCK APIs
    Route::get('/report', 'Api\StockController@report'); // stock report
    Route::get('/sales', 'Api\SalesController@report'); // sales report
    Route::get('/trx/filter', 'Api\TransactionsController@filter');

});