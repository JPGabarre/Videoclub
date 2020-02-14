<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Review;

class Movie extends Model
{
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
