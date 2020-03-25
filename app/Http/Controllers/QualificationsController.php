<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Qualification;
use App\User;

class QualificationsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index(Request $request)
  {   
    $qualifications = request()->company->qualifications;

    return response()->json([
      'data'     =>  $qualifications,
      'success'  =>   true
    ], 200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name'   => 'required',
    ]);

    $qualification = new Qualification($request->all());
    $request->company->qualifications()->save($qualification);
    return response()->json([
      'data'    =>  $qualification,
      'success' =>  true
    ], 201); 
  }
  
  public function show(Qualification $qualification)
  {
    return response()->json([
      'data'     =>  $qualification,
      'success'  =>   true
    ], 200);   
  }

  public function update(Request $request, Qualification $qualification)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $qualification->update($request->all());
      
    return response()->json([
      'data'     =>  $qualification,
      'success'  =>   true
    ], 200);
  }

  public function destroy(Qualification $qualification)
  {
    $qualification->delete();
  }

}
