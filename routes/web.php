<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => ADMIN, 'as' => ADMIN . '.', 'middleware'=>['auth', 'Role:0']], function() {
    Route::get('/', 'DashboardController@index')->name('dash');

    # City search
    Route::get('/city/search/{query}', 'DashboardController@citySearch')->name('city.search');

    Route::resource('users', 'UserController');
    Route::resource('sensors', 'SensorController');

    # Reports
    Route::get('/reports', 'ReportController@index')->name('reports.index');
    Route::get('/reports/{date}/show', 'ReportController@show')->name('reports.show');

    Route::get('/reports/{id}/chart/{date}', 'ReportController@chart')->name('chart');

    # Market
    Route::get('/market', 'MarketController@index')->name('market.index');
    Route::get('/market/save/{name}', 'MarketController@save')->name('market.save');
    Route::get('/market/delete/{name}', 'MarketController@delete')->name('market.delete');
});


Route::get('/', function () {
    return redirect('/' . ADMIN);
})->name('home');

Route::get('/test', function() {
    dd( );
});
