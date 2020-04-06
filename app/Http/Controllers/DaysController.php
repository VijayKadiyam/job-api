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
    $count = 0;
    if($request->search) {
      $days = request()->company->days()
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->get();
      $count = $days->count();
    }
    else if($request->page && $request->rowsPerPage != -1) {
      $days = request()->company->days();
      $count = $days->count();
      $days = $days->paginate($request->rowsPerPage)->toArray();
      $days = $days['data'];
    }
    else {
      $days = request()->company->days;
      $count = $days->count();
    }

    return response()->json([
      'data'  =>  $days,
      'count' =>  $count
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
      'data'     =>  $day,
      'success'  =>   true
    ], 201); 
  }
  
  public function show(Day $day)
  {
    return response()->json([
      'data'     =>  $day,
      'success'  =>   true
    ], 200);   
  }

  public function update(Request $request, Day $day)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $day->update($request->all());
      
    return response()->json([
      'data'     =>  $day,
      'success'  =>   true
    ], 200);
  }

  public function destroy(Day $day)
  {
    $day->delete();
  }

}
