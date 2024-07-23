<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Judet;
use App\Models\Localitate;

class DatabaseQueriesController extends Controller
{
    public function databaseQueries()
    {
        // Insert judete
        // $localitatiToate = DB::table('worksheet')->select('judet', 'auto')->distinct()->orderBy('judet')->get();
        // foreach ($localitatiToate as $localitate) {
        //     DB::table('judete')->insert([
        //         'nume' => $localitate->judet,
        //         'auto' => $localitate->auto,
        //     ]);
        // }

        // Insert localities
        // $localitatiToate = DB::table('worksheet')->get();
        // foreach ($localitatiToate as $localitate) {
        //     DB::table('localitati')->insert([
        //         'judet_id' => DB::table('judete')->where('nume', $localitate->judet)->first()->id,
        //         'nume' => $localitate->diacritice,
        //         'zip' => $localitate->zip,
        //     ]);
        // }

        // Put 0 in front to zip codes that are missing
        // $localitatiToate = Localitate::all();
        // foreach ($localitatiToate as $localitate) {
        //     if (strlen($localitate->zip) == 5)
        //         $localitate->zip = '0' . $localitate->zip;
        //         $localitate->save();
        //         echo $localitate->zip . '<br>';
        // }

        echo '<br><br>';
        return 'All good';
    }
}
