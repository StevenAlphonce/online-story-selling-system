<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'user_id'
    ];
}
