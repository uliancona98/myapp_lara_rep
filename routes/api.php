<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/greeting', function (Request $request){
    return 'Hello World!';
});
Route::get('products', "ProductController@index");
Route::post('products', "ProductController@store");
Route::put('products/{id}', "ProductController@update");
Route::delete('products/{id}', "ProductController@destroy");
Route::get('products/{id}', "ProductController@show");