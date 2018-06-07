<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favoritable;

class Reply extends Model
{
    use Favoritable, recordActivity;
    
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    
}
