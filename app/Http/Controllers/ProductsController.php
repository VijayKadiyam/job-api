<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Listing;

class ProductsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company'])
      ->except(['index', 'show']);
  }

  /*
   * To get all products
     *
   *@
   */
  public function index(Listing $listing)
  {
    $products = $listing->products;

    return response()->json([
      'data'     =>  $products
    ], 200);
  }

  /*
   * To store a new product
   *
   *@
   */
  public function store(Request $request, Listing $listing)
  {
    $request->validate([
      'name'    =>  'required',
      'position'    =>  'required',
    ]);

    $product = new Product($request->all());
    $listing->products()->save($product);

    return response()->json([
      'data'    =>  $product
    ], 201); 
  }

  /*
   * To view a single company designation
   *
   *@
   */
  public function show(Listing $listing, Product $product)
  {
    return response()->json([
      'data'   =>  $product
    ], 200);   
  }

  /*
   * To update a product
   *
   *@
   */
  public function update(Request $request, Listing $listing, Product $product)
  {
    $request->validate([
      'name'  =>  'required',
    ]);

    $product->update($request->all());
      
    return response()->json([
      'data'  =>  $product
    ], 200);
  }

}
