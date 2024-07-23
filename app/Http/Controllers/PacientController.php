<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Closure;

use App\Models\Pacient;
use App\Models\Localitate;
use App\Models\Judet;

class PacientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('pacientReturnUrl');

        $searchNume = $request->searchNume;
        $searchTelefon = $request->searchTelefon;
        $searchCnp = $request->searchCnp;

        $pacienti = Pacient::
            when($searchNume, function ($query, $searchNume) {
                foreach (explode(" ", $searchNume) as $cuvant){
                    $query->where(function ($query) use($cuvant) {
                        return $query->where('nume', 'like', '%' . $cuvant . '%')
                                ->orWhere('prenume', 'like', '%' . $cuvant . '%');
                    });
                }
                return $query;
            })
            ->when($searchTelefon, function ($query, $searchTelefon) {
                $query->where(function ($query) use($searchTelefon) {
                    return $query->where('telefon_fix', 'like', '%' . $searchTelefon . '%')
                                ->orWhere('telefon_mobil', 'like', '%' . $searchTelefon . '%');
                });
            })
            ->when($searchCnp, function ($query, $searchCnp) {
                return $query->where('cnp', $searchCnp);
            })
            ->latest()
            ->simplePaginate(25);

        return view('pacienti.index', compact('pacienti', 'searchNume', 'searchTelefon', 'searchCnp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('pacientReturnUrl') ?? $request->session()->put('pacientReturnUrl', url()->previous());

        $localitati = Localitate::select('id', 'nume', 'judet_id')->get();
        $judete = Judet::select('id', 'nume')->get();

        return view('pacienti.create', compact('localitati', 'judete'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pacient = Pacient::create($this->validateRequest($request));

        // If the "pacient" was added from "programare" form, it will be sent in session, to be used in "programare"
        if ($request->session()->exists('programareRequest')) {
            $programareRequest = $request->session()->put('programareRequest.pacient_id', $pacient->id);
        }

        return redirect($request->session()->get('pacientReturnUrl') ?? ('/pacienti'))->with('status', 'Pacientul „' . $pacient->nume . ' ' . $pacient->prenume . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pacient  $pacient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pacient $pacient)
    {
        $request->session()->get('pacientReturnUrl') ?? $request->session()->put('pacientReturnUrl', url()->previous());

        return view('pacienti.show', compact('pacient'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pacient  $pacient
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Pacient $pacient)
    {
        $request->session()->get('pacientReturnUrl') ?? $request->session()->put('pacientReturnUrl', url()->previous());

        $localitati = Localitate::select('id', 'nume', 'judet_id')->get();
        $judete = Judet::select('id', 'nume')->get();

        return view('pacienti.edit', compact('pacient', 'localitati', 'judete'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pacient  $pacient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pacient $pacient)
    {
        $pacient->update($this->validateRequest($request, $pacient));

        return redirect($request->session()->get('pacientReturnUrl') ?? ('/pacienti'))->with('status', 'Pacientul „' . $pacient->nume . ' ' . $pacient->prenume . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pacient  $pacient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Pacient $pacient)
    {
        if ($pacient->programari->count() > 0){
            return back()->with('error', 'Nu poți șterge pacientul „' . ($pacient->nume ?? '') . ' ' . ($pacient->prenume ?? '') . '” pentru că are programări adăugate. Șterge mai întâi programările.');
        }

        $pacient->delete();

        return back()->with('status', 'Pacientul „' . $pacient->nume . ' ' . $pacient->prenume . '” a fost șters cu succes!');
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
                'nume' => 'required|max:255',
                'prenume' => 'required|max:255',
                'cnp' => 'nullable|max:20',
                'sex' => 'nullable|max:20',
                'data_nastere' => '',
                'judet_nastere_id' => '',
                'loc_nastere' => 'nullable|max:255',
                'tata' => 'nullable|max:255',
                'mama' => 'nullable|max:255',
                'functia_med_mun' => 'nullable|max:255',
                'functie_principala' => 'nullable|max:255',
                'formare_scolara' => 'nullable|max:255',
                'loc_munca' => 'nullable|max:255',
                'forma_contract_data_angajare' => 'nullable|max:255',
                'ocupatie' => 'nullable|max:255',
                'telefon' => 'nullable|max:255',
                'email' => 'nullable|max:255',
                'acceptare_comunicare' => '',
                'localitate_id' => '',
                'adresa' => 'nullable|max:255',
                'act_identitate_tip' => '',
                'act_indentitate_serie' => 'nullable|max:255',
                'act_identitate_numar' => 'nullable|max:255',
                'act_identitate_eliberat_de' => 'nullable|max:255',
                'act_identitate_eliberat_la' => 'nullable|max:255',
                'observatii' => 'nullable|max:2000',
            ],
            [
            ]
        );
    }
}



