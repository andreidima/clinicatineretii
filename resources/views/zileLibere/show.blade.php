@extends ('layouts.app')

@php
    use Carbon\Carbon;
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="culoare2 border border-secondary p-2" style="border-radius: 40px 40px 0px 0px;">
                    <span class="badge text-light fs-5">
                        <i class="fa-solid fa-clock me-1"></i>Orare
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
                                    {{ $orar->specializare->denumire ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Medic
                                </td>
                                <td>
                                    {{ $orar->medic->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Data
                                </td>
                                <td>
                                    {{ $orar->data ? Carbon::parse($orar->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Ora
                                </td>
                                <td>
                                    {{ $orar->de_la ? Carbon::parse($orar->de_la)->isoFormat('HH:mm') : '' }}
                                    -
                                    {{ $orar->pana_la ? Carbon::parse($orar->pana_la)->isoFormat('HH:mm') : '' }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-secondary text-white rounded-3" href="{{ Session::get('orarReturnUrl') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
