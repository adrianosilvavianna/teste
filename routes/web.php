<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/setLocale', 'HomeController@changeLocale')->name('changeLocale');

Route::get('/setLocale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'pt-br'])) {
        abort(400);
    }

    $locale == 'en' ? App::setLocale('pt-br') : App::setLocale('en');

    App::setLocale($locale);

    return redirect()->back();
});

Auth::routes();


Route::middleware(['check_manager'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('product', 'ProductsController');
    Route::resource('inventory', 'InventoryController');
    Route::resource('attribute', 'AttributeController');

    Route::get('/attribute_type/{id}', 'AttributeTypesController@create')->name('attribute_type.create');
    Route::post('/attribute_type', 'AttributeTypesController@store')->name('attribute_type.store');
    Route::delete('/attribute_type/{id}', 'AttributeTypesController@delete')->name('attribute_type.delete');



});
