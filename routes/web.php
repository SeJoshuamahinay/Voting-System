<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/voting', function () {
    return view('voting');
})->name('voting');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/guidelines', function () {
    return view('guidelines');
})->name('guidelines');

Route::get('/results', function () {
    return view('results');
})->name('results');

Route::get('/login', function () {
    return view('login');
})->name('login');