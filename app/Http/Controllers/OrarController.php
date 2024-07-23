<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Orar;
use App\Models\Medic;
use App\Models\Specializare;

class OrarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('orarReturnUrl');

        $searchSpecializareId = $request->searchSpecializareId;
        $searchMedicId = $request->searchMedicId;

        $orare = Orar::
            when($searchSpecializareId, function ($query, $searchSpecializareId) {
                return $query->where('specializare_id', $searchSpecializareId);
            })
            ->when($searchMedicId, function ($query, $searchMedicId) {
                return $query->where('medic_id', $searchMedicId);
            })
            ->latest()
            ->simplePaginate(25);

        $specializari = Specializare::select('id', 'denumire')->get();
        $medici = Medic::select('id', 'nume')->get();

        return view('orare.index', compact('orare', 'searchSpecializareId', 'searchMedicId', 'specializari', 'medici'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('orarReturnUrl') ?? $request->session()->put('orarReturnUrl', url()->previous());

        $orar = new Orar;
        $specializari = Specializare::select('id', 'denumire')->get();
        $medici = Medic::select('id', 'nume')->get();

        return view('orare.create', compact('orar', 'specializari', 'medici'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orar = Orar::create($this->validateRequest($request));

        return redirect($request->session()->get('orarReturnUrl') ?? ('/orare'))->with('status', 'Orarul a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orar  $orar
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Orar $orar)
    {
        $request->session()->get('orarReturnUrl') ?? $request->session()->put('orarReturnUrl', url()->previous());

        return view('orare.show', compact('orar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Orar  $orar
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Orar $orar)
    {
        $request->session()->get('orarReturnUrl') ?? $request->session()->put('orarReturnUrl', url()->previous());

        $specializari = Specializare::select('id', 'denumire')->get();
        $medici = Medic::select('id', 'nume')->get();

        return view('orare.edit', compact('orar', 'specializari', 'medici'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orar  $orar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orar $orar)
    {
        $orar->update($this->validateRequest($request));

        return redirect($request->session()->get('orarReturnUrl') ?? ('/orare'))->with('status', 'Orarul a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orar  $orar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Orar $orar)
    {
        $orar->delete();

        return back()->with('status', 'Orarul a fost șters cu succes!');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        // Se adauga userul doar la adaugare, iar la modificare nu se schimba
        // if ($request->isMethod('post')) {
        //     $request->request->add(['user_id' => $request->user()->id]);
        // }

        // if ($request->isMethod('post')) {
        //     $request->request->add(['cheie_unica' => uniqid()]);
        // }

        return $request->validate(
            [
                'specializare_id' => 'required',
                'medic_id' => '',
                'data' => '',
                'de_la' => '',
                'pana_la' => '',
            ],
            [
            ]
        );
    }
}
