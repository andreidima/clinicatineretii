@extends ('layouts.app')

@php
    use \Carbon\Carbon;
@endphp

@section('content')
<div class="mx-3 px-3 card mx-auto" style="border-radius: 40px 40px 40px 40px;">
    <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
        <div class="col-lg-3">
            <span class="badge culoare1 fs-5">
                <i class="fa-solid fa-user-doctor me-1"></i>Medici
            </span>
        </div>
        <div class="col-lg-6">
            <form class="needs-validation" novalidate method="GET" action="{{ url()->current() }}">
                @csrf
                <div class="row mb-1 custom-search-form justify-content-center">
                    <div class="col-lg-8">
                        <input type="text" class="form-control rounded-3" id="searchNume" name="searchNume" placeholder="Nume" value="{{ $searchNume }}">
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
        <div class="col-lg-3 text-end">
            <a class="btn btn-sm btn-success text-white border border-dark rounded-3 col-md-8" href="{{ url()->current() }}/adauga" role="button">
                <i class="fas fa-plus-square text-white me-1"></i>Adaugă medic
            </a>
        </div>
    </div>

    <div class="card-body px-0 py-3">

        @include ('errors')

        <div class="table-responsive rounded-3">
            <table class="table table-striped table-hover">
                <thead class="">
                    <tr class="" style="padding:2rem">
                        <th class="culoare2 text-white">#</th>
                        <th class="culoare2 text-white">Nume</th>
                        <th class="culoare2 text-white">Orar</th>
                        <th class="culoare2 text-white">Zile Libere</th>
                        <th class="culoare2 text-white text-end">Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medici as $medic)
                        <tr>
                            <td align="">
                                {{ ($medici ->currentpage()-1) * $medici ->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="">
                                {{ $medic->nume }}
                            </td>
                            <td class="">
                                @foreach ($medic->orare->sortBy('zi_din_saptamana') as $orar)
                                    {{ Carbon::now()->dayOfWeek($orar->zi_din_saptamana)->dayName }} = {{ Carbon::parse($orar->de_la)->isoFormat('HH:mm') }} - {{ Carbon::parse($orar->pana_la)->isoFormat('HH:mm') }}
                                    <a href="{{ $orar->path() }}/modifica">
                                        <span class="badge text-primary px-1 py-0" title="Modifică"><i class="fa-solid fa-pen-to-square"></i></span></a>
                                    <a href="#" title="Șterge orar"
                                        data-bs-toggle="modal"
                                        data-bs-target="#stergeOrar{{ $orar->id }}">
                                        <span class="badge text-danger px-1 py-0" title="Șterge"><i class="fa-solid fa-trash-can"></i></span></a>
                                    <br>
                                @endforeach
                                <a href="/specializare/{{ $medic->specializare_id }}/medic/{{ $medic->id }}/orare/adauga" class="flex me-1">
                                    <span class="badge text-success" title="Adaugă"><i class="fas fa-plus-square"></i></span></a>
                            </td>
                            <td class="">
                                @foreach ($medic->zileLibere->sortBy('data') as $ziLibera)
                                    {{ Carbon::parse($ziLibera->data)->isoFormat('DD.MM.YYYY') }}
                                    <a href="{{ $ziLibera->path() }}/modifica">
                                        <span class="badge text-primary px-1 py-0" title="Modifică"><i class="fa-solid fa-pen-to-square"></i></span></a>
                                    <a href="#" title="Șterge zi liberă"
                                        data-bs-toggle="modal"
                                        data-bs-target="#stergeZiLibera{{ $ziLibera->id }}">
                                        <span class="badge text-danger px-1 py-0" title="Șterge"><i class="fa-solid fa-trash-can"></i></span></a>
                                    <br>
                                @endforeach
                                <a href="/medici-zile-libere/medic/{{ $medic->id }}/zile-libere/adauga" class="flex me-1">
                                    <span class="badge text-success" title="Adaugă"><i class="fas fa-plus-square"></i></span></a>
                            </td>
                            <td class="">
                                <div class="text-end">
                                    <a href="{{ $medic->path() }}" class="flex me-1">
                                        <span class="badge bg-success">Vizualizează</span></a>
                                    <a href="{{ $medic->path() }}/modifica" class="flex me-1">
                                        <span class="badge bg-primary">Modifică</span></a>
                                    <a href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#stergeMedic{{ $medic->id }}"
                                        title="Șterge medic"
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
                    {{$medici->appends(Request::except('page'))->links()}}
                </ul>
            </nav>
    </div>
</div>

{{-- Modal to delete orare --}}
@foreach ($medici as $medic)
    @foreach ($medic->orare as $orar)
        <div class="modal fade text-dark" id="stergeOrar{{ $orar->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Orar: <b>{{ $orar->specializare->denumire ?? '' }} / {{ $orar->medic->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi orarul?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $orar->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge orarul
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

{{-- Modal to delete zileLibere --}}
@foreach ($medici as $medic)
    @foreach ($medic->zileLibere as $ziLibera)
        <div class="modal fade text-dark" id="stergeZiLibera{{ $ziLibera->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Zi liberă: <b>{{ $ziLibera->medic->nume ?? '' }} - {{ Carbon::parse($ziLibera->data)->isoFormat('DD.MM.YYYY') }} </b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi ziua liberă?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $ziLibera->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Ziua Liberă
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

{{-- Modal to delete medics --}}
@foreach ($medici as $medic)
    <div class="modal fade text-dark" id="stergeMedic{{ $medic->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Medic: <b>{{ $medic->nume }}</b></h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align:left;">
                Ești sigur ca vrei să ștergi medicul?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                <form method="POST" action="{{ $medic->path() }}">
                    @method('DELETE')
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-danger text-white"
                        >
                        Șterge medicul
                    </button>
                </form>

            </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
