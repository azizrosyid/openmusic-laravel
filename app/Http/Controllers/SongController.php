<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::all(["id", 'title', 'performer']);
        return response()->json(["status" => "success", "data" => ["songs" => $songs]], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongRequest $request)
    {
        $validated = $request->validated();
        $song = Song::create($validated);
        return response()->json([
            "status" => "success",
            "message" => "Song created successfully",
            "data" => [
                "songId" => $song->id,
            ]
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        return response()->json([
            "status" => "success",
            "data" => [
                "song" => $song,
            ]
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        $validated = $request->validated();
        $song->update($validated);
        return response()->json(['status' => 'success', 'message' => 'song updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        $song->delete();
        return response()->json(['status' => 'success', 'message' => 'song deleted successfully'], 200);
    }
}
