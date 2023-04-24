<?php


use App\Http\Controllers\HomeController;


use App\Http\Controllers\RestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TabulagramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginLdap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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





Route::get('/login', [UserLoginLdap::class, 'loginPage'])->name('login')->middleware('guest');
Route::post('/login', [UserLoginLdap::class, 'loginUser'])->middleware('guest');;

Route::post('/logout', [UserLoginLdap::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group( function (){



    Route::get('/rest',[  RestController::class, 'show'])->name('rest.show');
    Route::get('/tabulagram',[  TabulagramController::class, 'show'])->name('tabulagram.show');
    Route::middleware('role:admin')->group(function (){
        Route::resource('settings',   SettingController::class)->except('show');
        Route::resource('users', UserController::class)->except([
            'create', 'store', 'show'
        ]);
    });


});


