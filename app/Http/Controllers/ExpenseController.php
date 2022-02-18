<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Category;
use App\Models\Data;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Get User Transaction Datas
       return response()->json(
         Auth::user()->getDatas()->with(['category','currency'])->get()
       , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

      $category = Category::find($request->category_id);
      if(Auth::id() != $category->user_id ){
        return response()->json([
          'status' => false,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // Update Data
      $request->validate([
        'transaction_date'  => ['date', 'required'],
        'amount'            => ['numeric', 'min:0', 'required'],
        'currency_id'       => ['integer', 'exists:currencies,id', 'required'],
        'category_id'       => ['integer', 'exists:categories,id','required'],
        'description'       => ['nullable', 'max:4096']
      ]);

      $data             = Data::findOrFail($id);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Delete Data

      $data             = Data::findOrFail($id);
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
