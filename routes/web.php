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

Route::get('/', function () {
    $url = 'uploads/5W9Vu0wQv5KUTvxgwC9YJVEXscOViN7gf6ptz4rd.png';
    $path = Storage::disk('public')->path($url);
    echo '<pre>';
    print_r(pathinfo($path));
    dd(1);
    return view('welcome');
});
