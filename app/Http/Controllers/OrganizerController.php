<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Organizer;
use App\Models\Event;

class OrganizerController extends Controller
{
    public function Profile(Request $request)
    {
        try{
            $organizer = Auth::guard('organizer')->setToken($request->input('token'))->user();
            //return successful response
            if($organizer){
                return response()->json($organizer, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json(['message' => 'Organizer no found'], 404);

        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'Organizer Find Failed!'], 409);
        }
    }

    public function UpdateProfile(Request $request)
    {
        try{
            $organizer = Auth::guard('organizer')->setToken($request->input('token'))->user();
            if($organizer){
                $organizer = Organizer::find($organizer->id);
                $organizer->name = $request->input('name');
                $organizer->acronym = $request->input('acronym');
                $organizer->phone = $request->input('phone');
                $organizer->website = $request->input('website');
                $organizer->facebook = $request->input('facebook');
                $organizer->update();
                //return successful response
                return response()->json($organizer, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json(['message' => 'Organizer no found'], 404);

        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'Organizer Find Failed!'], 409);
        }
    }

    public function ChangePassword(Request $request)
    {
        try{
            $organizer = Auth::guard('organizer')->setToken($request->input('token'))->user();
            if($organizer){
                $organizer = Organizer::find($organizer->id);
                $plainPassword = $request->input('password');
                $organizer->password = app('hash')->make($plainPassword);
                $organizer->update();
                //return successful response
                return response()->json($organizer, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json(['message' => 'Organizer no found'], 404);

        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'Organizer Find Failed!'], 409);
        }
    }

    public function MyEvents(Request $request)
    {
        try{
            $organizer = Auth::guard('organizer')->setToken($request->input('token'))->user();
            if($organizer){
                $events = Event::where('organizer_id', $organizer->id)->orderBy('event_date', 'DESC')->get();
                return response()->json($events, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json([], 200, array(), JSON_PRETTY_PRINT);

        }catch(\Exception $e){
            return response()->json(['message' => 'Organizer Find Failed!'], 409);
        }
    }


    public function MyEventParticipants(Request $request, $id)
    {
        try{
            $event_id = $id;
            $event = Event::find($event_id);
            $participants = \DB::table('users')
            ->join('participants', 'users.id', '=', 'participants.user_id')
            ->select('users.id', 'users.name', 'users.lastname', 'users.phone', 'users.email', 'users.status', 'participants.assistance', 'participants.assistance_date')
            ->where('participants.event_id', $event->id)
            ->get();

            $event_data = array(
                "event" => $event,
                "participants" => $participants
            );

            return response()->json($event_data, 200, array(), JSON_PRETTY_PRINT);
        }catch(\Exception $e){
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }
}