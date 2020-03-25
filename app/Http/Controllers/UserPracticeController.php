<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Practice;

class UserPracticeController extends Controller
{
  /*
   * Assign user to practice
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'practice_ids'    =>  'required',
      'user_id'         =>  'required'
    ]);

    $user = User::find($request->user_id);
    $user->assignPractice($request->practice_ids);
    $practiceUser = User::with('practices')->find($request->user_id);

    return response()->json([
        'data'  =>  $practiceUser,
        'success' =>  true
    ], 201); 
  }
}
