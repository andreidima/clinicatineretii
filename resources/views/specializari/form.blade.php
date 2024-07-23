@csrf

<div class="row mb-0 px-3 d-flex border-radius: 0px 0px 40px 40px">
    <div class="col-lg-12 px-4 py-2 mb-0 mx-auto">
        <div class="row mb-0 justify-content-center">
            <div class="col-lg-8 mb-4">
                <label for="denumire" class="mb-0 ps-3">Denumire<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('denumire') ? 'is-invalid' : '' }}"
                    name="denumire"
                    placeholder=""
                    value="{{ old('denumire', $specializare->denumire) }}"
                    required>
            </div>
            <div class="col-lg-8 mb-4">
                <label for="descriere" class="form-label mb-0 ps-3">Descriere</label>
                <textarea class="form-control bg-white {{ $errors->has('descriere') ? 'is-invalid' : '' }}"
                    name="descriere" rows="3">{{ old('descriere', $specializare->descriere) }}</textarea>
            </div>
            <div class="col-lg-8 mb-4">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="3">{{ old('observatii', $specializare->observatii) }}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-0 d-flex justify-content-center">
                <button type="submit" ref="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('specializareReturnUrl') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
