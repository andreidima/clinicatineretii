@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="culoare2 border border-secondary p-2" style="border-radius: 40px 40px 0px 0px;">
                    <span class="badge text-light fs-5">
                        <i class="fa-solid fa-person-crane me-1"></i>Pacienți / {{ $pacient->nume }} {{ $pacient->prenume }}
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
                                    Nume
                                </td>
                                <td>
                                    {{ $pacient->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Prenume
                                </td>
                                <td>
                                    {{ $pacient->prenume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Cnp
                                </td>
                                <td>
                                    {{ $pacient->cnp }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Sex
                                </td>
                                <td>
                                    {{ $pacient->sex == 1 ? 'M' : 'F' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Județul nașterii
                                </td>
                                <td>
                                    {{ $pacient->judetNastere->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Locul nașterii
                                </td>
                                <td>
                                    {{ $pacient->loc_nastere }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Data nașterii
                                </td>
                                <td>
                                    {{ $pacient->data_nastere ? \Carbon\Carbon::parse($pacient->data_nastere)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Tata
                                </td>
                                <td>
                                    {{ $pacient->tata }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Mama
                                </td>
                                <td>
                                    {{ $pacient->mama }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Funcția Med. Mun.
                                </td>
                                <td>
                                    {{ $pacient->functia_med_mun }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Funcție Principală
                                </td>
                                <td>
                                    {{ $pacient->functie_principala }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Formare Școlară
                                </td>
                                <td>
                                    {{ $pacient->formare_scolara }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Loc Muncă
                                </td>
                                <td>
                                    {{ $pacient->loc_munca }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Forma Contr./ Data Angaj.
                                </td>
                                <td>
                                    {{ $pacient->forma_contract_data_angajare }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Ocupația
                                </td>
                                <td>
                                    {{ $pacient->ocupatie }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Telefon
                                </td>
                                <td>
                                    {{ $pacient->telefon }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Email
                                </td>
                                <td>
                                    {{ $pacient->email }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Acceptă comunicarea
                                </td>
                                <td>
                                    {{ $pacient->acceptare_comunicare == 1 ? 'DA' : 'NU' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Județ
                                </td>
                                <td>
                                    {{ $pacient->localitate->judet->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Localitate
                                </td>
                                <td>
                                    {{ $pacient->localitate->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Adresa
                                </td>
                                <td>
                                    {{ $pacient->adresa }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Act identitate
                                </td>
                                <td>
                                    {{ $pacient->act_identitate_tip }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Serie
                                </td>
                                <td>
                                    {{ $pacient->act_indentitate_serie }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Număr
                                </td>
                                <td>
                                    {{ $pacient->act_identitate_numar }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Eliberat de
                                </td>
                                <td>
                                    {{ $pacient->act_identitate_eliberat_de }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Eliberat la
                                </td>
                                <td>
                                    {{ $pacient->act_identitate_eliberat_la ? \Carbon\Carbon::parse($pacient->act_identitate_eliberat_la)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $pacient->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-secondary text-white rounded-3" href="{{ Session::get('pacientReturnUrl') }}">Înapoi</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
