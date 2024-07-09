<?php

namespace App\Models;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    /**Establishes relationship of prices to a chapter */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
