@extends ('layouts.app')

@php
    use \Carbon\Carbon;
@endphp

@section('content')
<div class="mx-3 px-3 card mx-auto" style="border-radius: 40px 40px 40px 40px;">
    <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
        <div class="col-lg-3">
            <span class="badge culoare1 fs-5">
                <i class="fa-solid fa-person-booth me-1"></i>Cabinete
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
                <i class="fas fa-plus-square text-white me-1"></i>Adaugă cabinet
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
                        <th class="culoare2 text-white">Descriere</th>
                        <th class="culoare2 text-white">Observații</th>
                        <th class="culoare2 text-white text-end">Acțiuni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cabinete as $cabinet)
                        <tr>
                            <td align="">
                                {{ ($cabinete ->currentpage()-1) * $cabinete ->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="">
                                {{ $cabinet->nume }}
                            </td>
                            <td class="">
                                {{ $cabinet->descriere }}
                            </td>
                            <td class="">
                                {{ $cabinet->observatii }}
                            </td>
                            <td class="">
                                <div class="text-end">
                                    <a href="{{ $cabinet->path() }}" class="flex me-1">
                                        <span class="badge bg-success">Vizualizează</span></a>
                                    <a href="{{ $cabinet->path() }}/modifica" class="flex me-1">
                                        <span class="badge bg-primary">Modifică</span></a>
                                    <a href="#"
                                        data-bs-toggle="modal"
                                        data-bs-target="#stergeCabinet{{ $cabinet->id }}"
                                        title="Șterge cabinet"
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
                    {{$cabinete->appends(Request::except('page'))->links()}}
                </ul>
            </nav>
    </div>
</div>

{{-- Modals to delete cabinets --}}
@foreach ($cabinete as $cabinet)
    <div class="modal fade text-dark" id="stergeCabinet{{ $cabinet->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="exampleModalLabel">Cabinet: <b>{{ $cabinet->nume }}</b></h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align:left;">
                Ești sigur ca vrei să ștergi cabinetul?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                <form method="POST" action="{{ $cabinet->path() }}">
                    @method('DELETE')
                    @csrf
                    <button
                        type="submit"
                        class="btn btn-danger text-white"
                        >
                        Șterge cabinetul
                    </button>
                </form>

            </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
