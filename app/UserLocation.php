<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
  protected $fillable = [
    'content'
  ];

  /*
   * A user location belongs to user
   *
   *@
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
