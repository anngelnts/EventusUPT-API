<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;

class UniversityController extends Controller
{

    public function List()
    {
        $universities = University::all();
        return response()->json($universities, 200, array(), JSON_PRETTY_PRINT);
    }
}