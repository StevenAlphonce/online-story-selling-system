<?php

namespace App\Models;

use App\Models\Story;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The stories that belong to the category.
     */
    public function stories()
    {
        return $this->belongsToMany(Story::class);
    }
}
