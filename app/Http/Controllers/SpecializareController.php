<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Specializare;

class SpecializareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('specializareReturnUrl');

        $searchDenumire = $request->searchDenumire;

        $specializari = Specializare::
            when($searchDenumire, function ($query, $searchDenumire) {
                return $query->where('denumire', 'like', '%' . $searchDenumire . '%');
            })
            ->latest()
            ->simplePaginate(25);

        return view('specializari.index', compact('specializari', 'searchDenumire'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('specializareReturnUrl') ?? $request->session()->put('specializareReturnUrl', url()->previous());

        $specializare = new Specializare;

        return view('specializari.create', compact('specializare'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $specializare = Specializare::create($this->validateRequest($request));

        return redirect($request->session()->get('specializareReturnUrl') ?? ('/specializari'))->with('status', 'Specializarea „' . $specializare->denumire . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Specializare  $specializare
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Specializare $specializare)
    {
        $request->session()->get('specializareReturnUrl') ?? $request->session()->put('specializareReturnUrl', url()->previous());

        return view('specializari.show', compact('specializare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Specializare  $specializare
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Specializare $specializare)
    {
        $request->session()->get('specializareReturnUrl') ?? $request->session()->put('specializareReturnUrl', url()->previous());

        return view('specializari.edit', compact('specializare'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Specializare  $specializare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specializare $specializare)
    {
        $specializare->update($this->validateRequest($request));

        return redirect($request->session()->get('specializareReturnUrl') ?? ('/specializari'))->with('status', 'Specializarea „' . $specializare->denumire . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specializare  $specializare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Specializare $specializare)
    {
        if ($specializare->medici->count() > 0){
            return back()->with('error', 'Nu poți șterge specializarea „' . $specializare->denumire . '” pentru că are medici atașați. Șterge mai întâi medicii.');
        }

        $specializare->delete();

        return back()->with('status', 'Specializarea „' . $specializare->denumire . '” a fost ștearsă cu succes!');
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
                'denumire' => 'required|max:255',
                'descriere' => 'max:2000',
                'observatii' => 'max:2000',
            ],
            [
            ]
        );
    }
}
