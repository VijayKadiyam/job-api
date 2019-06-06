<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
  protected $fillable = [
    'name'
  ];  

  /*
   * A listing belongs to company
   *
   *@
   */
  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  /*
   * A listing has many products
   *
   *@
   */
  public function products()
  {
    return $this->hasMany(Product::class)
      ->with('sub_products');
  }
}
