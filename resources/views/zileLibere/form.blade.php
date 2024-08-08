@csrf

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px" id="datePicker">
    <div class="col-lg-12 px-4 py-2 mb-0 mx-auto">
        <div class="row mb-0 justify-content-center">
            <div class="col-lg-6 mb-4">
                <label for="medic_id" class="mb-0 ps-3">Medic<span class="text-danger">*</span></label>
                <select class="form-select bg-white rounded-3 {{ $errors->has('medic_id') ? 'is-invalid' : '' }}" name="medic_id">
                    <option selected></option>
                    @foreach ($medici as $medic)
                        <option value="{{ $medic->id }}" {{ old('medic_id', $ziLibera->medic_id) == $medic->id ? 'selected' : '' }}>{{ $medic->nume }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 mb-4">
                <label for="data" class="mb-0 ps-3">Data<span class="text-danger">*</span></label>
                <vue-datepicker-next
                    data-veche="{{ old('data', $ziLibera->data ?? '') }}"
                    nume-camp-db="data"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD.MM.YYYY"
                    :latime="{ width: '125px' }"
                ></vue-datepicker-next>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-0 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('ziLiberaReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
