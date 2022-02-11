<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ApiController extends Controller
{

    public function Login(Request $request){
      // Login
      $credentials = $request->validate([
          'email' => ['required', 'email'],
          'password' => ['required'],
      ]);

      if(Auth::attempt($credentials)){
        $user             = Auth::user();
        $success['token'] = $user->createToken('Login')->accessToken;

        return response()->json([
          'success' => $success
        ], 200);
      }
      else {
        return response()->json([
          'error' => 'Unauthorized'
        ], 401);
      }
    }

    public function User(Request $request){
      // Get User Details
      return Auth::user();
    }

    public function Logout(Request $request){
      // Logout & Delete Access Key
      if (Auth::check()) {
         Auth::user()->AauthAcessToken()->delete();
         return response()->json([
           'success' => 'Logout Success'
         ], 200);
      }
    }
}
