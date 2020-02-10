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
Route::group(['middleware' => ['auth']], function () {

    Route::get('product/getbycategory/{category}','ProductController@getProductByCategory');
    Route::get('product/category/{id}','ProductController@indexCategorized')->name('product.categorized');

    Route::get('stocks/report','StockController@report')->name('stocks.report');
    
    Route::get('sales', 'SalesController@index')->name('sales.index');

    Route::get('transactions/members','TransactionsController@memberIndex')->name('transactions.member');
    Route::get('transactions/members/{id}','TransactionsController@memberShow')->name('transactions.memberShow');

    Route::resources([
        'product_categories'    => 'Product_categoriesController',
        'products'              => 'ProductController',
        'prices'                => 'PriceController',
        'members'               => "MemberController",
        'users'                 => 'UserController',
        'memberCat'             => "MemberCategoryController",
        'promos'                => "PromoController",
        'codepromo'             => "CodePromoController",
        'prices'                => 'PriceController',
        'transactions'          => 'TransactionsController',
        'stocks'                => 'StockController',
    ]);




    Route::get('/', function () {
        return view('welcome');
    });
});

Auth::routes(['register'=>false,
                'password.request'=>false,
                'password.reset'=>false]
            );
