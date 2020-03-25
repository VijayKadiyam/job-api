<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
  protected $fillable = ['name'];

  public function company()
  {
  	return $this->belongsTo(Company::class);
  }
  
 public function jobs()
 {
  return $this->hasMany(Job::class);
 }

public function users()
{
  return $this->hasMany(User::class);
}

}
