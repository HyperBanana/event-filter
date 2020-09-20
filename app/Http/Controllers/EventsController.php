<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{

    public function index(Request $request)
    {
        /* if ($request->ajax()) {
            //echo("ajax");
            $events = $this->eventFilter();

            return view('inc.grid')->with('events', $events);
            //dd(view('inc.grid')->with('events', $events));
        } else {
            $events = Event::orderBy('datetime', 'asc')->paginate(6);
            //dd($events);
            return view('pages.index')->with('events', $events);
        } */

            $events = $this->eventFilter();
        if ($request->ajax()) {
            return view('inc.grid')->with('events', $events);
        } else {
            return view('pages.index')->with('events', $events);
        }
    }

    public function eventFilter()
    {
        $events = Event::when(request('categories'), function ($q, $categories) {
            $q->whereIn('type', $categories);
            })
            ->when(request('dateRange'), function ($q, $dateRange) {
                $q->whereBetween('datetime', $dateRange);
            })
            ->when(request('searchTerms'), function ($q, $terms) {
                foreach ($terms as $term) {
                    $q->where('title', 'LIKE', '%' . $term . '%');
                }
            })->orderBy('datetime', 'asc')->paginate(6);

        return $events;
    }
}
