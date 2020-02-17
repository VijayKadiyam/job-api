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
    
    $affiliations = request()->company->affiliations;

    return response()->json([
      'data'     =>  $affiliations,
      'success'  =>   true
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
      'success' =>  'true'
    ], 201); 
  }
   public function show(Affiliation $affiliation)
  {
    return response()->json([
      'data'   =>  $affiliation
    ], 200);   
  }

  public function update(Request $request, Affiliation $affiliation)
  {
    $request->validate([
      'name'    => 'required',
     ]);

    $affiliation->update($request->all());
      
    return response()->json([
      'data'  =>  $affiliation
    ], 200);
  }

  public function destroy(Affiliation $affiliation)
  {
    $affiliation->delete();
  }
  
}
