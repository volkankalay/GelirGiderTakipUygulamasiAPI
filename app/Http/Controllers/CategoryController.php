<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Get User Categories
       return response()->json(
         Auth::user()->getCategories()->get()
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Delete Category

      $category             = Category::findOrFail($id);
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
}
