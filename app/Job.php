<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
 protected $fillable = ['user_id','qualification_id','title','highlight','no_of_openings','experience','address','stipend_start','stipend_end','department','max_attempts_in_ca_exam','status'];

public function companies()
{
	return $this->belongsTo(Company::class);
}

public function users()
{
  return $this->hasMany(User::class);
}

public function qualifications()
{
	return $this->belongsTo(Qualification::class);
}

 public function practices()
{
  return $this->hasMany(Practice::class);
}

}
