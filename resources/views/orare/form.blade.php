@csrf

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px" id="datePicker">
    <div class="col-lg-12 px-4 py-2 mb-0 mx-auto">
        <div class="row mb-0 justify-content-center">
            <div class="col-lg-6 mb-4">
                <label for="specializare_id" class="mb-0 ps-3">Specializare<span class="text-danger">*</span></label>
                <select class="form-select bg-white rounded-3 {{ $errors->has('specializare_id') ? 'is-invalid' : '' }}" name="specializare_id">
                    <option selected></option>
                    @foreach ($specializari as $specializare)
                        <option value="{{ $specializare->id }}" {{ old('specializare_id', $orar->specializare_id) == $specializare->id ? 'selected' : '' }}>{{ $specializare->denumire }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 mb-4">
                <label for="medic_id" class="mb-0 ps-3">Medic<span class="text-danger">*</span></label>
                <select class="form-select bg-white rounded-3 {{ $errors->has('medic_id') ? 'is-invalid' : '' }}" name="medic_id">
                    <option selected></option>
                    @foreach ($medici as $medic)
                        <option value="{{ $medic->id }}" {{ old('medic_id', $orar->medic_id) == $medic->id ? 'selected' : '' }}>{{ $medic->nume }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="data" class="mb-0 ps-3"><small>Data</small></label>
                <vue-datepicker-next
                    data-veche="{{ old('data', $orar->data) }}"
                    nume-camp-db="data"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD.MM.YYYY"
                    :latime="{ width: '125px' }"
                ></vue-datepicker-next>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="de_la" class="mb-0 ps-3"><small>De la</small></label>
                <vue-datepicker-next
                    data-veche="{{ old('de_la', $orar->de_la) }}"
                    nume-camp-db="de_la"
                    tip="time"
                    value-type="HH:mm"
                    format="HH:mm"
                    :latime="{ width: '80px' }"
                ></vue-datepicker-next>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="pana_la" class="mb-0 ps-3"><small>Până la</small></label>
                <vue-datepicker-next
                    data-veche="{{ old('pana_la', $orar->pana_la) }}"
                    nume-camp-db="pana_la"
                    tip="time"
                    value-type="HH:mm"
                    format="HH:mm"
                    :latime="{ width: '80px' }"
                ></vue-datepicker-next>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-0 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('orarReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
