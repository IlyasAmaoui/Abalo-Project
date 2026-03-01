<?php

use App\Http\Controllers\AbArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('welcome');});


Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

Route::get('/articles',[AbArticleController::class, 'index']);
Route::view('/newarticle', 'articles.create');
Route::post('/articles',[AbArticleController::class, 'store']);


//Route::post('/articles', [App\Http\Controllers\NewArticleController::class, 'store']);


Route::get('/api/articles',[App\Http\Controllers\api\ArticleApiController::class, 'searchArticle_api']);
Route::post('/api/articles',[App\Http\Controllers\api\ArticleApiController::class, 'store_article']);




Route::post('/api/shoppingcart', [App\Http\Controllers\api\ShoppingCartController::class, 'store_api']);
Route::get('/api/shoppingcarte', [App\Http\Controllers\api\ShoppingCartController::class, 'getUserCart_api']);
Route::delete('/api/shoppingcart/{shoppingcartid}/articles/{articleId}', [App\Http\Controllers\api\ShoppingCartController::class, 'destroy']);

## hada jdide
Route::get('/newsite' , function(){ return view('newsite'); });
Route::get('/newartikel', function(){ return view('newArticle');});

Route::get('/broadcast-maintenance', [App\Http\Controllers\BroadcasterClientController::class, 'sendMaintenanceMessage']);



Route::view('/soldTest', 'SoldTest');
Route::post('api/articles/{id}/sold', [App\Http\Controllers\api\ArticleApiController::class, 'notifySold']);

Route::post('api/articles/{id}/offer', [App\Http\Controllers\api\ArticleApiController::class, 'markAsOffer']);
