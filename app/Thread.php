<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];
    
    public function path()
    {
        return '/threads/' . $this->id;
    }

    public function replies(){
        return $this->hasMany('App\Reply')->orderBy('created_at', 'desc');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function addReply($reply){
        $this->replies()->create($reply);
    }
}
