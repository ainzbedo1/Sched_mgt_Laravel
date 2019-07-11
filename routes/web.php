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
Route::get('/', 'MainController@index');
Route::resource('EventCategory', 'EventCategoryController');
Route::resource('event', 'EventController');

Route::any('/test', function()
{
    return view('calendar');
});

Route::get('/sched', 'EventController@create')->name('event.sched');;
Route::post('/sched/add', 'EventController@store')->name('event.add');

Route::get('/sched/#', 'EventCategoryController@create')->name('event.cat');
Route::post('/sched/add_cat', 'EventCategoryController@store')->name('event_category.add');
Route::get('/sched/edit/{id}','EventCategoryController@update')->name('event.edit');

Route::get('/sched/ajax', 'EventController@ajaxget');

Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::post('/main/register', 'MainController@register');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');


Route::get('/account', 'MainController@account')->name('user.edit');
Route::post('/account/user', 'MainController@updateUser')->name("user.update");
/*
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('activate/{token}', 'Auth\RegisterController@activate')
    ->name('activate');
*/