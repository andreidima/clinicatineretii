@csrf

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px">
    <div class="col-lg-12 px-4 py-2 mb-0 mx-auto">
        <div class="row mb-0 justify-content-center">
            <div class="col-lg-3 mb-4">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $medic->nume) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-4">
                <label for="specializare_id" class="mb-0 ps-3">Specializare<span class="text-danger">*</span></label>
                <select class="form-select bg-white rounded-3 {{ $errors->has('specializare_id') ? 'is-invalid' : '' }}" name="specializare_id">
                    <option selected></option>
                    @foreach ($specializari as $specializare)
                        <option value="{{ $specializare->id }}" {{ old('specializare_id', $medic->specializare_id) == $specializare->id ? 'selected' : '' }}>{{ $specializare->denumire }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 mb-4">
                <label for="telefon" class="mb-0 ps-3">Telefon</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('telefon') ? 'is-invalid' : '' }}"
                    name="telefon"
                    placeholder=""
                    value="{{ old('telefon', $medic->telefon) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-4">
                <label for="email" class="mb-0 ps-3">Email</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    name="email"
                    placeholder=""
                    value="{{ old('email', $medic->email) }}"
                    required>
            </div>
            {{-- <div class="col-lg-6 mb-4">
                <label for="zile_lucratoare_ale_saptamanii" class="mb-0 ps-3">Zile lucrătoare ale săptămânii</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('zile_lucratoare_ale_saptamanii') ? 'is-invalid' : '' }}"
                    name="zile_lucratoare_ale_saptamanii"
                    placeholder="Ex: 1, 2, 4"
                    value="{{ old('zile_lucratoare_ale_saptamanii', $medic->zile_lucratoare_ale_saptamanii) }}"
                    required>
                <small class="ps-3">* 1 luni, 2 marți, ..... 7 duminică</small>
            </div> --}}
            {{-- <div class="col-lg-6 mb-4">
                <label for="zile_indisponibile" class="form-label mb-0 ps-3">Zile indisponibile</label>
                <textarea class="form-control bg-white {{ $errors->has('zile_indisponibile') ? 'is-invalid' : '' }}"
                    name="zile_indisponibile" rows="2">{{ old('zile_indisponibile', $medic->zile_indisponibile) }}</textarea>
                <small class="ps-3">* 25.12.2024, 01.01.2025, .....</small>
            </div> --}}
            <div class="col-lg-6 mb-4">
                <label for="descriere" class="form-label mb-0 ps-3">Descriere</label>
                <textarea class="form-control bg-white {{ $errors->has('descriere') ? 'is-invalid' : '' }}"
                    name="descriere" rows="3">{{ old('descriere', $medic->descriere) }}</textarea>
            </div>
            <div class="col-lg-6 mb-4">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="3">{{ old('observatii', $medic->observatii) }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-0 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('medicReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
