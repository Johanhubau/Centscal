<?php

namespace App\Http\Controllers;

use App\Occupation;
use Illuminate\Http\Request;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Occupation[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Occupation::all();
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
           'room_id' => 'required|exists:rooms,id',
           'event_id' => 'required|exists:events,id',
            'approved' => 'min:0|max:2'
        ]);

        Occupation::create($validated);
        return response()->json(['created'=>true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Occupation $occupation
     * @return Occupation
     */
    public function show(Occupation $occupation)
    {
        return $occupation;
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
     * @param Occupation $occupation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Occupation $occupation)
    {
        $validated = $request->validate([
           'approved' => 'required|min:0|max:2'
        ]);

        $occupation->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Occupation $occupation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Occupation $occupation)
    {
        $occupation->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
