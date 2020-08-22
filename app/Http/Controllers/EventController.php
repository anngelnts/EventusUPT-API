<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventAudience;
use App\Models\Participant;

class EventController extends Controller
{

    public function List()
    {
        $events = Event::where('status', 1)->orderBy('event_date', 'DESC')->get();
        return response()->json($events, 200, array(), JSON_PRETTY_PRINT);
    }

    public function View($id)
    {
        try {
            $event = Event::findOrFail($id);
            return response()->json($event, 200, array(), JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Evento no encontrado'], 404, array(), JSON_PRETTY_PRINT);
        }
    }

    public function Store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'type_id' => 'required',
            'school_id' => 'required',
            'title' => 'required'
        ]);

        $organizer = Auth::guard('organizer')->setToken($request->input('token'))->user();

        if($organizer){

            $image_url = "";
            if($request->hasFile('image')){
                $image = $request->file('image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = './uploads/events';
                $image_url = url('uploads/events/'.$name);
                if(!file_exists($destinationPath)) {
                    @mkdir($destinationPath, 755, true);
                }
                $image->move($destinationPath, $name);
            }

            try{
                $event = new Event();
                $event->type_id = $request->input('type_id');
                $event->school_id = $request->input('school_id');
                $event->organizer_id = $organizer->id;
                $event->title = $request->input('title');
                $event->description = $request->input('description');
                $event->image = $request->input('image_url');
                $event->event_date = $request->input('event_date');
                $event->start_time = $request->input('start_time');
                $event->end_time = $request->input('end_time');
                $event->is_outstanding = $request->input('is_outstanding');
                $event->is_virtual = $request->input('is_virtual');
                $event->is_open = $request->input('is_open');
                $event->location = $request->input('location');
                $event->event_link = $request->input('event_link');
                $event->status = $request->input('status');
                
                if($event->save()){

                    if($request->has('event_audiences')){
                        $event_audiences = $request->input('event_audiences');

                        foreach($event_audiences as $audience){
                            $eventAudience = new EventAudience();
                            $eventAudience->event_id = $event->id;
                            $eventAudience->audience_id = $audience;
                            $eventAudience->save();
                        }
                    }
                }
                //return successful response
                return response()->json(['event' => $event, 'message' => 'CREATED'], 201);
            }catch(\Exception $e){
                //return error message
                return response()->json(['message' => 'Event Registration Failed!'], 409);
            }
        }else{
            return response()->json(['message' => 'Organizer no found'], 404);
        }
    }

    public function Update(Request $request, $id)
    {
        $this->validate($request, [
            'type_id' => 'required',
            'school_id' => 'required',
            'title' => 'required'
        ]);

        $image_url = "";
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = './uploads/events';
            $image_url = url('uploads/events/'.$name);
            if(!file_exists($destinationPath)) {
                @mkdir($destinationPath, 755, true);
            }
            $image->move($destinationPath, $name);
        }

        try{
            $event = Event::find($id);
            $event->type_id = $request->input('type_id');
            $event->school_id = $request->input('school_id');
            $event->title = $request->input('title');
            $event->description = $request->input('description');
			$event->image = $request->input('image_url');

            if($request->hasFile('image')){
                $event->image = $image_url;
            }

            $event->event_date = $request->input('event_date');
            $event->start_time = $request->input('start_time');
            $event->end_time = $request->input('end_time');
            $event->is_outstanding = $request->input('is_outstanding');
            $event->is_virtual = $request->input('is_virtual');
            $event->is_open = $request->input('is_open');
            $event->location = $request->input('location');
            $event->event_link = $request->input('event_link');
            $event->status = $request->input('status');
            $event->update();
            //return successful response
            return response()->json(['event' => $event, 'message' => 'UPDATED'], 200);
        }catch(\Exception $e){
            //return error message
            return response()->json(['message' => 'Event Update Failed!'], 409);
        }
    }


    public function StoreParticipant(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'event_id' => 'required'
        ]);

        $user = Auth::setToken($request->input('token'))->user();

        if($user){

            try{
                $participant = new Participant();
                $participant->event_id = $request->input('event_id');
                $participant->user_id = $user->id;
                $participant->assistance = 0;
                $participant->save();
                //return successful response
                return response()->json(['participant' => $participant, 'message' => 'CREATED'], 201);
            }catch(\Exception $e){
                //return error message
                return response()->json(['message' => 'Participant Registration Failed!'], 409);
            }
        }else{
            return response()->json(['message' => 'User no found'], 404);
        }
    }

    public function UpdateParticipant(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'event_id' => 'required'
        ]);

        $user = Auth::setToken($request->input('token'))->user();

        if($user){

            try{
                $event_id = $request->input('event_id');
                $user_id = $user->id;
                $participant = Participant::where('event_id', $event_id)->where('user_id', $user_id)->first();
                $participant->assistance = 1;
                $participant->assistance_date = date('Y-m-d H:i:s');
                $participant->update();
                //return successful response
                return response()->json(['participant' => $participant, 'message' => 'UPDATED'], 200);
            }catch(\Exception $e){
                //return error message
                return response()->json(['message' => 'Participant Updated Failed!'], 409);
            }
        }else{
            return response()->json(['message' => 'User no found'], 404);
        }
    }

}