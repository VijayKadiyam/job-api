<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
  protected $fillable = ['name'];

  public function companies()
  {
    return $this->belongsTo(Company::class);
  }
   public function users()
  {
    return $this->belongsToMany(User::class);      
  }
}
