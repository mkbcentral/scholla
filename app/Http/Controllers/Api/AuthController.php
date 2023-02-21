<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:4',
        ]);
        $creds=$request->only(['email','password']);
        if (Auth::attempt($creds)) {
            $user =auth()->user();
            return response()->json([
                'user'=>$user,
                'token'=>$user->createToken('token')->plainTextToken
            ]);
        } else {
            return response()->json([
                'message'=>'Make sure your email and password'
           ],403);
        }
    }

    public function user(){
        return response()->json([
            'user'=>auth()->user(),
            'token'=>request()->bearerToken()
        ]);
    }

}
