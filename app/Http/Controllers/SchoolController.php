<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{

    public function List()
    {
        $schools = School::all();
        return response()->json($schools, 200, array(), JSON_PRETTY_PRINT);
    }
}