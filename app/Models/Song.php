<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "title",
        "year",
        "performer",
        "genre",
        "duration",
    ];

    protected $hidden = ['pivot'];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)->withTimestamps();
    }
}
