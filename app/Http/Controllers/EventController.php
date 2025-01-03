<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    // Store a new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|date_format:Y-m-d',
        ]);
    
        $event = Event::create([
            'title' => $request->title,
            'date' => $request->date,
        ]);
    
        return response()->json($event, 201);
    }

    // Fetch all events
    public function index()
    {
        $events = Event::all();
        return response()->json($events);

    }
}
