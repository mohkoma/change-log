<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Mohkoma\ChangeLog', 'prefix' => 'dev', 'middleware' => config('changelog.middleware.read')], function() {

    // Show as view
    Route::get('changelog', "ChangelogController@show")->name('changelog.view');

    // Show as json
    Route::get('changelog/json', "ChangelogController@index")->name('changelog.index');

    // Write
    Route::group(['middleware' => config('changelog.middleware.write')], function() {

        // show the form
        Route::get('changelog/create', "ChangelogController@create")->name('changelog.create');

        // Store new release
        Route::post('changelog', "ChangelogController@store")->name('changelog.store');

    });
});