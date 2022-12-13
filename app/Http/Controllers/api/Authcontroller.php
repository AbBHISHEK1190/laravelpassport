<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Authcontroller extends Controller
{
    function register(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        
        if(!empty($request->all()))
        {
            $User=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);
            
          $token=  $User->createToken('Token')->accessToken;
          return response()->json(['token'=>$token,'user'=>$User],200);
        }
       
    }

     function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   
    
    function userinfo(Request $request)
    {
$User=auth()->user();
return response()->json(['user' => $User], 200);
    }
}
