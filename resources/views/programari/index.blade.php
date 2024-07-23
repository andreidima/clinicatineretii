@extends ('layouts.app')

@php
    use \Carbon\Carbon;
@endphp

<script type="application/javascript">
    specializariSiMedici =  {!! json_encode($specializariSiMedici ?? []) !!}
    specializareIdVechi = {!! json_encode($request->specializare_id ?? '') !!}
    medicIdVechi = {!! json_encode($request->medic_id ?? '') !!}

    pacienti = {!! json_encode($pacienti) !!}
    pacientIdVechi = {!! json_encode($request->pacient_id ?? '') !!}
</script>

@section('content')
<div class="mx-3 px-3 card mx-auto" style="border-radius: 40px 40px 40px 40px;">
    <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
        <div class="col-lg-2">
            <span class="badge culoare1 fs-5">
                <i class="fa-solid fa-clock me-1"></i>Programări
            </span>
        </div>
        <div class="col-lg-8">
            <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
                @csrf
                <div class="row mb-1 custom-search-form justify-content-center" id="programareForm">
                    <div class="col-lg-3" style="position:relative;" v-click-out="() => specializariListaAutocomplete = ''">
                        <label for="specializare_id" class="mb-0 ps-3">Specializare</label>
                        <input
                            type="hidden"
                            v-model="specializare_id"
                            name="specializare_id">
                        <div v-on:focus="autocompleteSpecializari();" class="input-group">
                            <div class="input-group-prepend d-flex align-items-center">
                                <span v-if="!specializare_id" class="input-group-text" id="specializare_denumire">?</span>
                                <span v-if="specializare_id" class="input-group-text bg-success text-white" id="specializare_denumire"><i class="fa-solid fa-check"></i></span>
                            </div>
                            <input
                                type="text"
                                v-model="specializare_denumire"
                                v-on:focus="autocompleteSpecializari();"
                                v-on:keyup="autocompleteSpecializari(); this.specializare_id = '';"
                                class="form-control bg-white rounded-3 {{ $errors->has('specializare_denumire') ? 'is-invalid' : '' }}"
                                name="specializare_denumire"
                                placeholder=""
                                autocomplete="off"
                                aria-describedby="specializare_denumire"
                                required>
                        </div>
                        <div v-cloak v-if="specializariListaAutocomplete && specializariListaAutocomplete.length" class="panel-footer">
                            <div class="list-group" style="max-height: 130px; overflow:auto;">
                                <button class="list-group-item list-group-item list-group-item-action py-0"
                                    v-for="specializare in specializariListaAutocomplete"
                                    v-on:click="
                                        specializare_id = specializare.id;
                                        specializare_denumire = specializare.denumire;

                                        specializariListaAutocomplete = ''
                                    ">
                                        @{{ specializare.denumire }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3" style="position:relative;" v-click-out="() => mediciListaAutocomplete = ''">
                        <label for="medic_id" class="mb-0 ps-3">Medic</label>
                        <input
                            type="hidden"
                            v-model="medic_id"
                            name="medic_id">
                        <div v-on:focus="autocompleteMedici();" class="input-group">
                            <div class="input-group-prepend d-flex align-items-center">
                                <span v-if="!medic_id" class="input-group-text" id="medic_nume">?</span>
                                <span v-if="medic_id" class="input-group-text bg-success text-white" id="medic_nume"><i class="fa-solid fa-check"></i></span>
                            </div>
                            <input
                                type="text"
                                v-model="medic_nume"
                                v-on:focus="autocompleteMedici();"
                                v-on:keyup="autocompleteMedici(); this.medic_id = '';"
                                class="form-control bg-white rounded-3 {{ $errors->has('medic_nume') ? 'is-invalid' : '' }}"
                                name="medic_nume"
                                placeholder=""
                                autocomplete="off"
                                aria-describedby="medic_nume"
                                required>
                        </div>
                        <div v-cloak v-if="mediciListaAutocomplete && mediciListaAutocomplete.length" class="panel-footer">
                            <div class="list-group" style="max-height: 130px; overflow:auto;">
                                <button class="list-group-item list-group-item list-group-item-action py-0"
                                    v-for="medic in mediciListaAutocomplete"
                                    v-on:click="
                                        medic_id = medic.id;
                                        medic_nume = medic.nume;

                                        mediciListaAutocomplete = ''
                                    ">
                                        @{{ medic.nume }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @if ($tipAfisare == 'administrare')
                        <div class="col-lg-3" style="position:relative;" v-click-out="() => pacientiListaAutocomplete = ''">
                            <label for="pacient_id" class="mb-0 ps-3">Pacient<span class="text-danger">*</span></label>
                            <input
                                type="hidden"
                                v-model="pacient_id"
                                name="pacient_id">

                            <div v-on:focus="autocompletePacienti();" class="input-group">
                                <div class="input-group-prepend d-flex align-items-center">
                                    <span v-if="!pacient_id" class="input-group-text" id="pacient_nume">?</span>
                                    <span v-if="pacient_id" class="input-group-text bg-success text-white" id="pacient_nume"><i class="fa-solid fa-check"></i></span>
                                </div>
                                <input
                                    type="text"
                                    v-model="pacient_nume"
                                    v-on:focus="autocompletePacienti();"
                                    v-on:keyup="autocompletePacienti(); this.pacient_id = '';"
                                    class="form-control bg-white rounded-3 {{ $errors->has('pacient_nume') ? 'is-invalid' : '' }}"
                                    name="pacient_nume"
                                    placeholder=""
                                    autocomplete="off"
                                    aria-describedby="pacient_nume"
                                    required>
                            </div>
                            <div v-cloak v-if="pacientiListaAutocomplete && pacientiListaAutocomplete.length" class="panel-footer">
                                <div class="list-group" style="max-height: 130px; overflow:auto;">
                                    <button class="list-group-item list-group-item list-group-item-action py-0"
                                        v-for="pacient in pacientiListaAutocomplete"
                                        v-on:click="
                                            pacient_id = pacient.id;
                                            pacient_nume = pacient.nume + ' ' + pacient.prenume;
                                            {{-- pacient_data_nastere = new Date(pacient.data_nastere); pacient_data_nastere = pacient_data_nastere.toLocaleString('ro-RO', { dateStyle: 'short' }); --}}
                                            pacient_telefon = pacient.telefon;
                                            pacient_localitate = pacient.localitate ? pacient.localitate.nume : '';

                                            pacientiListaAutocomplete = ''
                                        ">
                                            @{{ pacient.nume }} @{{ pacient.prenume }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-3 align-items-center">
                        <label for="data" class="mb-0 ps-5">Data</label>
                        <div class="d-flex">
                            @if ($tipAfisare == 'saptamanal')
                                <button class="btn btn-sm btn-primary text-white border border-light rounded-3" type="submit" name="action" value="previousWeek">
                                    <i class="fa-solid fa-angles-left"></i>
                                </button>
                            @endif
                            <vue-datepicker-next
                                data-veche="{{ $request->data }}"
                                nume-camp-db="data"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD.MM.YYYY"
                                :latime="{ width: '125px' }"
                            ></vue-datepicker-next>
                            @if ($tipAfisare == 'saptamanal')
                                <button class="btn btn-sm btn-primary text-white border border-light rounded-3" type="submit" name="action" value="nextWeek">
                                    <i class="fa-solid fa-angles-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row custom-search-form justify-content-center">
                    <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                        <i class="fas fa-search text-white me-1"></i>Caută
                    </button>
                    <a class="btn btn-sm btn-secondary text-white col-md-4 border border-dark rounded-3" href="{{ url()->current() }}" role="button">
                        <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                    </a>
                </div>
            </form>
        </div>
        <div class="col-lg-2 text-end">
            <a class="btn btn-sm btn-success text-white border border-dark rounded-3 col-md-8" href="/programari/adauga" role="button">
                <i class="fas fa-plus-square text-white me-1"></i>Adaugă programare
            </a>
        </div>
    </div>

    <div class="card-body px-0 py-3">

        @include ('errors')

        @if ($tipAfisare == "administrare")
            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover">
                    <thead class="">
                        <tr class="" style="padding:2rem">
                            <th class="culoare2 text-white">#</th>
                            <th class="culoare2 text-white">Specializare</th>
                            <th class="culoare2 text-white">Medic</th>
                            <th class="culoare2 text-white">Cabinet</th>
                            <th class="culoare2 text-white">Pacient</th>
                            <th class="culoare2 text-white">Data</th>
                            <th class="culoare2 text-white">Ora</th>
                            <th class="culoare2 text-white text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programari as $programare)
                            <tr>
                                <td align="">
                                    {{ ($programari ->currentpage()-1) * $programari ->perpage() + $loop->index + 1 }}
                                </td>
                                <td class="">
                                    {{ $programare->specializare->denumire ?? ''}}
                                </td>
                                <td class="">
                                    {{ $programare->medic->nume ?? ''}}
                                </td>
                                <td class="">
                                    {{ $programare->cabinet->nume ?? ''}}
                                </td>
                                <td class="">
                                    {{ $programare->pacient->nume ?? ''}} {{ $programare->pacient->prenume ?? ''}}
                                </td>
                                <td class="">
                                    {{ $programare->data ? Carbon::parse($programare->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                                <td class="">
                                    {{ $programare->de_la ? Carbon::parse($programare->de_la)->isoFormat('HH:mm') : '' }}
                                    -
                                    {{ $programare->pana_la ? Carbon::parse($programare->pana_la)->isoFormat('HH:mm') : '' }}
                                </td>
                                <td class="">
                                    <div class="text-end">
                                        <a href="{{ $programare->path() }}" class="flex me-1">
                                            <span class="badge bg-success">Vizualizează</span></a>
                                        <a href="{{ $programare->path() }}/modifica" class="flex me-1">
                                            <span class="badge bg-primary">Modifică</span></a>
                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeProgramare{{ $programare->id }}"
                                            title="Șterge programare"
                                            >
                                            <span class="badge bg-danger">Șterge</span></a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$programari->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        @elseif ($tipAfisare == "saptamanal")
            @if ($request->specializare_id && $request->medic_id)
                <div class="table-responsive rounded mb-4"  style="max-height: 90vh">
                    <table class="table table-striped table-hover table-sm rounded table-bordered">
                        <thead class="rounded" style="position: sticky; top: 0px;">
                            <tr>
                                    <th class="culoare2 text-white" style="width:5%; min-width:50px;">
                                        Ora
                                    </th>
                                @for ($ziua = Carbon::parse($request->data)->startOfWeek(); $ziua->lessThan(Carbon::parse($request->data)->endOfWeek()->subDays(2)); $ziua->addDay())
                                    <th class="culoare2 text-white text-center" style="max-width:220px;">
                                        {{ ucfirst($ziua->dayName) }}
                                        <br>
                                        {{ $ziua->isoFormat('DD.MM') }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for ($ora = (Carbon::parse($programari->min('de_la'))->hour < 8 ? Carbon::parse($programari->min('de_la'))->hour : 8); $ora <= (Carbon::parse($programari->max('pana_la'))->hour > 18 ? Carbon::parse($programari->max('pana_la'))->hour : 18) ; $ora ++)
                                <tr class="">
                                    <th class="culoare2 text-white">
                                        {{ $ora }}:00
                                    </th>
                                    @for ($ziua = Carbon::parse($request->data)->startOfWeek(); $ziua->lessThan(Carbon::parse($request->data)->endOfWeek()->subDays(2)); $ziua->addDay())
                                    <td class="p-0 border border-2 border-dark" style="max-width:220px;">
                                        @php
                                            // Time range
                                            $startTime = Carbon::createFromTimeString($ora.':00:00');
                                            $endTime = Carbon::createFromTimeString(($ora+1).':00:00');

                                            // Filter collection
                                            $programariDinDataLaOra = $programari->where('data', $ziua->todatestring())
                                                ->filter(function ($item) use ($startTime, $endTime) {
                                                    $time = Carbon::parse($item['de_la'])->format('H:i:s');
                                                    return $time >= $startTime->format('H:i:s') && $time < $endTime->format('H:i:s');
                                                });
                                        @endphp

                                        @foreach ($programariDinDataLaOra as $programare)
                                            @if (!$loop->last)
                                                <div class="row p-0 m-0 border-bottom border-2 border-dark">
                                            @else
                                                <div class="row p-0 m-0">
                                            @endif
                                                    <div class="col-12 py-0 px-1 d-flex">
                                                        <div class="me-1">
                                                            <small class="px-1 text-white rounded-3" style="background-color:darkcyan;">
                                                                {{ $programare->de_la ? Carbon::parse($programare->de_la)->isoFormat('HH:mm') : '' }}-{{ $programare->pana_la ? Carbon::parse($programare->pana_la)->isoFormat('HH:mm') : '' }}
                                                            </small>
                                                            <br>
                                                        </div>
                                                        <div style="font-size:90%; line-height:1.2;">
                                                            {{ $programare->pacient->nume ?? '' }} {{ $programare->pacient->prenume ?? '' }}
                                                            @if ($programare->pacient->telefon ?? null)
                                                                <br>
                                                                {{ $programare->pacient->telefon ?? ''}}
                                                            @endif
                                                            @if ($programare->cabinet)
                                                                <br>
                                                                {{ $programare->cabinet->nume ?? ''}}
                                                            @endif
                                                            @if ($programare->notita)
                                                                <br>
                                                                {{ $programare->notita ?? ''}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-12 py-0 px-1 d-flex justify-content-end">
                                                        <div>
                                                            <a href="{{ $programare->path() }}" class="flex me-1">
                                                                {{-- <span class="badge bg-success">Vizualizează</span></a> --}}
                                                                <span class="badge text-success p-0"><i class="fa-solid fa-eye"></i></span></a>
                                                        </div>
                                                        <a href="{{ $programare->path() }}/modifica"
                                                            class="flex me-1"
                                                        >
                                                            <span class="badge text-primary p-0"><i class="fa-solid fa-pen-to-square"></i></span>
                                                        </a>
                                                        <div style="flex" class="">
                                                            <a
                                                                href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#stergeProgramare{{ $programare->id }}"
                                                                title="Șterge Programare"
                                                                >
                                                                <span class="badge text-danger p-0"><i class="fa-solid fa-trash-can"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            @else
                <div class=""  style="">
                    <p>
                        Pentru a încărca date, caută o specializare, un medic, și o zi din săptămâna dorită.
                    </p>
                </div>
            @endif
        @endif
    </div>
</div>

{{-- Modals to delete appointments --}}
@foreach ($programari as $programare)
    <div class="modal fade text-dark" id="stergeProgramare{{ $programare->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Programare: <b>{{ $programare->pacient->nume ?? '' }}</b></h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align:left;">
                Ești sigur ca vrei să ștergi programarea?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                <form method="POST" action="{{ $programare->path() }}">
                    @method('DELETE')
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-danger text-white"
                        >
                        Șterge programarea
                    </button>
                </form>

            </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
