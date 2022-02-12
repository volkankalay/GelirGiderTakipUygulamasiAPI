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
        $message['token'] = Auth::user()->createToken('Register')->accessToken;
        $message['user']  = Auth::user();
        return response()->json($message, 200);
      }
      else {
        return response()->json([
          'error' => 'Unauthorized'
        ], 401);
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
        return response()->json([
          'error' => 'Unauthorized'
        ], 401);
      }
    }

    public function Logout(Request $request){
      // Logout & Delete Access Key
      Auth::user()->AauthAcessToken()->delete();
      return response()->json([
        'status' => true
      ], 200);
    }

    public function User(Request $request){
      // Get User Details
      return response()->json(
        Auth::user()
      , 200);
    }

    public function Currencies(Request $request){
      // Get Currencies
       return response()->json([
         'currencies' => Currency::all()
       ], 200);
    }

    public function CategoryList(Request $request){
      // Get User Categories
       return response()->json([
         'categories' => Auth::user()->getCategories()->get()
       ], 200);
    }

    public function CategoryStore(Request $request){
      // Add New Category
      $request->validate([
        'name'        => ['required', 'max:255'],
        'is_income'   => ['required', 'boolean'],
      ]);

      $category             = new Category();
      $category->name       = $request->name;
      $category->is_income  = $request->is_income;
      $category->user_id    = Auth::id();
      $category->created_at = now();
      $category->updated_at = now();
      $category->save();

      return response()->json([
       'status' => true
      ], 200);
    }

    public function CategoryUpdate(Request $request){
      // Add New Category
      $request->validate([
        'id'          => ['required', 'exists:categories,id'],
        'name'        => ['required', 'max:255'],
        'is_income'   => ['required', 'boolean'],
      ]);

      $category             = Category::findOrFail($request->id);

      if($category->user_id == Auth::id()){
        $category->name       = $request->name;
        $category->is_income  = $request->is_income;
        $category->updated_at = now();
        $category->save();

        return response()->json([
         'status' => true
        ], 200);
      }else{
        return response()->json([
         'status'  => false,
         'message' => 'Unauthorized'
        ], 200);
      }
    }

    public function CategoryDelete(Request $request){
      // Delete Category
      $request->validate([
        'id'          => ['required', 'exists:categories,id'],
      ]);

      $category             = Category::findOrFail($request->id);
      if($category->user_id == Auth::id()){
        $category->delete();

        return response()->json([
         'status' => true
        ], 200);
      }else{
        return response()->json([
         'status'  => false,
         'message' => 'Unauthorized'
        ], 200);
      }
    }


    public function DataList(Request $request){
      // Get User Transaction Datas
       return response()->json([
         'datas' => Auth::user()->getDatas()->with(['category','currency'])->get()
       ], 200);
    }

    public function DataStore(Request $request){
      // Add New Data
      $request->validate([
        'transaction_date'  => ['date', 'required'],
        'amount'            => ['numeric', 'min:0', 'required'],
        'currency_id'       => ['integer', 'exists:currencies,id', 'required'],
        'category_id'       => ['integer', 'exists:categories,id',
          'required'
        ],
        'description'       => ['nullable', 'max:4096']
      ]);

      $category = Category::find($request->category_id)->first();
      if(Auth::id() != $category->user_id ){
        return response()->json([
         'status' => false
       ], 401);
      }

      $data                     = new Data();
      $data->transaction_date   = $request->transaction_date;
      $data->amount             = $request->amount;
      $data->currency_id        = $request->currency_id;
      $data->category_id        = $request->category_id;
      $data->description        = $request->description;
      $data->user_id            = Auth::id();
      $data->created_at         = now();
      $data->updated_at         = now();
      $data->save();

      return response()->json([
       'status' => true
      ], 200);
    }

    public function DataUpdate(Request $request){
      // Update Data
      $request->validate([
        'id'                => ['required', 'exists:data,id'],
        'transaction_date'  => ['date', 'required'],
        'amount'            => ['numeric', 'min:0', 'required'],
        'currency_id'       => ['integer', 'exists:currencies,id', 'required'],
        'category_id'       => ['integer', 'exists:categories,id','required'],
        'description'       => ['nullable', 'max:4096']
      ]);

      $data             = Data::findOrFail($request->id);

      if($data->user_id == Auth::id()){
        $data->transaction_date   = $request->transaction_date;
        $data->amount             = $request->amount;
        $data->currency_id        = $request->currency_id;
        $data->category_id        = $request->category_id;
        $data->description        = $request->description;
        $data->user_id            = Auth::id();
        $data->updated_at         = now();
        $data->save();

        return response()->json([
         'status' => true
        ], 200);

      }else{
        return response()->json([
         'status'  => false,
         'message' => 'Unauthorized'
        ], 200);
      }
    }


    public function DataDelete(Request $request){
      // Delete Data
      $request->validate([
        'id'          => ['required', 'exists:data,id'],
      ]);

      $data             = Data::findOrFail($request->id);
      if($data->user_id == Auth::id()){
        $data->delete();

        return response()->json([
         'status' => true
        ], 200);
      }else{
        return response()->json([
         'status'  => false,
         'message' => 'Unauthorized'
        ], 200);
      }
    }

}
