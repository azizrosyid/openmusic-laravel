<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyCollaborationRequest;
use App\Http\Requests\StoreCollaborationRequest;
use App\Models\Collaboration;
use Illuminate\Http\Request;

class CollaborationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreCollaborationRequest $request)
    {
        $validated = $request->validated();
        $this->authorize('create', [Collaboration::class, $validated['playlistId'], $validated['userId']]);
        $collaboration = Collaboration::create(['user_id' => $validated['userId'], 'playlist_id' => $validated['playlistId']]);
        return response()->json(['status' => 'success', 'message' => 'Collaboration created successfully', 'data' => ['colaborationId' => $collaboration->id]], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function show(Collaboration $collaboration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function edit(Collaboration $collaboration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collaboration $collaboration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collaboration  $collaboration
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyCollaborationRequest $collaboration)
    {
        $validated = $collaboration->validated();
        $this->authorize('delete', [Collaboration::class, $validated['playlistId'], $validated['userId']]);
        Collaboration::haveCollaboration($validated['userId'], $validated['playlistId'])->delete();

        return response()->json(['status' => 'success', 'message' => 'Collaboration deleted successfully'], 200);
    }
}
