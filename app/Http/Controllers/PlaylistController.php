<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaylistRequest;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Auth::user()->collaborations()->playlist()->get()->map(function ($playlist) {
            $response['id'] = $playlist->id;
            $response['name'] = $playlist->name;
            $response['username'] = $playlist->user->username;
            return $response;
        });

        return response()->json(['status' => 'success', 'data' => ['playlists' => $playlists]], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlaylistRequest $request)
    {
        $validated = $request->validated();
        $playlist = Auth::user()->playlists()->create($validated);
        return response()->json(['status' => 'success', 'message' => 'playlist created', 'data' => ['playlistId' => $playlist->id]], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        $this->authorize('delete', $playlist);
        $playlist->delete();
        return response()->json(['status' => 'success', 'message' => 'playlist deleted'], 200);
    }
}
