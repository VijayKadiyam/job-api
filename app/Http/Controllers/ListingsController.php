<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;

class ListingsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  /*
   * To get all listings
     *
   *@
   */
  public function index()
  {
    $listings = request()->company->listings;

    return response()->json([
      'data'     =>  $listings
    ], 200);
  }

  /*
   * To store a new listing
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'    =>  'required'
    ]);

    $listing = new Listing($request->all());
    $request->company->listings()->save($listing);

    return response()->json([
      'data'    =>  $listing,
      'success' =>  'true'
    ], 201); 
  }

  /*
   * To view a single listing
   *
   *@
   */
  public function show(Listing $listing)
  {
    return response()->json([
      'data'   =>  $listing
    ], 200);   
  }

  /*
   * To update a listing
   *
   *@
   */
  public function update(Request $request, Listing $listing)
  {
    $request->validate([
      'name'  =>  'required',
    ]);

    $listing->update($request->all());
      
    return response()->json([
      'data'  =>  $listing
    ], 200);
  }
}
