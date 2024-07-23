@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mb-5">
            <div class="card culoare2">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    Bine ai venit <b>{{ auth()->user()->name ?? '' }}</b>!
                </div>
            </div>
        </div>
    </div>

    @php
        use App\Models\Programare;
        use App\Models\Pacient;
        use Carbon\Carbon;
        $dataCurenta = Carbon::now();
        $lunaTrecuta = Carbon::now()->subMonthNoOverflow();
    @endphp

    <div class="row justify-content-center">
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Programări - toate</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ Programare::count() }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Programări - {{ $dataCurenta->isoFormat('MMMM YYYY') }}</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ Programare::whereMonth('data', $dataCurenta)->whereYear('data', $dataCurenta)->count() }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Programări - {{ $lunaTrecuta->isoFormat('MMMM YYYY') }}</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ Programare::whereMonth('data', $lunaTrecuta)->whereYear('data', $lunaTrecuta)->count() }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Pacienți - toți</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ Pacient::count() }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Pacienți noi - {{ $dataCurenta->isoFormat('MMMM YYYY') }}</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ Pacient::whereMonth('created_at', $dataCurenta)->whereYear('created_at', $dataCurenta)->count() }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card culoare2">
                <div class="card-header text-center">Pacienți noi - {{ $lunaTrecuta->isoFormat('MMMM YYYY') }}</div>
                <div class="card-body text-center">
                    <b class="fs-2">{{ Pacient::whereMonth('created_at', $lunaTrecuta)->whereYear('created_at', $lunaTrecuta)->count() }}</b>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

