@extends('layouts.app')

@section('content')
    <div class="events-wrapper row">
        <div class="events-grid col-8">
            @if (count($events) > 0)
                @foreach ($events as $event)
                    <div class="well event-card">
                        <small>{{ $event->datetime }}</small>
                        <div class="image-wrapper">
                            <img src="{{ $event->lead_image }}">
                        </div>
                        <hr class="hr-text" data-content="{{ $event->type}}">
                        <h3>{{ $event->title }}</h3>
                    </div>
                @endforeach
            @else
                <p>No events</p>
            @endif
            <div>
                {{ $events->links() }}
            </div>
        </div>
        <div class="events-filter col">
            <form action="/search" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="q"
                        placeholder="Search users"> <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>

@endsection
