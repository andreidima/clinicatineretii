@csrf

@php
    use \Carbon\Carbon;
@endphp

<script type="application/javascript">
    judete =  {!! json_encode($judete ?? []) !!}
    localitati =  {!! json_encode($localitati ?? []) !!}

    judetNastereIdVechi = {!! json_encode(old('judet_nastere', ($pacient->judet_nastere_id ?? "")) ?? "") !!}
    judetIdVechi = {!! json_encode(old('judet_id', ($pacient->localitate->judet_id ?? "")) ?? "") !!}
    localitateIdVechi = {!! json_encode(old('localitate_id', ($pacient->localitate_id ?? "")) ?? "") !!}
</script>

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px" id="pacientForm">
    <div class="col-lg-12 px-4 py-2 mb-0">
        <div class="row mb-4 pt-2 rounded-3" style="border:1px solid #e9ecef; border-left:0.25rem darkcyan solid; background-color:rgb(241, 250, 250)">
            <div class="col-lg-3 mb-4">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $pacient->nume) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-4">
                <label for="prenume" class="mb-0 ps-3">Prenume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('prenume') ? 'is-invalid' : '' }}"
                    name="prenume"
                    placeholder=""
                    value="{{ old('prenume', $pacient->prenume) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-4">
                <label for="cnp" class="mb-0 ps-3">CNP</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('cnp') ? 'is-invalid' : '' }}"
                    name="cnp"
                    placeholder=""
                    value="{{ old('cnp', $pacient->cnp) }}">
            </div>
            <div class="col-lg-2 mb-4">
                <div class="text-center">
                    <label class="mb-0 ps-3">Sex</label>
                    <div class="d-flex py-1 justify-content-center">
                        <div class="form-check me-4">
                            <input class="form-check-input" type="radio" value="1" name="sex" id="sex_da"
                                {{ old('sex', $pacient->sex) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sex_da">M</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="sex" id="sex_nu"
                                {{ old('sex', $pacient->sex) == '2' ? 'checked' : '' }}>
                            <label class="form-check-label" for="sex_nu">F</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-4" style="position:relative;" v-click-out="() => judeteNastereListaAutocomplete = ''">
                <label for="judetNastere_nume" class="mb-0 ps-3">Județul nașterii</label>
                <input
                    type="hidden"
                    v-model="judetNastere_id"
                    name="judet_nastere_id">
                <div v-on:focus="autocompleteJudeteNastere();" class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="!judetNastere_id" class="input-group-text" id="judetNastere_nume">?</span>
                        <span v-if="judetNastere_id" class="input-group-text bg-success text-white" id="judetNastere_nume"><i class="fa-solid fa-check"></i></span>
                    </div>
                    <input
                        type="text"
                        v-model="judetNastere_nume"
                        v-on:focus="autocompleteJudeteNastere();"
                        v-on:keyup="autocompleteJudeteNastere(); this.judetNastere_id = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('judet_nastere') ? 'is-invalid' : '' }}"
                        name="judetNastere_nume"
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="judetNastere_nume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="judetNastere_id" class="input-group-text text-danger" id="judetNastere_nume" v-on:click="judetNastere_id = null; judetNastere_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                </div>
                <div v-cloak v-if="judeteNastereListaAutocomplete && judeteNastereListaAutocomplete.length" class="panel-footer">
                    <div class="list-group" style="max-height: 130px; overflow:auto;">
                        <button class="list-group-item list-group-item list-group-item-action py-0"
                            v-for="judet in judeteNastereListaAutocomplete"
                            v-on:click="
                                judetNastere_id = judet.id;
                                judetNastere_nume = judet.nume;

                                judeteNastereListaAutocomplete = ''
                            ">
                                @{{ judet.nume }}
                        </button>
                    </div>
                </div>
                <small v-if="!judetNastere_id" class="ps-3">* Selectați un județ</small>
                <small v-else class="ps-3 text-success">* Ați selectat un județ</small>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="loc_nastere" class="mb-0 ps-3">Locul nașterii</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('loc_nastere') ? 'is-invalid' : '' }}"
                    name="loc_nastere"
                    placeholder=""
                    value="{{ old('loc_nastere', $pacient->loc_nastere) }}">
            </div>
            <div class="col-lg-2 mb-4">
                <label for="data" class="mb-0 ps-3"><small>Data naștere</small></label>
                <vue-datepicker-next
                    data-veche="{{ old('data_nastere', $pacient->data_nastere) }}"
                    nume-camp-db="data_nastere"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD.MM.YYYY"
                    :latime="{ width: '125px' }"
                ></vue-datepicker-next>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="tata" class="mb-0 ps-3">Tata</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('tata') ? 'is-invalid' : '' }}"
                    name="tata"
                    placeholder=""
                    value="{{ old('tata', $pacient->tata) }}">
            </div>
            <div class="col-lg-2 mb-4">
                <label for="mama" class="mb-0 ps-3">Mama</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('mama') ? 'is-invalid' : '' }}"
                    name="mama"
                    placeholder=""
                    value="{{ old('mama', $pacient->mama) }}">
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3 align-items-end" style="border:1px solid #e9ecef; border-left:0.25rem #e66800 solid; background-color:#fff9f5">
            <div class="col-lg-4 mb-4">
                <label for="functia_med_mun" class="mb-0 ps-3">Funcția Med. Mun.</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('functia_med_mun') ? 'is-invalid' : '' }}"
                    name="functia_med_mun"
                    placeholder=""
                    value="{{ old('functia_med_mun', $pacient->functia_med_mun) }}">
            </div>
            <div class="col-lg-4 mb-4">
                <label for="functie_principala" class="mb-0 ps-3">Funcție Principală</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('functie_principala') ? 'is-invalid' : '' }}"
                    name="functie_principala"
                    placeholder=""
                    value="{{ old('functie_principala', $pacient->functie_principala) }}">
            </div>
            <div class="col-lg-4 mb-4">
                <label for="formare_scolara" class="mb-0 ps-3">Formare Școlară</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('formare_scolara') ? 'is-invalid' : '' }}"
                    name="formare_scolara"
                    placeholder=""
                    value="{{ old('formare_scolara', $pacient->formare_scolara) }}">
            </div>
            <div class="col-lg-4 mb-4">
                <label for="loc_munca" class="mb-0 ps-3">Loc Muncă</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('loc_munca') ? 'is-invalid' : '' }}"
                    name="loc_munca"
                    placeholder=""
                    value="{{ old('loc_munca', $pacient->loc_munca) }}">
            </div>
            <div class="col-lg-4 mb-4">
                <label for="forma_contract_data_angajare" class="mb-0 ps-3">Forma Contr./ Data Angaj.</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('forma_contract_data_angajare') ? 'is-invalid' : '' }}"
                    name="forma_contract_data_angajare"
                    placeholder=""
                    value="{{ old('forma_contract_data_angajare', $pacient->forma_contract_data_angajare) }}">
            </div>
            <div class="col-lg-4 mb-4">
                <label for="ocupatie" class="mb-0 ps-3">Ocupația</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('ocupatie') ? 'is-invalid' : '' }}"
                    name="ocupatie"
                    placeholder=""
                    value="{{ old('ocupatie', $pacient->ocupatie) }}">
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3" style="border:1px solid #e9ecef; border-left:0.25rem darkcyan solid; background-color:rgb(241, 250, 250)">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        <label for="telefon" class="mb-0 ps-3">Telefon</label>
                        <input
                            type="text"
                            class="form-control bg-white rounded-3 {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                            name="telefon"
                            placeholder=""
                            value="{{ old('telefon', $pacient->telefon) }}">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <label for="email" class="mb-0 ps-3">Email</label>
                        <input
                            type="text"
                            class="form-control bg-white rounded-3 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            name="email"
                            placeholder=""
                            value="{{ old('email', $pacient->email) }}">
                    </div>
                    <div class="col-lg-3 mb-4 d-block d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="hidden" name="acceptare_comunicare" value="0" />
                            <input class="form-check-input" type="checkbox" value="1" name="acceptare_comunicare" id="acceptare_comunicare"
                                {{ old('acceptare_comunicare', $pacient->acceptare_comunicare) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="acceptare_comunicare">Acceptă comunicarea</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-4" style="position:relative;" v-click-out="() => judeteListaAutocomplete = ''">
                <label for="judet_id" class="mb-0 ps-3">Județ</label>
                <input
                    type="hidden"
                    v-model="judet_id"
                    name="judet_id">
                <div v-on:focus="autocompleteJudete();" class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="!judet_id" class="input-group-text" id="judet_nume">?</span>
                        <span v-if="judet_id" class="input-group-text bg-success text-white" id="judet_nume"><i class="fa-solid fa-check"></i></span>
                    </div>
                    <input
                        type="text"
                        v-model="judet_nume"
                        v-on:focus="autocompleteJudete();"
                        v-on:keyup="autocompleteJudete(); this.judet_id = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('judet_nume') ? 'is-invalid' : '' }}"
                        name="judet_nume"
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="judet_nume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="judet_id" class="input-group-text text-danger" id="judet_nume" v-on:click="judet_id = null; judet_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                </div>
                <div v-cloak v-if="judeteListaAutocomplete && judeteListaAutocomplete.length" class="panel-footer">
                    <div class="list-group" style="max-height: 130px; overflow:auto;">
                        <button class="list-group-item list-group-item list-group-item-action py-0"
                            v-for="judet in judeteListaAutocomplete"
                            v-on:click="
                                judet_id = judet.id;
                                judet_nume = judet.nume;

                                judeteListaAutocomplete = ''
                            ">
                                @{{ judet.nume }}
                        </button>
                    </div>
                </div>
                <small v-if="!judet_id" class="ps-3">* Selectați un județ</small>
                <small v-else class="ps-3 text-success">* Ați selectat un județ</small>
            </div>
            <div class="col-lg-3 mb-4" style="position:relative;" v-click-out="() => localitatiListaAutocomplete = ''">
                <label for="localitate_id" class="mb-0 ps-3">Localitate</label>
                <input
                    type="hidden"
                    v-model="localitate_id"
                    name="localitate_id">
                <div v-on:focus="autocompleteLocalitati();" class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="!localitate_id" class="input-group-text" id="localitate_nume">?</span>
                        <span v-if="localitate_id" class="input-group-text bg-success text-white" id="localitate_nume"><i class="fa-solid fa-check"></i></span>
                    </div>
                    <input
                        type="text"
                        v-model="localitate_nume"
                        v-on:focus="autocompleteLocalitati();"
                        v-on:keyup="autocompleteLocalitati(); this.localitate_id = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('localitate_nume') ? 'is-invalid' : '' }}"
                        name="localitate_nume"
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="localitate_nume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="localitate_id" class="input-group-text text-danger" id="localitate_nume" v-on:click="localitate_id = null; localitate_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                </div>
                <div v-cloak v-if="localitatiListaAutocomplete && localitatiListaAutocomplete.length" class="panel-footer">
                    <div class="list-group" style="max-height: 130px; overflow:auto;">
                        <button class="list-group-item list-group-item list-group-item-action py-0"
                            v-for="localitate in localitatiListaAutocomplete"
                            v-on:click="
                                localitate_id = localitate.id;
                                localitate_nume = localitate.nume;

                                localitatiListaAutocomplete = ''
                            ">
                                @{{ localitate.nume }}
                        </button>
                    </div>
                </div>
                <small v-if="!localitate_id" class="ps-3">* Selectați o localitate</small>
                <small v-else class="ps-3 text-success">* Ați selectat o localitate</small>
            </div>
            <div class="col-lg-6 mb-4">
                <label for="adresa" class="mb-0 ps-3">Adresa</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('adresa') ? 'is-invalid' : '' }}"
                    name="adresa"
                    placeholder=""
                    value="{{ old('adresa', $pacient->adresa) }}">
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3" style="border:1px solid #e9ecef; border-left:0.25rem #e66800 solid; background-color:#fff9f5">
            <div class="col-lg-2 mb-4">
                <label for="act_identitate_tip" class="mb-0 ps-xxl-3"><small>Act identitate</small></label>
                <select class="form-select bg-white rounded-3 {{ $errors->has('act_identitate_tip') ? 'is-invalid' : '' }}"
                    name="act_identitate_tip">
                    <option selected></option>
                    <option value="Carte de identitate" {{ old('act_identitate_tip', $pacient->act_identitate_tip ?? '') == "Carte de identitate" ? 'selected' : '' }}>Carte de identitate</option>
                    <option value="Pașaport" {{ old('act_identitate_tip', $pacient->act_identitate_tip ?? '') == "Pașaport" ? 'selected' : '' }}>Pașaport</option>
                </select>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="act_indentitate_serie" class="mb-0 ps-xxl-3">Serie</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('act_indentitate_serie') ? 'is-invalid' : '' }}"
                    name="act_indentitate_serie"
                    placeholder=""
                    value="{{ old('act_indentitate_serie', $pacient->act_indentitate_serie) }}">
            </div>
            <div class="col-lg-2 mb-4">
                <label for="act_identitate_numar" class="mb-0 ps-xxl-3">Număr</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('act_identitate_numar') ? 'is-invalid' : '' }}"
                    name="act_identitate_numar"
                    placeholder=""
                    value="{{ old('act_identitate_numar', $pacient->act_identitate_numar) }}">
            </div>
            <div class="col-lg-2 mb-4">
                <label for="act_identitate_eliberat_de" class="mb-0 ps-xxl-3">Eliberat de</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('act_identitate_eliberat_de') ? 'is-invalid' : '' }}"
                    name="act_identitate_eliberat_de"
                    placeholder=""
                    value="{{ old('act_identitate_eliberat_de', $pacient->act_identitate_eliberat_de) }}">
            </div>
            <div class="col-lg-2 mb-4">
                <label for="act_identitate_eliberat_la" class="mb-0 ps-xxl-2"><small>Eliberat la</small></label>
                <vue-datepicker-next
                    data-veche="{{ old('act_identitate_eliberat_la', $pacient->act_identitate_eliberat_la) }}"
                    nume-camp-db="act_identitate_eliberat_la"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD.MM.YYYY"
                    :latime="{ width: '125px' }"
                ></vue-datepicker-next>
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3 justify-content-center" style="border:1px solid #e9ecef; border-left:0.25rem darkcyan solid; background-color:rgb(241, 250, 250)">
            <div class="col-lg-8 mb-4">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="3">{{ old('observatii', $pacient->observatii) }}</textarea>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-lg-12 mb-0 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('pacientReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
