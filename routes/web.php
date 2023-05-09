<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
use App\Http\Controllers\ArticleController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('mahasiswas/nilai/{Nim}', [MahasiswaController::class, 'nilai']);

Route::resource('mahasiswas', MahasiswaController::class);

Route::get('mahasiswas/cetak_khs/{Nim}', [MahasiswaController::class, 'cetak_khs'])->name('cetak_khs');

Route::get('articles/cetak_pdf', [ArticleController::class, 'cetak_pdf']);

Route::resource('articles', ArticleController::class);