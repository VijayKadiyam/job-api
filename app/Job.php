<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
 protected $fillable = ['user_id','qualification_id','title','highlight','no_of_openings','experience','address','stipend_start','stipend_end','department','max_attempts_in_ca_exam','status'];

public function company()
{
	return $this->belongsTo(Company::class);
}

public function user()
{
  return $this->belongsTo(User::class);
}

public function qualification()
{
	return $this->belongsTo(Qualification::class);
}

 public function practices()
  {
    return $this->belongsToMany(Practice::class);
  }

  public function hasPractice($practices)
  {
    return $this->practices ? in_array($practices, $this->practices->pluck('id')->toArray()) : false;
  }

   public function assignPractice($practice)
  {
    return $this->practices()->sync($practice);
  }




}
