<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

Route::group(
    // Config
    [
        'middleware' => ['auth', 'Role:0']

    // Routes
    ], function() {

        Route::get('/', 'DashboardController@index')->name('home');

        # Notifications
        Route::get('/notifications', 'NotificationsController@index')->name('notif.index');
        Route::get('/notifications/read/{id}', 'NotificationsController@setRead')->name('notif.read');

        # City search
        Route::get('/city/search/{query}', 'DashboardController@citySearch')->name('city.search');

        Route::resource('users', 'UserController');
        Route::resource('sensors', 'SensorController');

        # Reports
        Route::get('/reports', 'ReportController@index')->name('reports.index');
        Route::get('/reports/{date}/', 'ReportController@show')->name('reports.show');

        Route::get('/reports/{id}/chart/{date}', 'ReportController@chart')->name('chart');
    }
);


/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(
    // Config
    [
        'middleware' => ['auth', 'Role:10']

    // Routes
    ], function() {

        # Market
        Route::get('/market', 'MarketController@index')->name('market.index');
        Route::get('/market/save/{name}', 'MarketController@save')->name('market.save');
        Route::get('/market/delete/{name}', 'MarketController@delete')->name('market.delete');
    }
);
