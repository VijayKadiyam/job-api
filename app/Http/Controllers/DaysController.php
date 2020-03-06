<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Day;
use App\User;

class DaysController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index(Request $request)
  {    
    $days = request()->company->days;

    return response()->json([
      'data'     =>  $days,
      'success'  =>   true
    ], 200);

  }

  public function store(Request $request)
  {
    $request->validate([
      'name'   => 'required',
    ]);

    $day = new Day($request->all());

    $request->company->days()->save($day);

    return response()->json([
      'data'    =>  $day,
      'success' =>  'true'
    ], 201); 
  }
  
  public function show(Day $day)
  {
    return response()->json([
      'data'   =>  $day
    ], 200);   
  }

  public function update(Request $request, Day $day)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $day->update($request->all());
      
    return response()->json([
      'data'  =>  $day
    ], 200);
  }

  public function destroy(Day $day)
  {
    $day->delete();
  }

}
