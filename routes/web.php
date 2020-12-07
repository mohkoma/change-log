<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Mohkoma\ChangeLog\Controllers', 'prefix' => 'dev', 'middleware' => config('changelog.middleware.read')], function() {

    // Show as view
    Route::get('changelog', "ChangeLogController@show")->name('changelog.view');

    // Show as json
    Route::get('changelog/json', "ChangeLogController@index")->name('changelog.index');

    // Write
    Route::group(['middleware' => config('changelog.middleware.write')], function() {

        // show the form
        Route::get('changelog/create', "ChangeLogController@create")->name('changelog.create');

        // Store new release
        Route::post('changelog', "ChangeLogController@store")->name('changelog.store');

    });
});