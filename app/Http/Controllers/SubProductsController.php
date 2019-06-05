<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubProduct;

class SubProductsController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company'])
      ->except(['index', 'show']);
  }

  /*
   * To get all sub products
     *
   *@
   */
  public function index(Product $product)
  {
    $sub_products = $product->sub_products;

    return response()->json([
      'data'     =>  $sub_products
    ], 200);
  }

  /*
   * To store a new sub product
   *
   *@
   */
  public function store(Request $request, Product $product, SubProduct $subProduct)
  {
    $request->validate([
      'name'    =>  'required',
      'position'    =>  'required',
    ]);

    $sub_product = new SubProduct($request->all());
    $product->sub_products()->save($sub_product);

    return response()->json([
      'data'    =>  $sub_product
    ], 201); 
  }
}
