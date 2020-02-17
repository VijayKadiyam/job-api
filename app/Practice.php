<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
  protected $fillable = ['name'];

  public function companies()
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
    return $this->belongsToMany(Job::class);
  }

  public function hasJob($jobs)
  {
    return $this->jobs ? in_array($jobs, $this->jobs->pluck('id')->toArray()) : false;
  }

   public function assignJob($job)
  {
    return $this->jobs()->sync([$job]);
  }

}
