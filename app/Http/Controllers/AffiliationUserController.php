<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Affiliation;

class AffiliationUserController extends Controller
{
   public function __construct()
  {
    $this->middleware('auth:api')
      ->except('store');
  }
  public function store(Request $request)
  {
    $request->validate([
      'user_id'    =>  'required',
      'affiliation_id' =>  'required'
    ]);

    $user = User::find($request->user_id);
    $affiliation = Affiliation::find($request->affiliation_id);
    $user->assignAffiliation($affiliation->id);
    $affiliationUser = User::with('affiliations')->find($request->user_id);

    return response()->json([
        'data'  =>  $affiliationUser,
        'success' =>  true
    ], 201); 
  }


}
