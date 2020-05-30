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
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/statistics', 'profileController@funStats');

//Go to the profile
Route::get('/profile', 'HomeController@profile')->name('profile');

//To go to the fun statistics
Route::get('/statistics', 'HomeController@statistics');

Route::get('/searchQuery', 'HomeController@searchQuery');
Route::get('/searchQuery/{code}/{searchValue}', ['uses' => 'HomeController@search']);

//------------------------------
//To Register new information  |
//------------------------------

//Registration page
Route::get('/register_new_info', 'HomeController@newInfoRegistration');
//Register an artist
Route::get('/register_new_info/{artist}', ['uses' => 'HomeController@registerArtist']);
//Register an album
Route::get('/register_new_info/{artist}/{album}', ['uses' => 'HomeController@registerAlbum']);
//Register a track (and its genre)
Route::get('/register_new_info/{artist}/{album}/{trackName}/{genre}?url={url}', ['uses' => 'HomeController@registerTrack']);

Route::get('/changeRoles', 'HomeController@changeRoles');
Route::get('/changeRole/{user}/{changeto}', ['uses' => 'HomeController@rolechange']);
//---------------------------------
//To delete existing information  |
//---------------------------------

//Main delete page
Route::get('/delete', 'HomeController@deletePage');
//Delete an artist (And all of the albums and tracks)
Route::get('/delete/{artist}', ['uses' => 'HomeController@deleteArtist']);
//Delete an album (and all the tracks inside of it)
Route::get('/delete/{artist}/{album}', ['uses' => 'HomeController@deleteAlbum']);
//Delete a track
Route::get('/delete/{artist}/{album}/{track}', ['uses' => 'HomeController@deleteTrack']);



Route::get('/updateInfo', 'HomeController@UpdateInfoEntrance');
Route::get('/updateInfoArtist/{oldArtist}/{newArtist}', ['uses' => 'HomeController@updateArtistInfo']);
Route::get('/updateInfoAlbum/{artist}/{album}/{newAlbum}', ['uses' => 'HomeController@updateAlbumInfo']);
Route::get('/updateInfoTrack/{artist}/{album}/{track}/{newTrack}', ['uses' => 'HomeController@updateTrackInfo']);


//-----------------------------------
//To hide a song                    |
//-----------------------------------

Route::get('/hide', 'HomeController@hideSong');
Route::get('/hide/{artist}/{album}/{track}', ['uses' => 'HomeController@hideTheSongMethod']);


Route::get('/userChanges', 'HomeController@userChanges');

Route::get('/deleteUser/{id}', ['uses' => 'HomeController@deleteUser']);



// To generate CSV

Route::get('/generateCSV', 'HomeController@generateCSV');

Route::resource('mongo', "MongoController");

// Post Resources
Route::post('/addedSomething', 'HomeController@addSomething');

Route::post('/deleteSomething', 'HomeController@deleteSomething');

Route::post('/updateSomething', 'HomeController@updateSomething');

Route::post('/buyTrack', 'HomeController@buyTrack');

Route::get('/changelog', 'HomeController@changeLog');

Route::post('/addTrackToShoppingCart', 'HomeController@addTrackToShoppingCart');

Route::get('/shoppingCart', 'HomeController@displayShoppingCart');

Route::post('/deleteFromShoppingCart', 'HomeController@deleteFromShoppingCart');
