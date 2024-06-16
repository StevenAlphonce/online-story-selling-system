<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    /**Establishes relationship of prices to a story */
    public function story()
    {
        return $this->belongsTo(Story::class, 'stories_id');
    }
}
