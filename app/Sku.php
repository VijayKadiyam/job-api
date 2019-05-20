<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
  protected $fillable = [
    'name', 'sku_type_id'
  ];

  /*
   * A company state belongs to company
   *
   *@
   */
  public function company()
  {
    return $this->belongsTo(Company::class);
  }

  /*
   * A sku has many stocks
   *
   *@
   */
  public function stocks()
  {
    return $this->hasMany(Stock::class)
      ->with('sku', 'sku_type', 'offer');
  }
}
