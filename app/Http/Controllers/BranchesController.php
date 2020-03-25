<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\User;

class BranchesController extends Controller
{
	public function __construct()
  {
    $this->middleware(['auth:api']);
  }

  public function index(Request $request,User $user)
  {
  	$branches =$user->branches;

  	return response()->json([
  		'data'     => $branches,
      'success'  =>   true
  	],200);
  }

  public function store(Request $request,User $user)
  {
  	$request->validate([
  	   'name'     =>  'required',   	   
  	]);

  	$branch = new Branch($request->all());
  	$user->branches()->save($branch);

  	return response()->json([
  	  'data'     => $branch->toArray(),
      'success'  =>   true
  	],201);
  }
  public function show(User $user,Branch $branch)
  {
    return response()->json([
      'data'     => $branch,
      'success'  =>   true
    ], 200);
  }

	public function update(Request $request, User $user,Branch $branch)
	{
		$request->validate([
		'name'     =>  'required',     
    ]);

		$branch->update($request->all());

		return response()->json([
		'data'     => $branch,
    'success'  =>   true
    ],200);
	}

  public function destroy(User $user,Branch $branch)
  {
    $branch->delete();
  }

  
}
