<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use APp\Stock;
use App\Sale;

class SalesController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  /*
   * To get all sales of stock
     *
   *@
   */
  public function index(Stock $stock)
  {
    $sales = $stock->sales;

    return response()->json([
      'data'     =>  $sales
    ], 200);
  }

  /*
   * To store a new sale
   *
   *@
   */
  public function store(Request $request, Stock $stock)
  {
    $request->validate([
      'qty'    =>  'required',
      'stock_id'  =>   'required',
      'retailer_id'  =>   'required'
    ]);

    $sale = new Sale($request->all());
    $stock->sales()->save($sale);

    return response()->json([
      'data'    =>  $sale
    ], 201); 
  }

  /*
   * To view a single sale
   *
   *@
   */
  public function show(Stock $stock, Sale $sale)
  {
    return response()->json([
      'data'   =>  $sale
    ], 200);   
  }

  /*
   * To update a sale
   *
   *@
   */
  public function update(Request $request, Stock $stock, Sale $sale)
  {
    $request->validate([
      'qty'  =>  'required',
    ]);

    $sale->update($request->all());
      
    return response()->json([
      'data'  =>  $sale
    ], 200);
  }
}
