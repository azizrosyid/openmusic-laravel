<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Collaboration extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['playlist_id', 'user_id'];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePlaylist($query)
    {
        return $query->rightJoin('playlists', 'playlists.id', '=', 'collaborations.playlist_id')->where('collaborations.user_id', Auth::user()->id)->orwhere('playlists.user_id', Auth::user()->id);
    }

    public function scopeHaveCollaboration($query, $user_id, $playlist_id)
    {
        return $query->where('user_id', $user_id)->where('playlist_id', $playlist_id);
    }
}
