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
        <V-row justify="center">
            <v-col>
                <v-card-title>Latest 3 events</v-card-title>
                @foreach($association->events->reverse() as $event)
                    <private-event-card v-bind:event="{{$event}}"></private-event-card>
                    @if ($loop->iteration == 3)
                        @break
                    @endif
                @endforeach
            </v-col>
        </V-row>
        <V-row justify="center">
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
        </V-row>
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
    .fab-container{
        position: fixed;
        bottom: 5vh;
        right: 5vh;
    }
</style>
