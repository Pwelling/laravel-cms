<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $fillable = ['name'];
    function getPages(){
    	return $this->hasMany('App\Page');
    }
	
}
