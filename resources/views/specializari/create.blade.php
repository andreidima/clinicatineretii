@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2 culoare2" style="border-radius: 40px 40px 0px 0px;">
                    <span class="badge text-light fs-5">
                        <i class="fa-solid fa-kit-medical me-1"></i>Adăugare specializare
                    </span>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >
                    <form  class="needs-validation" novalidate method="POST" action="/specializari">

                            @include ('specializari.form', [
                                // 'specializare' => new App\Models\Specializare,
                                'buttonText' => 'Adaugă specializare'
                            ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
