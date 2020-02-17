<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = ['name'];

  public function companies()
  {
    	return $this->belongsTo(Company::class);
  }
  public function jobs()
  {
    return $this->hasMany(Job::class);
  }
}
