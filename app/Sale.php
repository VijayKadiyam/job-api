<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $fillable = [
    'qty', 'retailer_id'
  ];

  /*
   * A sale belongs to stock
   *
   *@
   */
  public function stock()
  {
    return $this->belongsTO(Stock::class);
  }

  /*
   * A sale belongs to retailer
   *
   *@
   */
  public function retailer()
  {
    return $this->belongsTo(Retailer::class);
  }
}
