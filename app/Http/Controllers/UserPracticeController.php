<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Practice;

class UserPracticeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api')
      ->except('store');
  }

  /*
   * Assign user to practice
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'practice_id'    =>  'required',
      'user_id' =>  'required'
    ]);

    $practice = Practice::find($request->practice_id);
    $user = User::find($request->user_id);
    $practice->assignUser($user->id);
    $userPractice = Practice::with('users')->find($request->practice_id);

    return response()->json([
        'data'  =>  $userPractice,
        'success' =>  true
    ], 201); 
  }
}
