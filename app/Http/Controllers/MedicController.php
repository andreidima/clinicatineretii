<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Medic;
use App\Models\Specializare;

class MedicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('medicReturnUrl');

        $searchNume = $request->searchNume;

        $medici = Medic::
            when($searchNume, function ($query, $searchNume) {
                return $query->where('nume', 'like', '%' . $searchNume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('medici.index', compact('medici', 'searchNume'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('medicReturnUrl') ?? $request->session()->put('medicReturnUrl', url()->previous());

        $medic = new Medic;
        $specializari = Specializare::select('id', 'denumire')->get();

        return view('medici.create', compact('medic', 'specializari'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $medic = Medic::create($this->validateRequest($request));

        return redirect($request->session()->get('medicReturnUrl') ?? ('/medici'))->with('status', 'Medicul „' . $medic->nume . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Medic $medic)
    {
        $request->session()->get('medicReturnUrl') ?? $request->session()->put('medicReturnUrl', url()->previous());

        return view('medici.show', compact('medic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Medic $medic)
    {
        $request->session()->get('medicReturnUrl') ?? $request->session()->put('medicReturnUrl', url()->previous());

        $specializari = Specializare::select('id', 'denumire')->get();

        return view('medici.edit', compact('medic', 'specializari'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medic $medic)
    {
        $medic->update($this->validateRequest($request));

        return redirect($request->session()->get('medicReturnUrl') ?? ('/medici'))->with('status', 'Medicul „' . $medic->nume . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medic  $medic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Medic $medic)
    {
        $medic->delete();

        return back()->with('status', 'Medicul „' . $medic->nume . '” a fost șters cu succes!');
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
                'nume' => 'required|max:255',
                'telefon' => 'nullable|max:255',
                'email' => 'nullable|max:255',
                'descriere' => 'nullable|max:2000',
                'observatii' => 'nullable|max:2000',
            ],
            [
            ]
        );
    }
}
