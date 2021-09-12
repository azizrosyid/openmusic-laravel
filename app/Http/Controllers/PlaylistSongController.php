<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;

class PlaylistSongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Playlist $playlist)
    {
        $this->authorize('viewSong', $playlist);
        return response()->json(['status' => 'success', 'data' => ['songs' => $playlist->songs()->get(['songs.id', 'title', 'performer'])]]);
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
    public function store(Playlist $playlist, Song $song)
    {
        $this->authorize('addSong', [Playlist::class, $playlist, $song]);
        $playlist->songs()->attach($song);
        return response()->json(['message' => 'Song added to playlist', 'status' => 'success'], 201);
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
    public function destroy(Playlist $playlist, Song $song)
    {
        $this->authorize('deleteSong', [Playlist::class, $playlist, $song]);
        $playlist->songs()->detach($song);
        return response()->json(['message' => 'Song removed from playlist', 'status' => 'success'], 200);
    }
}
