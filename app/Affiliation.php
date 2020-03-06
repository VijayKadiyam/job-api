<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
  protected $fillable = ['name'];

  public function company()
  {
    return $this->belongsTo(Company::class);
  }
   public function users()
  {
    return $this->hasMany(User::class);      
  }
}
