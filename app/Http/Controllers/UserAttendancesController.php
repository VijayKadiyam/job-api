<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAttendance;

class UserAttendancesController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  /*
   * To get all user attendances
     *
   *@
   */
  public function index(Request $request)
  {
    $userAttendances = request()->user()->user_attendances;
    if($request->date)
      $userAttendances = $userAttendances->where('date', '=', $request->date)->toArray();

    return response()->json([
      'data'     =>  $userAttendances
    ], 200);
  }

  /*
   * To store a new user attendance
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'date'        =>  'required',
      'login_time'  =>  'required',
      // 'logout_time' =>  'required',
      // 'login_lat'   =>  'required',
      // 'login_lng'   =>  'required',
      // 'logout_lat'  =>  'required',
      // 'logout_lng'  =>  'required'
    ]);

    $userAttendance = new UserAttendance($request->all());
    $request->user()->user_attendances()->save($userAttendance);

    return response()->json([
      'data'    =>  $userAttendance
    ], 201); 
  }

  /*
   * To view a single user attendance
   *
   *@
   */
  public function show(UserAttendance $userAttendance)
  {
    return response()->json([
      'data'   =>  $userAttendance
    ], 200);   
  }

  /*
   * To update a user attendance
   *
   *@
   */
  public function update(Request $request, UserAttendance $userAttendance)
  {
    $request->validate([
      'date'        =>  'required',
      'login_time'  =>  'required',
      // 'logout_time' =>  'required',
      // 'login_lat'   =>  'required',
      // 'login_lng'   =>  'required',
      // 'logout_lat'  =>  'required',
      // 'logout_lng'  =>  'required'    
    ]);

    $userAttendance->update($request->all());
      
    return response()->json([
      'data'  =>  $userAttendance
    ], 200);
  }
}
