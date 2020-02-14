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

//VISTAS
/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/inici', function () {
    return view('helloworld');
});

Route::get('/inici/hola/{nom}', function($nom){

    return view('helloname', array('nom' => $nom));
});

//RUTAS
Route::get('/hola', function () {
    return 'Hello World!!';
});

Route::get('/hola/{nom}', function($nom)
{
    return 'Hola '.$nom.'!!';
});

//RUTAS EXERCICI 2
Route::get('/','HomeController@getHome');

/*
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/logout', function () {
    return 'Logout usuari';
});
*/

Route::get('/catalog','CatalogController@getIndex')->middleware('auth');

Route::get('/catalog/show/{id}','CatalogController@getShow')->middleware('auth');

Route::get('/catalog/create','CatalogController@getCreate')->middleware('auth');

Route::get('/catalog/edit/{id}','CatalogController@getEdit')->middleware('auth');

Route::get('/home', 'HomeController@getHome')->name('home');

Route::post('catalog/create','CatalogController@postCreate')->middleware('auth');

Route::post('/review/create','CatalogController@createReview')->middleware('auth');

Route::put('/catalog/edit/{id}','CatalogController@putEdit')->middleware('auth');

Route::put('/catalog/rent/{id}','CatalogController@putRent')->middleware('auth');

Route::put('/catalog/return/{id}','CatalogController@putReturn')->middleware('auth');

Route::put('/catalog/delete/{id}','CatalogController@deleteMovie')->middleware('auth');

Route::resource('category','CategoryController')->middleware('auth');

Route::get('/catalog','CatalogController@search');

//PELICULAS FAVORITAS PARA USUARIOS
Route::get('/favorite','CatalogController@showFav')->middleware('auth');

Route::post('/favorite/create/{id}','CatalogController@addFav')->middleware('auth');

Route::delete('/favorite/delete/{id}','CatalogController@deleteFav')->middleware('auth');

//COMENTARIS
Route::get('/review','CatalogController@showUserReviews')->middleware('auth');

Route::delete('/review/delete/{id}','CatalogController@deleteReview')->middleware('auth');

Auth::routes();
