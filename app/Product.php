<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
    'name', 'position'
  ];

  /*
   * A product belongs to many users
   *
   *@
   */
  public function users()
  {
    return $this->belingsToMany(User::class);
  }

  /*
   * A product belongs to Listing
   *
   *@
   */
  public function listing()
  {
    return $this->belongsTo(Listing::class); 
  }

  /*
   * A product has many sub product
   *
   *@
   */
  public function sub_products()
  {
    return $this->hasMany(SubProduct::class);
  }
}
