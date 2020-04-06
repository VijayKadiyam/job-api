<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Qualification;
use App\User;

class QualificationsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index(Request $request)
  {
    $count = 0;
    if($request->search) {
      $qualifications = request()->company->qualifications()
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->get();
      $count = $qualifications->count();
    }
    else if($request->page && $request->rowsPerPage != -1) {
      $qualifications = request()->company->qualifications();
      $count = $qualifications->count();
      $qualifications = $qualifications->paginate($request->rowsPerPage)->toArray();
      $qualifications = $qualifications['data'];
    }
    else {
      $qualifications = request()->company->qualifications;
      $count = $qualifications->count();
    }

    return response()->json([
      'data'  =>  $qualifications,
      'count' =>  $count
    ], 200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name'   => 'required',
    ]);

    $qualification = new Qualification($request->all());
    $request->company->qualifications()->save($qualification);
    return response()->json([
      'data'    =>  $qualification,
      'success' =>  true
    ], 201); 
  }
  
  public function show(Qualification $qualification)
  {
    return response()->json([
      'data'     =>  $qualification,
      'success'  =>   true
    ], 200);   
  }

  public function update(Request $request, Qualification $qualification)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $qualification->update($request->all());
      
    return response()->json([
      'data'     =>  $qualification,
      'success'  =>   true
    ], 200);
  }

  public function destroy(Qualification $qualification)
  {
    $qualification->delete();
  }

}
