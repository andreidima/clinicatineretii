<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Orar;

class AxiosController extends Controller
{
    public function getAvailableOrare(Request $request){
        $orare = Orar::where('specializare_id', $request->specializare_id)->where('medic_id', $request->medic_id)->where('data', $request->data)->orderBy('de_la')->get();

        return response()->json([
            'orare' => $orare,
        ]);

    }
}
