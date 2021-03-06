<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use recordActivity;
    
    protected $guarded = [];
    protected $with = ['owner', 'channel'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function($builder){
            $builder->withCount('replies');
        });

        static::deleting(function($thread){
            $thread->replies()->delete();
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/$this->id";
    }

    public function replies(){
        return $this->hasMany('App\Reply');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function addReply($reply){
        $this->replies()->create($reply);
    }

    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
