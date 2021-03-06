<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Practice;
use App\User;

class PracticesController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index(Request $request)
  {
    $count = 0;
    if($request->search) {
      $practices = request()->company->practices()
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->get();
      $count = $practices->count();
    }
    else if($request->page && $request->rowsPerPage != -1) {
      $practices = request()->company->practices();
      $count = $practices->count();
      $practices = $practices->paginate($request->rowsPerPage)->toArray();
      $practices = $practices['data'];
    }
    else {
      $practices = request()->company->practices;
      $count = $practices->count();
    }

    return response()->json([
      'data'  =>  $practices,
      'count' =>  $count
    ], 200);
  }

  public function store(Request $request)
  {
    $request->validate([
      'name'   => 'required',
    ]);

    $practice = new Practice($request->all());

    $request->company->practices()->save($practice);

    return response()->json([
      'data'    =>  $practice,
      'success' =>  true
    ], 201); 
  }

  public function show(Practice $practice)
  {    
    return response()->json([
      'data'     =>  $practice,
      'success'  =>   true
    ], 200);   
  }

  public function update(Request $request, Practice $practice)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $practice->update($request->all());
      
    return response()->json([
      'data'     =>  $practice,
      'success'  =>   true
    ], 200);
  }

  public function destroy(Practice $practice)
  {
    $practice->delete();
  }

}
