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

    foreach($listings as $listing) {
      foreach($listing->products as $product) {
        foreach($product->sub_products as $sub_product) {
          if($sub_product->email_html) {
            $html = new \voku\Html2Text\Html2Text($sub_product->email_html);
            $sub_product['email_text'] = $html->getText();
          }
          else
            $sub_product['email_text'] = '';
        }
      }
    }

    return response()->json([
      'data'     =>  $listings,
      'success'  =>   true
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
