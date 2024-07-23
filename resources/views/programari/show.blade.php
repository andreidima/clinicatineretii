@extends ('layouts.app')

@php
    use \Carbon\Carbon;
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="culoare2 border border-secondary p-2" style="border-radius: 40px 40px 0px 0px;">
                    <span class="badge text-light fs-5">
                        <i class="fa-solid fa-clock me-1"></i>Programări / {{ $programare->pacient->nume ?? ''}} {{ $programare->pacient->prenume ?? ''}}
                    </span>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-striped table-hover"
                        >
                            <tr>
                                <td class="pe-4">
                                    Specializare
                                </td>
                                <td>
                                    {{ $programare->specializare->denumire ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Medic
                                </td>
                                <td>
                                    {{ $programare->medic->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Cabinet
                                </td>
                                <td>
                                    {{ $programare->cabinet->nume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Pacient
                                </td>
                                <td>
                                    {{ $programare->pacient->nume ?? ''}} {{ $programare->pacient->prenume ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Data
                                </td>
                                <td>
                                    {{ $programare->data ? Carbon::parse($programare->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Ora
                                </td>
                                <td>
                                    {{ $programare->de_la ? Carbon::parse($programare->de_la)->isoFormat('HH:mm') : '' }}
                                    -
                                    {{ $programare->pana_la ? Carbon::parse($programare->pana_la)->isoFormat('HH:mm') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Notiță
                                </td>
                                <td>
                                    {{ $programare->notita }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $programare->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-secondary text-white rounded-3" href="{{ Session::get('programareReturnUrl') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
