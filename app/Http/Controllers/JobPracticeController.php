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
        'practice_ids'   =>  'required',
        'job_id'        =>  'required'
    ]);

    $job =  Job::find($request->job_id);

    //$job =  Job::find($request->job_id);

    $job->assignPractice($request->practice_ids);
    
    $practiceJob = Job::with('practices')->find($request->job_id);

    return response()->json([
    'data'    =>  $practiceJob,
    'success' =>  true
    ], 201); 
  }
}
