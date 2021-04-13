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
//     return view('front.index');
// });

// define('PAGINATION_COUNT',10);


Route::group(['namespace' => 'Admin','middleware' => 'auth:admin'], function () {

    Route::get('/','DashboardController@index')->name('admin.dashboard');

    ####################### Begin Route Langauge ###########################

    Route::group(['prefix' => 'langauages'], function () {
        Route::get('/','langaugeController@index')->name('admin.langauges');
        
        Route::get('/create','langaugeController@create')->name('admin.langauges.create');
        Route::post('/store','langaugeController@store')->name('admin.langauges.store');

        Route::get('/edit/{id}','langaugeController@edit')->name('admin.langauges.edit');
        Route::post('/update/{id}','langaugeController@update')->name('admin.langauges.update');
        
        Route::get('/delete/{id}','langaugeController@destroy')->name('admin.langauges.delete');

    });

    ####################### End Route Langauge #############################
    
        ####################### Begin maincategory Route  ###########################

        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/','mainCategoriesController@index')->name('admin.maincategories');
            
            Route::get('/create','mainCategoriesController@create')->name('admin.maincategories.create');
            Route::post('/store','mainCategoriesController@store')->name('admin.maincategories.store');
    
            Route::get('/edit/{id}','mainCategoriesController@edit')->name('admin.maincategories.edit');
            Route::post('/update/{id}','mainCategoriesController@update')->name('admin.maincategories.update');
            
            Route::get('/delete/{id}','mainCategoriesController@destroy')->name('admin.maincategories.delete');
            Route::get('/changestatus/{id}','mainCategoriesController@changestatus')->name('admin.maincategory.status');
    
        });
    
        ####################### End maincategory Route  #############################

                ####################### Begin vendors Route  ###########################

                Route::group(['prefix' => 'Vendors'], function () {
                    Route::get('/','VendorsController@index')->name('admin.Vendors');
                    
                    Route::get('/create','VendorsController@create')->name('admin.Vendors.create');
                    Route::post('/store','VendorsController@store')->name('admin.Vendors.store');
            
                    Route::get('/edit/{id}','VendorsController@edit')->name('admin.Vendors.edit');
                    Route::post('/update/{id}','VendorsController@update')->name('admin.Vendors.update');
                    
                    Route::get('/delete/{id}','VendorsController@destroy')->name('admin.Vendors.delete');

                    Route::get('/chandgstatus/{id}','VendorsController@change_status')->name('admin.Vendors.status');
            
                });
            
                ####################### End vendors Route  #############################

});




 Auth::routes();

 Route::get('/home', 'HomeController@index')->name('home');


Route::group(['namespace'=>'Admin','middleware'=>'guest:admin'], function () {
    Route::get('/login','LoginController@getlogin');  
    Route::post('/login','LoginController@postlogin')->name('admin.login');  
    
});

