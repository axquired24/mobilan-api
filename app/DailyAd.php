<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DailyAd extends Model
{
	public function MoberId(){
	    return $this->belongsTo(Mober::class);
	}

	public function AdId(){
	    return $this->belongsTo(Ad::class);
	}
}
