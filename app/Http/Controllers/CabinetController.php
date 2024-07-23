<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cabinet;

class CabinetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('cabinetReturnUrl');

        $searchNume = $request->searchNume;

        $cabinete = Cabinet::
            when($searchNume, function ($query, $searchNume) {
                return $query->where('nume', 'like', '%' . $searchNume . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('cabinete.index', compact('cabinete', 'searchNume'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('cabinetReturnUrl') ?? $request->session()->put('cabinetReturnUrl', url()->previous());

        $cabinet = new Cabinet;

        return view('cabinete.create', compact('cabinet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cabinet = Cabinet::create($this->validateRequest($request));

        return redirect($request->session()->get('cabinetReturnUrl') ?? ('/cabinete'))->with('status', 'Cabinetul „' . $cabinet->nume . '” a fost adăugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cabinet $cabinet)
    {
        $request->session()->get('cabinetReturnUrl') ?? $request->session()->put('cabinetReturnUrl', url()->previous());

        return view('cabinete.show', compact('cabinet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Cabinet $cabinet)
    {
        $request->session()->get('cabinetReturnUrl') ?? $request->session()->put('cabinetReturnUrl', url()->previous());

        return view('cabinete.edit', compact('cabinet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cabinet $cabinet)
    {
        $cabinet->update($this->validateRequest($request));

        return redirect($request->session()->get('cabinetReturnUrl') ?? ('/cabinete'))->with('status', 'Cabinetul „' . $cabinet->nume . '” a fost modificat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cabinet  $cabinet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cabinet $cabinet)
    {
        if ($cabinet->programari->count() > 0){
            return back()->with('error', 'Nu poți șterge cabinetul „' . $cabinet->nume . '” pentru că are programări atașate. Șterge mai întâi programările.');
        }

        $cabinet->delete();

        return back()->with('status', 'Cabinetul „' . $cabinet->nume . '” a fost șters cu succes!');
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
                'descriere' => 'nullable|max:2000',
                'observatii' => 'nullable|max:2000',
            ],
            [
            ]
        );
    }
}
