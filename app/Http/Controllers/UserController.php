<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function Profile(Request $request)
    {
        try{
            $user = Auth::setToken($request->input('token'))->user();
            //return successful response
            if($user){
                return response()->json($user, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json(['message' => 'User no found'], 404);

        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }

    public function UpdateProfile(Request $request)
    {
        try{
            $user = Auth::setToken($request->input('token'))->user();
            if($user){
                $user = User::find($user->id);
                $user->name = $request->input('name');
                $user->lastname = $request->input('lastname');
                $user->phone = $request->input('phone');
                $user->update();
                //return successful response
                return response()->json($user, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json(['message' => 'User no found'], 404);

        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }

    public function ChangePassword(Request $request)
    {
        try{
            $user = Auth::setToken($request->input('token'))->user();
            if($user){
                $user = User::find($user->id);
                $plainPassword = $request->input('password');
                $user->password = app('hash')->make($plainPassword);
                $user->update();
                //return successful response
                return response()->json($user, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json(['message' => 'User no found'], 404);

        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }


    public function MyEvents(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try{
            $user = Auth::setToken($request->input('token'))->user();
            if($user){
                $events = \DB::table('events')
                ->join('participants', 'events.id', '=', 'participants.event_id')
                ->join('users', 'users.id', '=', 'participants.user_id')
                ->select('events.id', 'events.type_id', 'events.school_id', 'events.organizer_id', 'events.title', 'events.description', 'events.image', 'events.event_date', 'events.start_time', 'events.end_time', 'events.is_outstanding', 'events.is_virtual', 'events.is_open', 'events.location', 'events.event_link', 'events.status', 'participants.assistance', 'participants.assistance_date')
                ->where('users.id', $user->id)
                ->get();
                return response()->json($events, 200, array(), JSON_PRETTY_PRINT);
            }
            return response()->json([], 200, array(), JSON_PRETTY_PRINT);

        }catch(\Exception $e){
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }

    public function MyEvent(Request $request, $id)
    {
        try{
            $event_id = $id;
            $events = \DB::table('events')
            ->join('participants', 'events.id', '=', 'participants.event_id')
            ->select('events.id', 'events.type_id', 'events.school_id', 'events.organizer_id', 'events.title', 'events.description', 'events.image', 'events.event_date', 'events.start_time', 'events.end_time', 'events.is_outstanding', 'events.is_virtual', 'events.is_open', 'events.location', 'events.event_link', 'events.status', 'participants.assistance', 'participants.assistance_date')
            ->where('events.id', $event_id)
            ->first();
            return response()->json($events, 200, array(), JSON_PRETTY_PRINT);
        }catch(\Exception $e){
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }

    public function MyEventsQR(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try{
            $user = Auth::setToken($request->input('token'))->user();
            if($user){
                $events = \DB::table('events')
                ->join('participants', 'events.id', '=', 'participants.event_id')
                ->join('users', 'users.id', '=', 'participants.user_id')
                ->select('events.id', 'events.type_id', 'events.school_id', 'events.organizer_id', 'events.title', 'events.description', 'events.image', 'events.event_date', 'events.start_time', 'events.end_time', 'events.is_outstanding', 'events.is_virtual', 'events.is_open', 'events.location', 'events.event_link', 'events.status', 'participants.assistance', 'participants.assistance_date')
                ->where('users.id', $user->id)
                ->get();
                
                if($events){
                    
                    $data = array(
                        "user" => $user,
                        "events" => $events
                    );

                    return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
                }else{
                    
                    $data = array(
                        "user" => $user,
                        "events" => []
                    );
                    
                    return response()->json($data, 200, array(), JSON_PRETTY_PRINT);
                }
            }
            return response()->json(['message' => 'No autorizado'], 401);

        }catch(\Exception $e){
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }
}