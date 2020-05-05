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
                @foreach($association->events as $event)
                    <private-event-card v-bind:event="{{$event}}"></private-event-card>
                @endforeach
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
