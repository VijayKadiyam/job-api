<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sku;

class SkusController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  /*
   * To get all skus
     *
   *@
   */
  public function index()
  {
    $skus = request()->company->skus;

    return response()->json([
      'data'     =>  $skus
    ], 200);
  }

  /*
   * To store a new sku
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'    =>  'required'
    ]);

    $sku = new Sku($request->all());
    $request->company->skus()->save($sku);

    return response()->json([
      'data'    =>  $sku
    ], 201); 
  }

  /*
   * To view a single sku
   *
   *@
   */
  public function show(Sku $skus)
  {
    return response()->json([
      'data'   =>  $skus
    ], 200);   
  }

  /*
   * To update a sku
   *
   *@
   */
  public function update(Request $request, Sku $skus)
  {
    $request->validate([
      'name'  =>  'required',
    ]);

    $skus->update($request->all());
      
    return response()->json([
      'data'  =>  $skus
    ], 200);
  }


}
