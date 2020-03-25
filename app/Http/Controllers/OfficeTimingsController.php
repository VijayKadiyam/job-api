<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OfficeTiming;
use App\User;

class OfficeTimingsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api']);
  }

  public function index(Request $request,User $user)
  {
    $office_timings =$user->office_timings;

  	return response()->json([
  		'data'     => $office_timings,
      'success'  =>   true
  	],200);
  }

  public function store(Request $request,User $user)
  {
  	$request->validate([
  	   'from'     =>  'required',   
       'to'       =>  'required',   	   
  	]);

  	$office_timing = new OfficeTiming($request->all());
  	$user->office_timings()->save($office_timing);

  	return response()->json([
  	  'data'     => $office_timing->toArray(),
      'success'  =>   true
  	],201);
  }
  
  public function show(User $user,OfficeTiming $office_timing)
  {
    return response()->json([
       'data'     => $office_timing,
       'success'  =>   true
    ], 200);
  }

  public function update(Request $request, User $user,OfficeTiming $office_timing)
  {
    $request->validate([
        'from'     =>  'required',  
        'to'       =>  'required',      
       ]);

    $office_timing->update($request->all());

    return response()->json([
     'data'     => $office_timing,
     'success'  =>   true
      ],200);
  }
    
  public function destroy(User $user,OfficeTiming $office_timing)
  {
    $office_timing->delete();
  }
}
