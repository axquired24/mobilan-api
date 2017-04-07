<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ad extends Model
{
	public function AdserId(){
	    return $this->belongsTo(Adser::class);
	}

	public function MoberId(){
	    return $this->belongsTo(Mober::class);
	}
}
