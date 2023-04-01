<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// gpt-app
Route::get('/chat', \App\Http\Controllers\Chat\IndexController::class)->name('chat.index');
Route::post('/chat', [\App\Http\Controllers\Chat\ChatGptController::class, 'chat'])->name('chat.create');


// 観光地ページ
Route::get('/place', [\App\Http\Controllers\Place\IndexController::class, 'show']);

Route::get('/place/create', [\App\Http\Controllers\Place\CreateController::class, 'show']);

Route::post('/place/create', [\App\Http\Controllers\Chat\ChatGptController::class, 'chat'])->name('chat.create');

Route::get('/place/{id}', [\App\Http\Controllers\Place\IndexController::class, 'showId']);

// tutorial
Route::get('/sample', [\App\Http\Controllers\Sample\IndexController::class, 'show']);

Route::get('/sample/{id}', [\App\Http\Controllers\Sample\IndexController::class, 'showId']);

Route::get('/tweet', \App\Http\Controllers\Tweet\IndexController::class)->name('tweet.index');

Route::post('/tweet/create', \App\Http\Controllers\Tweet\CreateController::class)->name('tweet.create');

Route::delete('/tweet/delete/{tweetId}', \App\Http\Controllers\Tweet\DeleteController::class)->name('tweet.delete');

Route::get('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\IndexController::class)->name('tweet.update.index')->where('tweetId', '[0-9]+');
Route::put('/tweet/update/{tweetId}', \App\Http\Controllers\Tweet\Update\PutController::class)->name('tweet.update.put')->where('tweetId', '[0-9]+');
