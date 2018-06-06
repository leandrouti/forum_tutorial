<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    
    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Favorite', 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => Auth()->id()];
        if(! $this->favorites()->where($attributes)->exists())
        {
            return $this->favorites()->create($attributes);
        }
        
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', Auth()->id())->exists();
    }
}
