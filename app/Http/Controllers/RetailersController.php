<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Retailer;

class RetailersController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  /*
   * To get all retailers
     *
   *@
   */
  public function index()
  {
    $retailers = request()->company->retailers;

    return response()->json([
      'data'     =>  $retailers
    ], 200);
  }

  /*
   * To store a new retailer
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'    =>  'required',
      'address' =>  'required'
    ]);

    $retailer = new Retailer($request->all());
    $request->company->retailers()->save($retailer);

    return response()->json([
      'data'    =>  $retailer
    ], 201); 
  }

  /*
   * To view a single retailer
   *
   *@
   */
  public function show(Retailer $retailer)
  {
    return response()->json([
      'data'   =>  $retailer
    ], 200);   
  }

  /*
   * To update a retailer
   *
   *@
   */
  public function update(Request $request, Retailer $retailer)
  {
    $request->validate([
      'name'  =>  'required',
    ]);

    $retailer->update($request->all());
      
    return response()->json([
      'data'  =>  $retailer
    ], 200);
  }
}
