<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Models\Event;
use Storage;
use Carbon\Carbon;
use DB;

class EventsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $events = Event::when(request()->has('dateRange'), function($q) {
                $q->whereBetween('datetime', [request('dateRange.start'), request('dateRange.end')]);
            })->orderBy('datetime', 'asc')->paginate(6);
            $events = $this->convertEventsDate($events);

            return view('inc.grid')->with('events', $events)->render();
        }

        $events = Event::orderBy('datetime', 'asc')->paginate(6);
        $events = $this->convertEventsDate($events);

        return view('pages.index')->with('events', $events);
    }

    public function eventFilter(Request $request)
    {
        if ($request->ajax()) {
            $events = Event::when(request()->has('categories'), function($q) {
                $q->whereIn('type', request('categories'));
            })
            ->when(request()->has('dateRange'), function($q) {
                $q->whereBetween('datetime', [request('dateRange.start'), request('dateRange.end')]);
            })->orderBy('datetime', 'asc')->paginate(6);
            $events = $this->convertEventsDate($events);
        }
        return view('inc.grid')->with('events', $events);
    }

    public function convertEventsDate($events)
    {
        foreach ($events as $event) {
            $event->datetime = Carbon::parse($event->datetime)->locale('lv')->translatedFormat('d. F');
        }

        return $events;
    }
}
