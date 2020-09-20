<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventlistController extends Controller
{
    /**
     * Process eventlist GET requests
     *
     * @param   Request  $request 
     */
    public function index(Request $request)
    {
        $events = $this->eventFilter();
        if ($request->ajax()) {
            return view('inc.grid')->with('events', $events);
        } else {
            return view('pages.index')->with('events', $events);
        }
    }

    /**
     * Retrieve and filter events
     *
     * @return  mixed $events
     */
    protected function eventFilter()
    {
        $events = Event::when(request('categories'), function ($q, $categories) {
                $q->whereIn('type', $categories);
            })
            ->when(request('dateRange'), function ($q, $dateRange) {
                $q->whereBetween('datetime', $dateRange);
            })
            ->when(request('searchTerms'), function ($q, $terms) {
                $q->where(function ($q) use ($terms) {
                    foreach ($terms as $term) {
                        $q->where('title', 'like', '%' . $term . '%')
                        ->orWhere('title', 'like', '%' . $term . '%');
                    }
                });
            })->orderBy('datetime', 'asc')->paginate(6);

        return $events;
    }
}
