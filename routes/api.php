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


Route::group(['namespace' => 'API']  , function(){    
 
    Route::group(['prefix' => 'Auth' , 'namespace' => 'Auth']  , function(){     
        Route::post('/register' , 'UserController@register');
        Route::post('/login' , 'UserController@login');  
        Route::post('reset-password', 'UserController@reset');
        Route::post('new-password', 'UserController@password'); 
        Route::get('/login/{provider}', 'SocialloginController@redirectToProvider');
        Route::get('/login/{provider}/callback', 'SocialloginController@handleProviderCallback');
 
        Route::group(['middleware' => 'auth:api'] , function(){    
            Route::get('profile' , 'UserController@profile'); 
            Route::put('profile/update' , 'UserController@update');  
            Route::post('logout' , 'UserController@logout');   
        }); 
    }); 

 
    Route::group(['prefix' => 'role' , 'namespace' => 'Role']  , function(){   
        Route::post('addRole', 'RoleAPIController@addRole');
        Route::post('addPermission', 'RoleAPIController@addPermission');
        Route::post('addpermissiontorole', 'RoleAPIController@addpermissiontorole');
        Route::post('deletepermission', 'RoleAPIController@deletepermission');
        Route::post('deleteallpermission', 'RoleAPIController@deleteallpermission');
    });


    Route::group(['middleware' => ['role:ShopManager']], function () {  
        Route::resource('services','Service\ServiceAPIController', ['only' => ['store','edit','delete']]);
        Route::resource('applications','Application\ApplicationAPIController', ['only' => ['create','edit','delete']]); 
    }); 

    Route::group(['middleware' => ['role:ShopUser|ShopOperator']], function () {  
        Route::resource('services','Service\ServiceAPIController', ['only' => ['index','show']]);
        Route::resource('applications','Application\ApplicationAPIController', ['only' => ['index','show']]); 
    });
 

}); 