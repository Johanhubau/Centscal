@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <association-dashboard
                    v-bind:association="{{$association}}"
                    v-bind:users="{{App\User::all('id', 'first_name', 'last_name')}}"
                    first_name="{{Auth::user()->first_name}}"
                    last_name="{{Auth::user()->last_name}}"
                ></association-dashboard>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col>
                <v-row align="center" justify="space-between" class="px-5">
                    <v-card-title>Latest 3 events</v-card-title>
                    <v-btn
                        class="mr-4"
                        href="/association/{{$association->id}}/events"
                    >
                        See all Events
                    </v-btn>
                </v-row>
                @foreach($association->events->reverse() as $event)
                    <private-event-card
                        v-bind:event="{{$event}}"
                        v-bind:materials="{{$event->materials}}"
                        v-bind:rents="{{$event->rents}}"
                        @if($event->occupation != null)
                        v-bind:room="{{$event->room}}"
                        v-bind:occupation="{{$event->occupation}}"
                        @else
                        room=""
                        occupation=""
                        @endif
                    ></private-event-card>
                    @if ($loop->iteration == 3)
                        @break
                    @endif
                @endforeach
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col>
                <room-material-manager association_id="{{$association->id}}"></room-material-manager>
                <v-row justify="center">
                    <v-col>
                        @foreach($association->materials as $material)
                            <material-card v-bind:material="{{$material}}"></material-card>
                        @endforeach
                    </v-col>
                    <v-col>
                        @foreach($association->rooms as $room)
                            <room-card v-bind:room="{{$room}}"></room-card>
                        @endforeach
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
    <div class="fab-container">
        <v-btn
            fab
            large
            dark
            bottom
            right
            class="v-btn--example"
            href="{{url('/association/'.$association->id.'/event/create')}}"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
    </div>
@endsection

<style>
    .fab-container {
        position: fixed;
        bottom: 5vh;
        right: 5vh;
    }
</style>
