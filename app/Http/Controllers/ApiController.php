<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Data;
use App\Models\User;

class ApiController extends Controller
{

    public function Login(Request $request){
      // Login
      $credentials = $request->validate([
          'email'     => ['required', 'email'],
          'password'  => ['required'],
      ]);

      if(Auth::attempt($credentials)){
        $message['token'] = Auth::user()->createToken('Login')->accessToken;
        $message['user']  = Auth::user();
        return response()->json($message, 200);
      }
      else {
        return response()->json(
          ['error' => 'Unauthorized']
        , 401);
      }
    }

    public function Register(Request $request){
      // Register
      $credentials = $request->validate([
          'email'     => ['required', 'email', 'unique:users,email'],
          'password'  => ['required'],
      ]);

      $new_user             = new User();
      $new_user->email      = $request->email;
      $new_user->password   = bcrypt($request->password);
      $new_user->created_at = now();
      $new_user->updated_at = now();
      $new_user->save();

      if(Auth::attempt($credentials)){
        $message['token'] = Auth::user()->createToken('Register')->accessToken;
        $message['user']  = Auth::user();
        return response()->json($message, 200);
      }
      else {
        return response()->json(
          ['error' => 'Unauthorized']
        , 401);
      }
    }

    public function Logout(Request $request){
      // Logout & Delete Access Key
      Auth::user()->AauthAcessToken()->delete();
      return response()->json(
        ['status' => true]
      , 200);
    }

    public function User(Request $request){
      // Get User Details
      return response()->json(
        Auth::user()
      , 200);
    }

    public function Currencies(Request $request){
      // Get Currencies
       return response()->json(Currency::all(), 200);
    }

}
