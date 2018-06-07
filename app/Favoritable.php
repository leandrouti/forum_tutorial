<?php
    namespace App;

trait Favoritable{
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
        return !! $this->favorites->where('user_id', Auth()->id())->count();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }
}

?>