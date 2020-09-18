    @if (count($events) > 0)
        @foreach ($events as $event)
            <div class="well event-card">
                <small>{{ $event->datetime }}</small>
                <div class="image-wrapper">
                    <img src="{{ $event->lead_image }}">
                </div>
                <hr class="hr-text" data-content="{{ $event->type }}">
                <h3>{{ $event->title }}</h3>
            </div>
        @endforeach
    @else
        <p>Nav notikumu</p>
    @endif
    <div>
        {{ $events->links() }}
    </div>