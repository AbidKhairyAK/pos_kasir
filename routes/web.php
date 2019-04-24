<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', 'OrderController@index')->name('orders.index');
Route::get('/orders/create', 'OrderController@create')->name('orders.create');
Route::post('/orders/store', 'OrderController@store')->name('orders.store');
Route::get('/orders/{id}/details', 'OrderController@show')->name('orders.show');
Route::get('/orders/{id}/edit', 'OrderController@edit')->name('orders.edit');
Route::put('/orders/{id}/update', 'OrderController@update')->name('orders.update');