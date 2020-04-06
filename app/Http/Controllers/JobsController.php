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
    $count = 0;
    if($request->search) {
      $jobs = request()->company->jobs()
        ->where('title', 'LIKE', '%' . $request->search . '%')
        ->get();
      $count = $jobs->count();
    }
    else if($request->page && $request->rowsPerPage != -1) {
      $jobs = request()->company->jobs();
      $count = $jobs->count();
      $jobs = $jobs->paginate($request->rowsPerPage)->toArray();
      $jobs = $jobs['data'];
    }
    else {
      $jobs = request()->company->jobs;
      $count = $jobs->count();
    }

    return response()->json([
      'data'  =>  $jobs,
      'count' =>  $count
    ], 200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required', 
    ]);

    $job = new Job($request->all());

    $request->company->jobs()->save($job);

    return response()->json([
    'data'     => $job->toArray(),
    'success'  =>   true
  	],201);
  }

  public function show(Job $job)
  { 
    $job->practices = $job->practices;
    
    return response()->json([
      'data'     =>  $job,
      'success'  =>   true
    ], 200);   
  }

  public function update(Request $request, Job $job)
  {
    $request->validate([
     
      'title' => 'required',
  ]);

    $job->update($request->all());

    return response()->json([
     'data'     => $job,
     'success'  =>   true
    ],200);
  }

  public function destroy(Job $job)
  {
    $job->delete();
  }
}
