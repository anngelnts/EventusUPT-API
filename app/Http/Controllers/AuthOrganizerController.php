<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Organizer;

class AuthOrganizerController extends Controller
{
    public function Register(Request $request)
    {
        //validate request
        $this->validate($request, [
            'name' => 'required',
            'acronym' => 'required|string',
            'email' => 'required|email|unique:organizers',
            'password' => 'required',
        ]);

        try {

            $organizer = new Organizer();
            $organizer->name = $request->input('name');
            $organizer->acronym = $request->input('acronym');
            $organizer->phone = $request->input('phone');
            $organizer->website = $request->input('website');
            $organizer->facebook = $request->input('facebook');
            $organizer->email = $request->input('email');
            $plainPassword = $request->input('password');
            $organizer->password = app('hash')->make($plainPassword);
            $organizer->status = 1;

            $organizer->save();

            //return successful response
            return response()->json(['organizer' => $organizer, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Organizer Registration Failed!'], 409);
        }

    }

    public function Login(Request $request)
    {
        //validate request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::guard('organizer')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}