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
        'day_ids'   =>  'required',
        'user_id'   =>  'required'
    ]);

    $user = User::find($request->user_id);
    $user->assignDay($request->day_ids);
    $dayUser = User::with('days')->find($request->user_id);

    return response()->json([
        'data'  =>  $dayUser,
        'success' =>  true
    ], 201); 
  }
}
