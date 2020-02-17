<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeavePolicy;
use App\User;

class LeavePoliciesController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api']);
  }

  public function index(Request $request,User $user)
  {
    $leavepolicies =$user->leavepolicies;

  	return response()->json([
  		'data' => $leavepolicies
  	],200);
  }

  public function store(Request $request,User $user)
  {
  	$request->validate([
  	   'exam'     =>  'required',   	   
  	]);

  	$leave_policy = new LeavePolicy($request->all());
  	$user->leavepolicies()->save($leave_policy);

  	return response()->json([
  	  'data' => $leave_policy->toArray()
  	],201);
  }
  public function show(User $user,LeavePolicy $leave_policy)
  {
    return response()->json([
       'data' => $leave_policy
    ], 200);
  }

  public function update(Request $request, User $user,LeavePolicy $leave_policy)
  {
    $request->validate([
        'exam'     =>  'required',     
       ]);

    $leave_policy->update($request->all());

    return response()->json([
     'data' => $leave_policy
      ],200);
  }
    
  public function destroy(User $user,LeavePolicy $leave_policy)
  {
    $leave_policy->delete();
  }
}
