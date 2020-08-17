<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;

class FacultyController extends Controller
{

    public function List()
    {
        $faculties = Faculty::all();
        return response()->json($faculties, 200, array(), JSON_PRETTY_PRINT);
    }
}