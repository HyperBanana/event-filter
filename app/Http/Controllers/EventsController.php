<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Storage;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function index()
    {
        //$events = Event::all();
        //return $events;
        $events = Event::orderBy('datetime', 'desc')->simplePaginate(6);
        foreach($events as $event) {
            $event->datetime = $this->convertDate($event->datetime);
        }
        return view('pages.index')->with('events', $events);
    }

    public function convertDate($date) {
        return Carbon::parse($date)->locale('lv')->translatedFormat('d. F');
    }
}
