<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Medic;
use App\Models\Specializare;
use App\Models\Programare;
use App\Models\Cabinet;
use App\Models\Orar;
use App\Models\ZiLibera;
use App\Models\Pacient;

class ProgramareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipAfisare = null)
    {
        $request->session()->forget('programareReturnUrl');

        // $searchSpecializare = $request->searchSpecializare ?? null;
        // $searchMedic = $request->searchMedic ?? null;
        // $searchPacient = $request->searchPacient ?? null;
        // $searchData = $request->searchData ?? null;
        // $searchDataToataSaptamana = $request->searchDataToataSaptamana ?? null;
// $request->specializare_id ?? $request->specializare_id = 6;
// $request->medic_id ?? (($request->specializare_id == 6) ? ($request->medic_id = 4) : '') ;

        $programariQuery = Programare::
            when($request->specializare_id, function ($query, $specializare_id) {
                $query->where('specializare_id', $specializare_id);
            })
            ->when($request->medic_id, function ($query, $medic_id) {
                $query->where('medic_id', $medic_id);
            })
            ->when($request->pacient_id, function ($query, $pacient_id) {
                $query->where('pacient_id', $pacient_id);
            });

        if ($tipAfisare == "administrare") {
            $programari = $programariQuery
                ->when($request->data, function ($query, $data) {
                    return $query->whereDate('data', $data);
                })
                ->latest()
                ->simplePaginate(25);
        } elseif ($tipAfisare == "saptamanal"){
            $request->data ?? $request->data = Carbon::now();

            // If is pressed one of the buttons to change the calendar week
            if ($request->action){
                $request->data = Carbon::parse($request->data);
                if ($request->action === "previousWeek"){
                    $request->data->startOfWeek()->subDays(7);
                }else if ($request->action === "nextWeek"){
                    $request->data->startOfWeek()->addDays(7);
                }
            }

            $zileDeLucru = [];
            if ($request->specializare_id && $request->medic_id){ // just if those 2 fields are completed

                $dataDeCautat = Carbon::parse($request->data);
                // $orare = Orar::where('medic_id', $request->medic_id)->get()->pluck('zi_din_saptamana')->toArray();
                $orare = Orar::where('medic_id', $request->medic_id)->get();
                $zileLibere = ZiLibera::where('medic_id', $request->medic_id)->get()->pluck('data')->toArray();
                // dd($zileLibere, $orare, $dataDeCautat->day);
                while ((count($zileDeLucru) < 5) && (Carbon::now()->diffInDays($dataDeCautat) < 1000)) {
                    if (
                        // „dataDeCautat” to not be in a free day
                        !in_array($dataDeCautat->isoFormat('YYYY-MM-DD'), $zileLibere)
                        // „dataDeCautat” to be in a day in wich that medic is working
                        && in_array($dataDeCautat->dayOfWeekIso, $orare->pluck('zi_din_saptamana')->toArray())
                        ) {

                        // We get the $orar for $dataDeCautat
                        $orar = $orare->where('zi_din_saptamana', $dataDeCautat->dayOfWeekIso);

                        $zideLucruNoua = [];
                        $zideLucruNoua['data'] = $dataDeCautat->isoFormat('YYYY-MM-DD');
                        $zideLucruNoua['de_la'] = $orar->first()->de_la;
                        $zideLucruNoua['pana_la'] = $orar->first()->pana_la;

                        array_push($zileDeLucru, $zideLucruNoua);
                    }
                    $dataDeCautat = Carbon::parse($dataDeCautat)->addDay();
                }

                $programari = $programariQuery
                    ->when($request->data, function ($query) use ($zileDeLucru) {
                        // $dataDeCautat = Carbon::parse($data);
                        // dd($zileDeLucru);
                        return $query
                            // ->whereDate('data', '>=', $dataDeCautat->startOfWeek())
                            // ->whereDate('data', '<=', $dataDeCautat->endOfWeek())
                            ->whereIn('data', array_column($zileDeLucru, 'data'))
                            ->orderBy('de_la');
                    })
                    ->get();
            } else {
                $programari = [];
            }
        }

        // dd($programari);
        $specializariSiMedici = Specializare::with('medici:id,specializare_id,nume')->select('id', 'denumire')->get();
        $pacienti = Pacient::with('localitate')->select('id', 'nume', 'prenume')->get();

        return view('programari.index', compact('request', 'programari', 'tipAfisare', 'specializariSiMedici', 'pacienti', 'zileDeLucru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->session()->get('programareReturnUrl') ?? $request->session()->put('programareReturnUrl', url()->previous());

        $programare = new Programare;
        $programare->specializare_id = $request->specializare_id;
        $programare->medic_id = $request->medic_id;
        $programare->data = $request->data;
        $programare->de_la = $request->de_la;

        // If it was added a „pacient” from "programare", it will came back in "programare" and it will fill out back the form
        $programare->fill($request->session()->pull('programareRequest', []));

        $specializariSiMedici = Specializare::with('medici:id,specializare_id,nume', 'medici.servicii:id,medic_id,nume,durata,pret')->select('id', 'denumire')->get();
        $cabinete = Cabinet::select('id', 'nume')->get();
        $pacienti = Pacient::with('localitate')->select('id', 'nume', 'prenume', 'telefon', 'localitate_id')->get();

        return view('programari.create', compact('programare', 'specializariSiMedici', 'cabinete', 'pacienti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $programare = Programare::create($this->validateRequest($request));

        return redirect($request->session()->get('programareReturnUrl') ?? ('/programari'))->with('status', 'Programarea pentru pacientul „' . ($programare->pacient->nume ?? '') . ' ' . ($programare->pacient->prenume ?? '')  . '” a fost adăugată cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Programare  $programare
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Programare $programare)
    {
        $request->session()->get('programareReturnUrl') ?? $request->session()->put('programareReturnUrl', url()->previous());

        return view('programari.show', compact('programare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Programare  $programare
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Programare $programare)
    {
        $request->session()->get('programareReturnUrl') ?? $request->session()->put('programareReturnUrl', url()->previous());

        // If it was added a „pacient” from "programare", it will came back in "programare" and it will fill out back the form
        $programare->fill($request->session()->pull('programareRequest', []));

        $specializariSiMedici = Specializare::with('medici:id,specializare_id,nume')->select('id', 'denumire')->get();
        $cabinete = Cabinet::select('id', 'nume')->get();
        $pacienti = Pacient::with('localitate')->select('id', 'nume', 'prenume', 'telefon', 'localitate_id')->get();

        return view('programari.edit', compact('programare', 'specializariSiMedici', 'cabinete', 'pacienti'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Programare  $programare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programare $programare)
    {
        $programare->update($this->validateRequest($request));

        return redirect($request->session()->get('programareReturnUrl') ?? ('/programari'))->with('status', 'Programarea pentru pacientul „' . ($programare->pacient->nume ?? '') . ' ' . ($programare->pacient->prenume ?? '')  . '” a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Programare  $programare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Programare $programare)
    {
        $programare->delete();

        return back()->with('status', 'Programarea pentru pacientul „' . ($programare->pacient->nume ?? '') . ' ' . ($programare->pacient->prenume ?? '')  . '” a fost ștearsă cu succes!');
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
                'specializare_id' => '',
                'medic_id' => '',
                'cabinet_id' => '',
                'data' => '',
                'de_la' => '',
                'pana_la' => '',
                'pacient_id' => 'required',
                'notita' => 'nullable|max:255',
                'observatii' => 'nullable|max:2000',
            ],
            [
            ]
        );
    }

    public function programareAdaugaResursa(Request $request, $resursa = null)
    {
        $request->session()->put('programareRequest', $request->all());

        switch($resursa){
            case 'pacient':
                $request->session()->put('pacientReturnUrl', url()->previous());
                return redirect('/pacienti/adauga');
                break;
        }

    }
}
