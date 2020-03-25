<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Affiliation;

class AffiliationUserController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'user_id'         =>  'required',
      'affiliation_ids' =>  'required'
    ]);

    $user = User::find($request->user_id);
    $user->assignAffiliation($request->affiliation_ids);
    $affiliationUser = User::with('affiliations')->find($request->user_id);

    return response()->json([
        'data'  =>  $affiliationUser,
        'success' =>  true
    ], 201); 
  }


}
