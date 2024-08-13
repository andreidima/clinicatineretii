@csrf

<script type="application/javascript">
    specializariSiMedici =  {!! json_encode($specializariSiMedici ?? []) !!}
    specializareIdVechi = {!! json_encode(old('specializare_id', ($programare->specializare_id ?? "")) ?? "") !!}
    medicIdVechi = {!! json_encode(old('medic_id', ($programare->medic_id ?? "")) ?? "") !!}

    cabinete =  {!! json_encode($cabinete ?? []) !!}
    cabinetIdVechi = {!! json_encode(old('cabinet_id', ($programare->cabinet_id ?? "")) ?? "") !!}

    pacienti = {!! json_encode($pacienti) !!}
    pacientIdVechi = {!! json_encode(old('pacient_id', ($programare->pacient_id ?? "")) ?? "") !!}

    de_la = {!! json_encode(old('de_la', ($programare->de_la ?? "")) ?? "") !!}
    pana_la = {!! json_encode(old('pana_la', ($programare->pana_la ?? "")) ?? "") !!}
</script>

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px" id="programareForm">
    <div class="col-lg-12 px-4 py-2 mb-0 mx-auto">
        <div class="row mb-4 pt-2 rounded-3" style="border:1px solid #e9ecef; border-left:0.25rem darkcyan solid; background-color:rgb(241, 250, 250)">
            <div class="col-lg-4 mb-4" style="position:relative;" v-click-out="() => specializariListaAutocomplete = ''">
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
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="specializare_id" class="input-group-text text-danger" id="specializare_denumire" v-on:click="specializare_id = null; specializare_denumire = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
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
                <small v-if="!specializare_id" class="ps-3">* Selectați o specializare</small>
                <small v-else class="ps-3 text-success">* Ați selectat o specializare</small>
            </div>
            <div class="col-lg-4 mb-4" style="position:relative;" v-click-out="() => mediciListaAutocomplete = ''">
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
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="medic_id" class="input-group-text text-danger" id="medic_nume" v-on:click="medic_id = null; medic_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
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
                <small v-if="!medic_id" class="ps-3">* Selectați un medic</small>
                <small v-else class="ps-3 text-success">* Ați selectat un medic</small>
            </div>
            <div class="col-lg-4 mb-4" style="position:relative;" v-click-out="() => cabineteListaAutocomplete = ''">
                <label for="cabinet_id" class="mb-0 ps-3">Cabinet</label>
                <input
                    type="hidden"
                    v-model="cabinet_id"
                    name="cabinet_id">
                <div v-on:focus="autocompleteCabinete();" class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="!cabinet_id" class="input-group-text" id="cabinet_nume">?</span>
                        <span v-if="cabinet_id" class="input-group-text bg-success text-white" id="cabinet_nume"><i class="fa-solid fa-check"></i></span>
                    </div>
                    <input
                        type="text"
                        v-model="cabinet_nume"
                        v-on:focus="autocompleteCabinete();"
                        v-on:keyup="autocompleteCabinete(); this.cabinet_id = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('cabinet_nume') ? 'is-invalid' : '' }}"
                        name="cabinet_nume"
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="cabinet_nume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="cabinet_id" class="input-group-text text-danger" id="cabinet_nume" v-on:click="cabinet_id = null; cabinet_nume = '';"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                </div>
                <div v-cloak v-if="cabineteListaAutocomplete && cabineteListaAutocomplete.length" class="panel-footer">
                    <div class="list-group" style="max-height: 130px; overflow:auto;">
                        <button class="list-group-item list-group-item list-group-item-action py-0"
                            v-for="cabinet in cabineteListaAutocomplete"
                            v-on:click="
                                cabinet_id = cabinet.id;
                                cabinet_nume = cabinet.nume;

                                cabineteListaAutocomplete = ''
                            ">
                                @{{ cabinet.nume }}
                        </button>
                    </div>
                </div>
                <small v-if="!cabinet_id" class="ps-3">* Selectați un cabinet</small>
                <small v-else class="ps-3 text-success">* Ați selectat un cabinet</small>
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3 justify-content-center" style="border:1px solid #e9ecef; border-left:0.25rem #e66800 solid; background-color:#fff9f5">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="mb-0 ps-3">Servicii disponibile:</label>
                    </div>
                    <div v-if="medic_id" class="col-lg-12">
                        <div v-for="serviciu in medici[0].servicii" class="d-flex align-items-center">
                            <span class="me-1">
                                @{{ serviciu.nume }} / Durata: @{{ serviciu.durata.substr(0, 5) }} / Preț: @{{ serviciu.pret }} lei
                            </span>
                            {{-- <button type="button" class="btn btn-sm p-0 btn-success" @click="adaugaServiciuLaProgramare(serviciu.id)">Adaugă</button> --}}
                            <button type="button" class="btn btn-sm py-0 btn-success" @click="serviciiAdaugateLaProgramare.push(serviciu)">Adaugă</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="mb-0 ps-3">Servicii adăugate la programare:</label>
                    </div>
                    <div v-if="medic_id" class="col-lg-12">
                        <div v-for="(serviciu, index) in serviciiAdaugateLaProgramare" class="rounded-1 px-1 mb-1 d-flex align-items-center" style="background-color:rgb(154, 255, 203); width: fit-content;">
                            <span class="me-1">
                                @{{ serviciu.nume }} / Durata: @{{ serviciu.durata.substr(0, 5) }} / Preț: @{{ serviciu.pret }} lei
                            </span>
                            {{-- <button type="button" class="btn btn-sm p-0 btn-danger" @click="stergeServiciuDeLaProgramare(serviciu.id)">Șterge</button> --}}
                            <button type="button" class="btn btn-sm py-0 btn-danger" @click="serviciiAdaugateLaProgramare.splice(index,1)">Șterge</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3 justify-content-center" style="border:1px solid #e9ecef; border-left:0.25rem darkcyan solid; background-color:rgb(241, 250, 250)">
            <div class="col-lg-2 mb-4">
                <label for="data" class="mb-0 ps-3">Data</label>
                <vue-datepicker-next
                    data-veche="{{ old('data', $programare->data) }}"
                    nume-camp-db="data"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD.MM.YYYY"
                    :latime="{ width: '125px' }"
                    {{-- @dataprogramare="dataProgramareTrimisa" --}}
                ></vue-datepicker-next>
            </div>
            {{-- <div class="col-lg-2 mb-4">
                <label for="orar_id" class="mb-0 ps-3">Ora:</label>
                <select class="form-select bg-white rounded-3 {{ $errors->has('orar_id') ? 'is-invalid' : '' }}"
                    name="orar_id"
                    v-model="orar_id"
                    >
                    <option selected></option>
                    <option
                        v-for='orar in orare'
                        :value='orar.id'
                        >
                            @{{orar.de_la.substring(0, 5)}} - @{{orar.pana_la.substring(0, 5)}}
                    </option>
                </select>
            </div> --}}
            <div class="col-lg-2 mb-4 text-center">
                <label for="de_la" class="mb-0 ps-0">De la</label>
                <vue-datepicker-next
                    data-veche="{{ old('de_la', $programare->de_la) }}"
                    nume-camp-db="de_la"
                    tip="time"
                    value-type="HH:mm"
                    format="HH:mm"
                    :latime="{ width: '80px' }"
                    v-model="de_la"
                ></vue-datepicker-next>
            </div>
            <div class="col-lg-2 mb-4 text-center justify-content-center" style="text-align: center">
                <label for="pana_la" class="mb-0 ps-0">Până la</label>
                {{-- <vue-datepicker-next
                    data-veche="{{ old('pana_la', $programare->pana_la) }}"
                    nume-camp-db="pana_la"
                    tip="time"
                    value-type="HH:mm"
                    format="HH:mm"
                    :latime="{ width: '80px' }"
                ></vue-datepicker-next> --}}
                <input type="text"
                    class="form-control bg-white rounded-3 mx-auto {{ $errors->has('pacient_nume') ? 'is-invalid' : '' }}"
                    style="width: 65px"
                    name="pana_la"
                    v-model="pana_la"
                    >
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3" style="border:1px solid #e9ecef; border-left:0.25rem #e66800 solid; background-color:#fff9f5">
            <div class="col-lg-4 mb-4" style="position:relative;" v-click-out="() => pacientiListaAutocomplete = ''">
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
                    <div class="input-group-prepend d-flex align-items-center">
                        <span v-if="pacient_id" class="input-group-text text-danger" id="pacient_nume" v-on:click="pacient_id = null; pacient_nume = ''; pacient_telefon=''; pacient_localitate=''"><i class="fa-solid fa-xmark"></i></span>
                    </div>
                    <div class="input-group-prepend ms-2 d-flex align-items-center">
                        <button type="submit" ref="submit" formaction="/programari/adauga-resursa/pacient" class="btn btn-success text-white rounded-3 py-0 px-2"
                            style="font-size: 30px; line-height: 1.2;" title="Adaugă pacient nou">+</button>
                    </div>
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
                <small v-if="!pacient_id" class="ps-3">* Selectați un pacient</small>
                <small v-else class="ps-3 text-success">* Ați selectat un pacient</small>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="telefon" class="mb-0 ps-3">Telefon</label>
                <input
                    type="text"
                    class="form-control rounded-3 {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                    name="telefon"
                    placeholder=""
                    v-model="pacient_telefon"
                    disabled>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="localitate" class="mb-0 ps-3">Localitate</label>
                <input
                    type="text"
                    class="form-control rounded-3 {{ $errors->has('localitate') ? 'is-invalid' : '' }}"
                    name="localitate"
                    placeholder=""
                    v-model="pacient_localitate"
                    disabled>
            </div>
        </div>
        <div class="row mb-4 pt-2 rounded-3 justify-content-center" style="border:1px solid #e9ecef; border-left:0.25rem darkcyan solid; background-color:rgb(241, 250, 250)">
            <div class="col-lg-6 mb-4">
                <label for="notita" class="mb-0 ps-3">Notiță</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('notita') ? 'is-invalid' : '' }}"
                    name="notita"
                    placeholder=""
                    value="{{ old('notita', $programare->notita) }}">
            </div>
            <div class="col-lg-12 mb-4">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="3">{{ old('observatii', $programare->observatii) }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-0 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('programareReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
