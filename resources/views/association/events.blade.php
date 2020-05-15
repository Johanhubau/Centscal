@extends('layouts.app')

@section('content')
    <v-container>
        <v-row justify="center">
            <v-col>
                    <v-card-title>All events from {{$association->name}}</v-card-title>
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
                @endforeach
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
