@extends('layouts.app')

@section('content')
    <div class="events-wrapper row">

        <div class="events-grid col col-lg-8 col-md-6 order-2 order-md-1">
            @include('inc.grid')
        </div>
        
        <div class="events-filter col col-lg-3 col-md-6 order-1 order-md-2">
            <button class="btn-filter btn btn-light " data-toggle="collapse" data-target=".event-categories-form">Filtrs</button>
            {!! Form::open(['method' => 'GET', 'class' => 'event-categories-form collapse']) !!}
            <div class="checkbox-container">
                {{ Form::checkbox('all', 'all', true) }}
                {{ Form::label('all', 'Visas tēmas') }}
            </div>
            <div class="checkbox-container">
                {{ Form::checkbox('kultūra', 'kultūra') }}
                {{ Form::label('kultūra', 'Izklaide, kultūra') }}
            </div>
            <div class="checkbox-container">
                {{ Form::checkbox('sports', 'sports') }}
                {{ Form::label('sports', 'Sports') }}
            </div>
            <div class="checkbox-container">
                {{ Form::checkbox('ģimenēm', 'ģimenēm') }}
                {{ Form::label('ģimenēm', 'Ģimenēm') }}
            </div>
            <div class="checkbox-container">
                {{ Form::checkbox('izglītība', 'izglītība') }}
                {{ Form::label('izglītība', 'Izglītība') }}
            </div>
            <div class="checkbox-container">
                {{ Form::checkbox('pilsēta', 'pilsēta') }}
                {{ Form::label('pilsēta', 'Pilsēta') }}
            </div>
            <div class="checkbox-container">
                {{ Form::checkbox('cits', 'cits') }}
                {{ Form::label('cits', 'Cita tēma') }}
            </div>
            <hr>
            <div class="input-group date-input">
                {{ Form::text('date', '', ['class' => 'daterange form-control', 'placeholder' => 'Atlasīt laika periodu']) }}

                <span class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" data-toggle="datepicker"
                        data-target-name="date">
                        <span class="fas fa-calendar-alt"></span>
                    </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
    {{--
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
    --}}
    {{-- <script type="text/javascript"
        src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> --}}
    {{--
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="{{ URL::asset('js/event_filter.js') }}"></script>
@endsection
