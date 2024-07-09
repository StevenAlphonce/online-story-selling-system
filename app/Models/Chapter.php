<?php

namespace App\Models;

use App\Models\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
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

    /**The chapter that belogs to story */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    //Chapter visitors relationship
    public function visits()
    {
        return $this->hasMany(ChapterVisit::class);
    }

    /**Story stracks all its chapters prices */
    public function price()
    {
        return $this->hasOne(Price::class);
    }
}
