<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Affiliation;
use App\User;

class AffiliationsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index(Request $request)
  {
    $count = 0;
    if($request->search) {
      $affiliations = request()->company->affiliations()
        ->where('name', 'LIKE', '%' . $request->search . '%')
        ->get();
      $count = $affiliations->count();
    }
    else if($request->page && $request->rowsPerPage != -1) {
      $affiliations = request()->company->affiliations();
      $count = $affiliations->count();
      $affiliations = $affiliations->paginate($request->rowsPerPage)->toArray();
      $affiliations = $affiliations['data'];
    }
    else {
      $affiliations = request()->company->affiliations;
      $count = $affiliations->count();
    }

    return response()->json([
      'data'  =>  $affiliations,
      'count' =>  $count
    ], 200);
  }


  public function store(Request $request)
  {
    $request->validate([
      'name'   => 'required',
    ]);

    $affiliation = new Affiliation($request->all());

    $request->company->affiliations()->save($affiliation);

    return response()->json([
      'data'    =>  $affiliation,
      'success' =>  true
    ], 201); 
  }

  public function show(Affiliation $affiliation)
  {
    return response()->json([
      'data'     =>  $affiliation,
      'success'  =>   true
    ], 200);   
  }

  public function update(Request $request, Affiliation $affiliation)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $affiliation->update($request->all());
      
    return response()->json([
      'data'     =>  $affiliation,
      'success'  =>   true
    ], 200);
  }

  public function destroy(Affiliation $affiliation)
  {
    $affiliation->delete();
  }
  
}
