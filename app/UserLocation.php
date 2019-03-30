<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
  protected $fillable = [
    'content'
  ];

  protected $casts = [
     'content' => 'array'
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
