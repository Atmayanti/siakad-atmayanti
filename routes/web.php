<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MahasiswaController;

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

// Route::get('/', function () {
//     return view('mahasiswa.index');
// });
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', [MahasiswaController::class, 'index']);

Route::resource('mahasiswa', MahasiswaController::class);

Route::resource('articles', ArticleController::class);

Route::get('/khsmahasiswa/{id}', [MahasiswaController::class, 'khs'])->name('mahasiswa.khs');

Route::get('/article/cetak_pdf', [ArticleController::class, 'cetak_pdf'])->name('cetak_pdf');

Route::get('/khsmahasiswa/cetak_pdf/{id}', [MahasiswaController::class, 'cetak_khs'])->name('cetak_khs');