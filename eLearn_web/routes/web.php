<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Pagina inicial se não tiver login
Route::get('/', function () {return view('auth.login');});

// Rotas usuários protegidas por middleware
Route::resource('user', UserController::class)->middleware(('auth'));

// Remove rotas de registro e reset senha
Auth::routes(['register'=>false, 'reset'=>false]);

Route::get('/home', [UserController::class, 'index'])->name('home');

// Rotas protegidas por middleware
Route::group(['middleware' => 'auth'], function() { 
    Route::get('/', [userController::class, 'index'])->name('home');
});
