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
  

Route::group(['middleware' => 'auth:api'] , function(){     

    Route::group(['middleware' => ['role:shop.manager']], function () {   
        Route::resource('city','CityController', ['only' => ['store','edit','delete']]); 
    }); 

    Route::group(['middleware' => ['role:shop.manager|Shop.User|Shop.Operator']], function () {  
        Route::resource('city','CityController', ['only' => ['index','show']]); 
    });
        
});  