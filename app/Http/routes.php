<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => 'web'], function () {
    Route::auth();
	//Algemene routes
	Route::get('/', 'HomeController@checkLogged');
    Route::get('/home', array(
    	'as'=>'home',
    	'uses'=>'HomeController@index'
		)
	);
	//Routes voor de groepen
	Route::get('/groups',array(
		'as'=>'groups',
		'uses'=>'GroupController@listGroups'
		)
	);
	Route::get('/group/{groupName}', 'GroupController@editGroup');
	Route::post('/group/{groupName}', array(
		'as'=> 'groupUpdate',
		'uses'=> 'GroupController@saveGroup'
		)
	);
	Route::get('/newGroup','GroupController@newGroup');
	Route::post('/newGroup',array(
		'as' => 'groupInsert',
		'uses' => 'GroupController@saveGroup'
		)
	);
	Route::post('/checkGroupRemoval','GroupController@checkForPages');
	Route::post('/removeGroup','GroupController@removeGroup');
	//Routes voor de paginas...
	Route::get('/newPage','PageController@create');
	Route::post('/newPage',array(
		'as' => 'pageInsert',
		'uses' => 'PageController@store'
		)
	);
	Route::get('/pages',array(
		'as'=>'pages',
		'uses'=>'PageController@listPages'
		)
	);
	Route::get('/page/{seo}','PageController@editPage');
	Route::post('/page/{seo}', array(
		'as'=> 'pageUpdate',
		'uses'=> 'PageController@store'
		)
	);
	Route::post('/removePage','PageController@destroy');
	//Routes voor het menu
	Route::get('/menu',array(
		'as'=>'menu',
		'uses'=>'MenuController@edit'
		)
	);
	Route::get('/getMenuItems','MenuController@getMenuJson');
	Route::post('/saveMenu','MenuController@saveMenu');
});
