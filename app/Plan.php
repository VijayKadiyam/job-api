<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
  protected $fillable = [
    'date', 'plan'
  ];  

  /*
   * A plan belongs to company
   *
   *@
   */
  public function company()
  {
    return $this->belongsTo(Company::class);
  }
}
