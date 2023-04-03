<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\Convention\ConventionController;

use App\Http\Controllers\Convention\ConventionInterface;
use App\Http\Controllers\Convention\ConvFactory;
use App\Http\Controllers\DistributionPracticeController;
use App\Http\Controllers\GrnLetterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\PremiseController;

use App\Http\Controllers\PrStudentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\Convention;
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





Route::get('/login', [\App\Http\Controllers\UserLoginLdap::class, 'loginPage'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\UserLoginLdap::class, 'loginUser'])->middleware('guest');;

Route::post('/logout', [\App\Http\Controllers\UserLoginLdap::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group( function (){




    Route::middleware('role:umu')->group(function (){


        Route::resource('settings',   SettingController::class)->except('show');




        Route::resource('users', UserController::class)->except([
            'create', 'store', 'show'
        ]); // может только админ или менеджер

    });




    Route::get('/ajax/pulpitbyedtype/{id}', [AjaxController::class, 'getPulptitByEdType']);
});


