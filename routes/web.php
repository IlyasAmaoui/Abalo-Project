<?php

use App\Http\Controllers\AbArticleController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {return view('welcome');});



Route::get('/',[AbArticleController::class, 'index'])->name('home'); // show all articles
Route::get('/articles/{abarticle}',[AbArticleController::class, 'show'])->name('abArticles.show');// show the detailed form

Route::middleware('auth')->group(function () {
    Route::view('/newarticle', 'articles.create');
    Route::post('/articles', [AbArticleController::class, 'store']);
    Route::get('/articles/{abarticle}/edit', [AbArticleController::class, 'edit'])->name('abArticles.edit');
    Route::put('/articles/{abarticle}', [AbArticleController::class, 'update'])->name('abArticles.update');
    Route::delete('/articles/{abarticle}', [AbArticleController::class, 'destroy'])->name('abArticles.destroy');
});

// Register Routes
Route::view('/register', 'auth.register');
Route::post('/register',Register::class);

// Login routes
Route::view('/login', 'auth.login')->name('login');;
Route::post('/login', Login::class);


//Logout
Route::post('/logout',Logout::class);










//Route::post('/articles', [App\Http\Controllers\NewArticleController::class, 'store']);


Route::get('/api/articles',[App\Http\Controllers\api\ArticleApiController::class, 'searchArticle_api']);
Route::post('/api/articles',[App\Http\Controllers\api\ArticleApiController::class, 'store_article']);




Route::post('/api/shoppingcart', [App\Http\Controllers\api\ShoppingCartController::class, 'store_api']);
Route::get('/api/shoppingcarte', [App\Http\Controllers\api\ShoppingCartController::class, 'getUserCart_api']);
Route::delete('/api/shoppingcart/{shoppingcartid}/articles/{abarticle}', [App\Http\Controllers\api\ShoppingCartController::class, 'destroy'])->name('cart.store',);

## hada jdide
Route::get('/newsite' , function(){ return view('newsite'); });
Route::get('/newartikel', function(){ return view('newArticle');});

Route::get('/broadcast-maintenance', [App\Http\Controllers\BroadcasterClientController::class, 'sendMaintenanceMessage']);



Route::view('/soldTest', 'SoldTest');
Route::post('api/articles/{id}/sold', [App\Http\Controllers\api\ArticleApiController::class, 'notifySold']);

Route::post('api/articles/{id}/offer', [App\Http\Controllers\api\ArticleApiController::class, 'markAsOffer']);
