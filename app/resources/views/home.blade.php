@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(isset($currencies) && count($currencies) > 0)
                        <h1>{{ __('Kursy walut:') }}</h1>
                        @foreach($currencies as $currency)
                            <p><strong>{{ $currency->code }}</strong></p>
                            <span><strong>{{ __('Średni kurs:') }}</strong> {{ $currency->mid }}</span>
                            <span><strong>{{ __('Kurs kupna:') }}</strong> {{ $currency->bid }}</span>
                            <span><strong>{{ __(' Kurs sprzedaży:') }}</strong> {{ $currency->ask }}</span>
                            <hr/>
                        @endforeach
                    @else
                        {{ __('Brak kursów walut.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
