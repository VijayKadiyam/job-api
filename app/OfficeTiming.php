<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeTiming extends Model
{
	protected $fillable = ['from','from_am_pm','to','to_am_pm'];

	public function user()
	{
	  return $this->belongsTo(User::class);
	}
    
}
