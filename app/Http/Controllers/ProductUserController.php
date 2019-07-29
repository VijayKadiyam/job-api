<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;

class ProductUserController extends Controller
{
  /*
   * Assign role to user
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
        'user_id'        =>  'required',
        'product_id'        =>  'required'
    ]);

    $user =  User::find($request->user_id);
    $product =  Product::find($request->product_id);
    $user->assignProduct($product->id);
    $productUser = User::with('products')->find($request->user_id);

    return response()->json([
    'data'    =>  $productUser,
    'success' =>  true
    ], 201); 
  }
}
