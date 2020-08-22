<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        //validate request
        $this->validate($request, [
            'audience_id' => 'required',
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {

            $user = new User;
            $user->audience_id = $request->input('audience_id');
            $user->name = $request->input('name');
            $user->lastname = $request->input('lastname');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->status = 1;

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
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

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function QrAuthentication(Request $request)
    {
        $this->validate($request, [
            'token_qr' => 'required',
            'token_user' => 'required'
        ]);

        try{

            $user = Auth::setToken($request->input('token_user'))->user();

            if(!$user){
                return response()->json(['message' => 'No autorizado'], 401);
            }

            $json_data = [
                "to" => $request->token_qr,
                "notification" => [
                    "title" => "Inició de sesión QR",
                    "body" => "Autenticación por Token"
                ],
                "data" => [
                    "token_qr" => $request->token_qr,
                    "token_user" => $request->token_user
                ]
            ];

            $data = json_encode($json_data);
            $url = 'https://fcm.googleapis.com/fcm/send';
            $server_key = 'AAAAW2cZIpM:APA91bFpNpwYjDqbDuzCLzEHEhXj86000DiPSxpCeyyDiQzq45rpxD4VWesOgYaJoRFR2V8PD7xIrKMU4-CbLCcgWPL0K1ZFlxnjjab0dbyAY6pbLnCn0_COmI5e54CPXKeLWQuseh8T';
            $headers = array(
                'Content-Type:application/json',
                'Authorization:key='.$server_key
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Oops! FCM Send Error: ' . curl_error($ch));
            }

            curl_close($ch);

            return $result;

        }catch(\Exception $e) {
            return response()->json(['message' => 'User Find Failed!'], 409);
        }
    }

}