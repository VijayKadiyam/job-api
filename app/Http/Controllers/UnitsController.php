<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;

class UnitsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function index()
  {
    $units = request()->company->units;

    return response()->json([
      'data'     =>  $units
    ], 200);
  }

  public function store(Request $request)
  {
    $unit = new Unit($request->all());
    $request->company->units()->save($unit);

    return response()->json([
      'data'    =>  $unit
    ], 201); 
  }

  public function show(Unit $unit)
  {
    return response()->json([
      'data'   =>  $unit
    ], 200);   
  }

  public function update(Request $request, Unit $unit)
  {
    $unit->update($request->all());
      
    return response()->json([
      'data'  =>  $unit
    ], 200);
  }
}
