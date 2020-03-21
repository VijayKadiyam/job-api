<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Job;
use App\Qualification;
use App\User;


class JobsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index(Request $request)
  { 
    $jobs = request()->company->jobs;

    return response()->json([
      'data'     =>  $jobs,
      'success'  =>   true
    ], 200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'title'       => 'required', 
    ]);

    $job = new Job($request->all());

    $request->company->jobs()->save($job);

    return response()->json([
    'data' => $job->toArray()
  	],201);
  }

  public function show(Job $job)
  { 

    $job->practices = $job->practices;
    
    return response()->json([
      'data'   =>  $job
    ], 200);   
  }

  public function update(Request $request, Job $job)
  {
    $request->validate([
     
      'title'       => 'required',
  ]);

    $job->update($request->all());

    return response()->json([
     'data' => $job],
     200);
  }

  public function destroy(Job $job)
  {
    $job->delete();
  }
}
