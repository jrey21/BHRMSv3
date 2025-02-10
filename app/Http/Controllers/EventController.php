<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;
use Carbon\Carbon;

class EventController extends Controller
{
    // Store a new event
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'date' => 'date',
        ]);

        Event::create($validatedData);
        
        session()->flash('message', 'Data has been added successfully!');

    }

    // Fetch all events
    public function retrieve()
    {
        $events = Event::all();
        return response()->json($events);
    }
}
