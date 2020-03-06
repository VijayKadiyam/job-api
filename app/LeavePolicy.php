<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeavePolicy extends Model
{
   protected $fillable = ['exam','ipcc_group_1','ipcc_group_2','ca_final_group_1','ca_final_group_2','ipcc_both_groups','ca_final_both_groups'];

	public function user()
	{
	  return $this->belongsTo(User::class);
	}
}
