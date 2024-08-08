<?php
use Illuminate\Support\Facades\Route;

use Carbon\Carbon;
use App\Models\Programare;

use App\Http\Controllers\DatabaseQueriesController;
use App\Http\Controllers\PacientController;
use App\Http\Controllers\SpecializareController;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\OrarController;
use App\Http\Controllers\ZiLiberaController;
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
    Route::resource('/cabinete', CabinetController::class)->parameters(['cabinete' => 'cabinet']);

    Route::resource('/orare', OrarController::class)->parameters(['orare' => 'orar']);
    Route::resource('/specializare/{specializareId}/medic/{medicId}/orare', OrarController::class)->parameters(['orare' => 'orar']);

    Route::resource('/zile-libere', ZiLiberaController::class)->parameters(['zile-libere' => 'ziLibera']);
    Route::resource('/medici-zile-libere/medic/{medicId}/zile-libere', ZiLiberaController::class)->parameters(['zile-libere' => 'ziLibera']);

    Route::any('/programari/adauga-resursa/{resursa}', [ProgramareController::class, 'programareAdaugaResursa']);
    Route::get('/programari/tip-afisare/{tipAfisare}/', [ProgramareController::class, 'index']);
    Route::resource('/programari', ProgramareController::class)->parameters(['programari' => 'programare']);

    // Route::get('/delete-appointments', function () {
    //     $data = Carbon::now()->subMonths(3);
    //     $dataSfarsit = Carbon::now()->addMonths(3);
    //     while ($data->lt($dataSfarsit)) {
    //         $programari = Programare::where('medic_id', 4)->whereDate('data', $data)->get();
    //             if (($data->dayOfWeekIso == 1) || ($data->dayOfWeekIso == 3))
    //             foreach ($programari as $programare) {
    //                 if (Carbon::parse($programare->pana_la)->)
    //             }
    //         echo $data->isoFormat('DD.MM.YYYY') . ' - ' . $programari->count() . ' - ' . ($programari->first()->data ?? '') . '<br>';
    //         $data->addDay();
    //     }
    // });
});

