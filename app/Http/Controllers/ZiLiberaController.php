<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ZiLibera;
use App\Models\Medic;
use App\Models\Specializare;

class ZiLiberaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->forget('ziLiberaReturnUrl');

        $searchMedicId = $request->searchMedicId;

        $zileLibere = ZiLibera::
            when($searchMedicId, function ($query, $searchMedicId) {
                return $query->where('medic_id', $searchMedicId);
            })
            ->latest()
            ->simplePaginate(25);

        $medici = Medic::select('id', 'nume')->get();

        return view('zileLibere.index', compact('zileLibere', 'searchMedicId', 'medici'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $medicId = null)
    {
        $request->session()->get('ziLiberaReturnUrl') ?? $request->session()->put('ziLiberaReturnUrl', url()->previous());

        $ziLibera = new ZiLibera;
        $ziLibera->medic_id = $medicId;
        $medici = Medic::select('id', 'nume')->get();

        return view('zileLibere.create', compact('ziLibera', 'medici'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ziLibera = ZiLibera::create($this->validateRequest($request));

        return redirect($request->session()->get('ziLiberaReturnUrl') ?? ('/zile-libere'))->with('status', 'Ziua liberă a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ZiLibera  $ziLibera
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ZiLibera $ziLibera)
    {
        $request->session()->get('ziLiberaReturnUrl') ?? $request->session()->put('ziLiberaReturnUrl', url()->previous());

        return view('zileLibere.show', compact('ziLibera'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ZiLibera  $ziLibera
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ZiLibera $ziLibera)
    {
        $request->session()->get('ziLiberaReturnUrl') ?? $request->session()->put('ziLiberaReturnUrl', url()->previous());

        $medici = Medic::select('id', 'nume')->get();

        return view('zileLibere.edit', compact('ziLibera', 'medici'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ZiLibera  $ziLibera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZiLibera $ziLibera)
    {
        $ziLibera->update($this->validateRequest($request));

        return redirect($request->session()->get('ziLiberaReturnUrl') ?? ('/zile-libere'))->with('status', 'Ziua liberă a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ZiLibera  $ziLibera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ZiLibera $ziLibera)
    {
        $ziLibera->delete();

        return back()->with('status', 'Ziua liberă a fost ștearsă cu succes!');
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
                'medic_id' => 'required',
                'data' => 'required',
            ],
            [
            ]
        );
    }
}
