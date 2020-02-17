<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{

  protected $fillable = ['name'];

  public function companies()
  {
    return $this->belongsTo(Company::class);
  }

  public function users()
  {
    return $this->belongsToMany(User::class, 'user_day');
  }

  public function hasUser($users)
  {
    return $this->users ? in_array($users, $this->users->pluck('id')->toArray()) : false;
  }

   public function assignUser($user)
  {
    return $this->users()->sync([$user]);
  }
 
}
