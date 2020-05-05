<?php

namespace App\Http\Controllers;

use App\Association;
use App\Material;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Member[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Member::all();
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
           'role' => 'min:2|max:255',
           'desc' => 'min:2|max:255',
           'user_id' => 'required|exists:users,id',
           'association_id' => 'required|exists:associations,id'
        ]);

        $user = Auth::user();
        if($user != null){
            if($user->id == Association::find($validated['association_id'])->president_id || $user->role=='ROLE_ADMIN'){
                Member::create($validated);
                return response()->json(['created'=>true], 200);
            }
        }
        return response()->json(['error'=>'User is unauthorized'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param Member $member
     * @return Member
     */
    public function show(Member $member)
    {
        return $member;
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
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
           'desc' => 'min:2|max:255',
           'role' => 'min:2|max:255'
        ]);

        $member->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member $member
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
