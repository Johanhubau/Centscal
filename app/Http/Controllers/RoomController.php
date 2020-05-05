<?php

namespace App\Http\Controllers;

use App\Association;
use App\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Room[]|Collection
     */
    public function index()
    {
        return Room::all();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'location' => 'min:2|max:255',
            'owner_id' => 'required|exists:associations,id',
        ]);

        $user = Auth::user();

        if($user != null){
            if($user->role == 'ROLE_ADMIN' || $user->id == Association::find($validated['owner_id'])->president_id){
                Room::create($validated);
                return response()->json(['created'=>true], 200);
            }
        }
        return response()->json(['error'=>'User is unauthorized'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return Room
     */
    public function show(Room $room)
    {
        return $room;
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
     * @param \Illuminate\Http\Request $request
     * @param Room $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
           'name' => 'min:2|max:255',
           'location' => 'min:2|max:255',
        ]);

        $room->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
