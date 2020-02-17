<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Practice;
use App\Job;

class JobPracticeController extends Controller
{
    /*
   * Assign job to practice
   *
   *@
   */
  public function store(Request $request)
  {

    $request->validate([
        'practice_id'   =>  'required',
        'job_id'        =>  'required'
    ]);

    $practice =  Practice::find($request->practice_id);

    $job =  Job::find($request->job_id);

    $practice->assignJob($job->id);
    
    $jobPractice = Practice::with('jobs')->find($request->practice_id);

    return response()->json([
    'data'    =>  $jobPractice,
    'success' =>  true
    ], 201); 
  }
}
