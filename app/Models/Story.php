<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory;


    /**
     * Accessor for readable updated_at attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        // Use Carbon (included with Laravel) to format the date
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    /**
     * Get the user that owns the story.
     */

    public function user()
    {

        return $this->belongsTo(User::class);
    }


    /**
     * The categories that belong to the story.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /** Establishes relationship between this story with its chapters */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
