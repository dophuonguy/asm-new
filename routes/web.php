<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[ClientController::class, 'index'])->name('index');
Route::get('/details',[DetailsController::class, 'details'])->name('details');
Route::get('/tag',[TagController::class, 'tag'])->name('tag');
Route::get('/contact',[ContactController::class, 'contact'])->name('contact');






Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth', 'check_permissions'])->group(function(){

});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
