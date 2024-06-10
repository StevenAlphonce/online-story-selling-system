<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['photo', 'about', 'user_id', 'country', 'address', 'phone', 'social_media'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
