<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DatabaseQueriesController;
use App\Http\Controllers\PacientController;
use App\Http\Controllers\SpecializareController;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\OrarController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\ProgramareController;
use App\Http\Controllers\AxiosController;

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::redirect('/', '/acasa');
Route::redirect('/home', '/acasa');

Route::group(['middleware' => 'auth'], function () {
    Route::view('/acasa', 'acasa');

    Route::get('/database-queries', [DatabaseQueriesController::class, 'databaseQueries']);

    Route::resource('/pacienti', PacientController::class)->parameters(['pacienti' => 'pacient']);
    Route::resource('/specializari', SpecializareController::class)->parameters(['specializari' => 'specializare']);
    Route::resource('/medici', MedicController::class)->parameters(['medici' => 'medic']);
    Route::resource('/orare', OrarController::class)->parameters(['orare' => 'orar']);
    Route::resource('/cabinete', CabinetController::class)->parameters(['cabinete' => 'cabinet']);

    Route::any('/programari/adauga-resursa/{resursa}', [ProgramareController::class, 'programareAdaugaResursa']);
    Route::get('/programari/tip-afisare/{tipAfisare}/', [ProgramareController::class, 'index']);
    Route::resource('/programari', ProgramareController::class)->parameters(['programari' => 'programare']);

    // Route::get('/axios/get-available-orare', [AxiosController::class, 'getAvailableOrare']);
});

