<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    /**The chapter that belogs to story */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

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


    //Chapter visitors relationship
    public function visits()
    {
        return $this->hasMany(ChapterVisit::class);
    }
}
