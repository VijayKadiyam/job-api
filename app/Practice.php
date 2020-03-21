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
  public function assignUser($user)
  {
    return $this->users()->sync([$user]);
  }

  public function hasUser($user)
  {
    return $this->users ? in_array($user, $this->users->pluck('id')->toArray()) : false;
  }

  public function users()
  {
    return $this->belongsToMany(User::class , 'user_practice');
  }

 public function jobs()
{
  return $this->hasMany(Job::class);
}

}
