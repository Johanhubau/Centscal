<?php

namespace App\Http\Controllers;

use App\Association;
use App\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->has(['begin', 'end'])) {
            $begin = $request->get("begin");
            $end = $request->get("end");

            return EventResource::collection(Event::all()
                ->whereBetween('begin', [$begin, $end])
                ->reject(function ($event) {
                    $rents = $event->rents;
                    foreach($rents as $rent){
                        if($rent->approved != 1){
                            return true;
                        }
                    }
                    $occupations = $event->occupations;
                    foreach($occupations as $occupation){
                        if($occupation->approved != 1){
                            return true;
                        }
                    }
                    return false;
                })
                );
        }

        return EventResource::collection(Event::all()
            ->reject(function ($event) {
                $rents = $event->rents;
                foreach($rents as $rent){
                    if($rent->approved != 1){
                        return true;
                    }
                }
                $occupations = $event->occupations;
                foreach($occupations as $occupation){
                    if($occupation->approved != 1){
                        return true;
                    }
                }
                return false;
            })
            );
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
           'title' => 'required|min:2|max:255',
           'desc' => 'min:2|max:255',
            'begin' => 'required|date',
            'end' => 'required|date',
            'link' => 'url',
            'location' => 'min:2|max:255',
            'association_id' => 'required|exists:associations,id'
        ]);

        $user = Auth::user();
        $association = Association::findOrFail($validated['association_id']);

        if($user != null){
            if($user->id == $association->president_id || $association->members->contains($user->memberships) || $user->role=='ROLE_ADMIN'){
                $event = Event::create($validated);
                return response()->json(['created'=>true, 'id'=>$event->id], 200);
            }
        }
        return response()->json(['error'=>'User is unauthorized'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Event
     */
    public function show(Event $event)
    {
        return $event;
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
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'min:2|max:255',
            'desc' => 'min:2|max:255',
            'begin' => 'date',
            'end' => 'date',
            'link' => 'url',
            'location' => 'min:2|max:255',
            'association_id' => 'exists:associations,id'
        ]);

        $event->update($validated);
        return response()->json(['updated'=>true], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['deleted'=>true], 200);
    }
}
