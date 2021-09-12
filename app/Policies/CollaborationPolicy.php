<?php

namespace App\Policies;

use App\Models\Collaboration;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CollaborationPolicy
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
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Collaboration $collaboration)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $playlist_id, $user_collaborator_id)
    {
        if (Collaboration::haveCollaboration($user_collaborator_id, $playlist_id)->get()->isNotEmpty()) {
            return Response::deny('You already have a collaboration with this playlist.');
        }

        if ($user->id !== Playlist::find($playlist_id)->user_id) {
            return Response::deny('You are not owner of this playlist.');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Collaboration $collaboration)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, $playlist_id, $user_collaborator_id)
    {
        $playlist_user_id = Playlist::find($playlist_id)->user_id;
        if ($user->id !== $playlist_user_id) {
            return Response::deny('You are not the owner of this playlist.');
        }

        if (Collaboration::haveCollaboration($user_collaborator_id, $playlist_id)->first() === null) {
            return Response::deny('No collaboration with this playlist.');
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Collaboration $collaboration)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Collaboration $collaboration)
    {
        //
    }
}
