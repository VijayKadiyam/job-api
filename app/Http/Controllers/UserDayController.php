<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Day;
use App\User;

class UserDayController extends Controller
{
    /*
   * Assign user to day
   *
   *@
   */
  public function store(Request $request)
  {

    $request->validate([
        'day_id'   =>  'required',
        'user_id'        =>  'required'
    ]);

    $day =  Day::find($request->day_id);

    $user =  User::find($request->user_id);

    $day->assignUser($user->id);
    
    $userDay = Day::with('users')->find($request->day_id);

    return response()->json([
    'data'    =>  $userDay,
    'success' =>  true
    ], 201); 
  }
}
