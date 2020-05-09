<?php

namespace App\Http\Controllers;

use App\Association;
use App\Event;
use App\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Rent[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Rent::all();
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
           'event_id' => 'required|exists:events,id',
           'material_id' => 'required|exists:materials,id',
            'approved' => 'min:0|max:2'
        ]);

        $user = Auth::user();

        if($user != null) {
            if ($user->id == Association::find(Event::find($validated['event_id'])->association_id)->president_id || $user->role == 'ROLE_ADMIN') {
                Rent::create($validated);
                return response()->json(['created' => true], 200);
            }
        }
        return response()->json(['error'=>'User is unauthorized'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param Rent $rent
     * @return Rent
     */
    public function show(Rent $rent)
    {
        return $rent;
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
     * @param Rent $rent
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Rent $rent)
    {
        $validated = $request->validate([
            'approved' => 'required|min:0|max:2'
        ]);

        $rent->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rent $rent
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Rent $rent)
    {
        $rent->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
