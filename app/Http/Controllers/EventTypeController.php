<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;

class EventTypeController extends Controller
{

    public function List()
    {
        $event_types = EventType::all();
        return response()->json($event_types, 200, array(), JSON_PRETTY_PRINT);
    }
}