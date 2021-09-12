<?php

namespace App\Policies;

use App\Models\Collaboration;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PlaylistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Playlist $playlist)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Playlist $playlist)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Playlist $playlist)
    {
        return $user->id === $playlist->user_id ? Response::allow() : Response::deny('You can only delete your own playlists.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Playlist $playlist)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewSong(User $user, Playlist $playlist)
    {
        if ($user->id !== $playlist->user_id && Collaboration::haveCollaboration($user->id, $playlist->id)->first() === null) {
            return Response::deny('You can only view songs in your own playlists.');
        }

        return Response::allow();
    }
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addSong(User $user, Playlist $playlist, Song $song)
    {
        if ($playlist->user_id !== $user->id && Collaboration::haveCollaboration($user->id, $playlist->id)->first() === null) {
            return Response::deny('You can only add songs to your own playlists');
        }
        if ($playlist->songs()->where('song_id', $song->id)->get()->isNotEmpty()) {
            return Response::deny('Song already exists in playlist', 400);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can delete song in model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteSong(User $user, Playlist $playlist, Song $song)
    {
        if ($playlist->user_id !== $user->id && Collaboration::haveCollaboration($user->id, $playlist->id)->first() === null) {
            return Response::deny('You can only delete songs in your own playlists');
        }
        if ($playlist->songs()->where('song_id', $song->id)->get()->isEmpty()) {
            return Response::deny('Song does not exist in playlist', 400);
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Playlist $playlist)
    {
        //
    }
}
