<?php

namespace App\Http\Controllers;

use App\Association;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Association[]|Collection
     */
    public function index()
    {
        return Association::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:255',
            'color' => 'required|size:7|starts_with:#',
            'president_id' => 'required|exists:users,id'
        ]);

        Association::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param Association $association
     * @return Association
     */
    public function show(Association $association)
    {
        return $association;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Association $association
     * @return void
     */
    public function update(Request $request, Association $association)
    {
        $validated = $request->validate([
            'name' => 'min:2|max:255',
            'color' => 'size:7|starts_with:#',
            'president_id' => 'exists:users,id'
        ]);

        $association->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Association $association
     * @return void
     * @throws Exception
     */
    public function destroy(Association $association)
    {
        $association->delete();
    }
}
