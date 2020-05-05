<?php

namespace App\Http\Controllers;

use App\Association;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Option[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Option::all();
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
           'association_id' => 'required|exists:associations,id'
        ]);

        $user = Auth::user();

        if($user != null){
            if($user->role == 'ROLE_ADMIN' || $user->id == Association::find($validated['association_id'])->president_id){
                Option::create($validated);
                return response()->json(['created'=>true], 200);
            }
        }
        return response()->json(['error'=>'User is unauthorized'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param Option $option
     * @return Option
     */
    public function show(Option $option)
    {
        return $option;
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
     * @param Option $option
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Option $option)
    {
        $validated = $request->validate([
           'name' => 'required|min:2|max:255'
        ]);

        $option->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Option $option
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Option $option)
    {
        $option->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
