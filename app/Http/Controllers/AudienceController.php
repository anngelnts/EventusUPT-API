<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audience;

class AudienceController extends Controller
{

    public function List()
    {
        $audiences = Audience::all();
        return response()->json($audiences, 200, array(), JSON_PRETTY_PRINT);
    }
}