<?php

namespace App\Http\Controllers;

use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Material[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Material::all();
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
           'desc' => 'min:2|max:255',
           'price' => 'min:1|max:255',
           'association_id' => 'required|exists:associations,id'
        ]);

        Material::create($validated);
        return response()->json(['created'=>true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Material $material
     * @return Material
     */
    public function show(Material $material)
    {
        return $material;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
           'name' => 'min:2|max:255',
           'desc' => 'min:2|max:255',
           'price' => 'min:1|max:255',
        ]);

        $material->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Material $material
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
