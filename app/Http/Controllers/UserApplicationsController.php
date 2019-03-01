<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserApplication;

class UserApplicationsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  /*
   * To get all user applications
     *
   *@
   */
  public function index()
  {
    $userApplications = request()->user()->user_applications;

    return response()->json([
      'data'     =>  $userApplications
    ], 200);
  }

  /*
   * To store a new user application
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'company_leave_id'  =>  'required',
      'from_date'         =>  'required',
      'to_date'           =>  'required',
    ]);

    $userApplication = new UserApplication($request->all());
    $request->user()->user_attendances()->save($userApplication);

    return response()->json([
      'data'    =>  $userApplication
    ], 201); 
  }

  /*
   * To view a single user application
   *
   *@
   */
  public function show(UserApplication $userApplication)
  {
    return response()->json([
      'data'   =>  $userApplication
    ], 200);   
  }

  /*
   * To update a user application
   *
   *@
   */
  public function update(Request $request, UserApplication $userApplication)
  {
    $request->validate([
      'company_leave_id'  =>  'required',
      'from_date'         =>  'required',
      'to_date'           =>  'required',   
    ]);

    $userApplication->update($request->all());
      
    return response()->json([
      'data'  =>  $userApplication
    ], 200);
  }

}
