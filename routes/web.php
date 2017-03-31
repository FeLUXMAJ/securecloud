<?php

// authentication
Auth::routes();

Route::post('/login/password', 'Auth\LoginController@loginWithPassword');
Route::get('/logout', 'Auth\LoginController@logout');


// about
Route::get('/about', function() {
    return view('about');
});


// Cloud (user is logged in)
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [
        'as' => 'cloud-home',
        'uses' => 'CloudController@index'
    ]);

});

// files
Route::group(['prefix' => 'file'], function () {

    // public access to imges
    Route::get('show/{hash}', [
        'uses' => 'FileController@show',
        'as' => 'file.show'
    ]);

    Route::post('upload', [
        'middleware' => 'auth',
        'uses' => 'FileController@uploadFiles',
        'as' => 'file.upload'
    ]);

    Route::post('delete', [
        'middleware' => 'auth',
        'uses' => 'FileController@delete',
        'as' => 'file.delete'
    ]);

    Route::get('download/{fileHash}', [
        'middleware' => 'auth',
        'uses' => 'FileController@download',
        'as' => 'file.download'
    ]);

	Route::get('download/{fileHash}/share/{shareHash}', [
		'uses' => 'FileController@download',
		'as' => 'file.share-download'
	]);

});

Route::group(['prefix' => 'share'], function () {

	Route::post('create', [
		'middleware' => 'auth',
		'uses' => 'ShareController@create',
		'as' => 'share.create'
	]);

	Route::get('index', [
		'middleware' => 'auth',
		'uses' => 'ShareController@index',
		'as' => 'share.index'
	]);

	Route::post('delete/{hash}', [
		'middleware' => 'auth',
		'uses' => 'ShareController@delete',
		'as' => 'share.delete'
	]);

	Route::get('/{hash}', [
		'uses' => 'ShareController@show',
		'as' => 'share.show'
	]);

});