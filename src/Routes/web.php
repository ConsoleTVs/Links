<?php

Route::group(['middleware' => 'web', 'as' => 'links::', 'prefix' => config('links.prefix'), 'namespace' => 'ConsoleTVs\Links\Controllers'], function () {
    Route::get('/login', 'LinksController@showLogin')->name('login');
    Route::post('/login', 'LinksController@login');

    Route::group(['middleware' => 'links.middleware'], function () {
        Route::get('/', 'LinksController@links')->name('links');
        Route::get('/logout', 'LinksController@logout')->name('logout');
        Route::get('/{slug}/stats', 'LinksController@link')->name('link');
        Route::get('/{slug}/stats/{specific}/{specific_value}', 'LinksController@specific')->name('specific');
    });

    Route::get('/{slug}', 'LinksController@redirect')->name('redirect');
});
