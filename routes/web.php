<?php

use App\Http\Controllers\TestImageUploadController;
use Illuminate\Support\Facades\Route;
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
//     return view('app');
// });
Route::get('/', \App\Http\Livewire\Home::class)->name('home')->middleware('auth');
Route::get('/home', \App\Http\Livewire\Home::class)->name('home')->middleware('auth');
Route::group(['middleware'=>'guest'], function ()
{
    Route::get('/login', \App\Http\Livewire\Login::class)->name('login');
    Route::get('/register', \App\Http\Livewire\Register::class)->name('register');
});
Route::get('/logout', [\App\Http\Livewire\Login::class,'logout'])->name('logout');
Route::group(['middleware'=>'auth'], function(){
    Route::get('/dashboard', \App\Http\Livewire\Dashboard::class)->name('dashboard');
    Route::get('/pembelian', \App\Http\Livewire\Pembelian::class)->name('pembelian');
});

/**Untuk Testing */
Route::get('/test-image-upload', \App\Http\Livewire\TestImageUpload::class);
Route::post('/test-image-upload-db', [TestImageUploadController::class, 'imageUpload'])->name('imageUploadDB');

/**SPK */
