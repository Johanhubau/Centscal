@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                @foreach(Auth::user()->president_associations as $association)
                    @foreach($association->occupations->where('approved', 0) as $occupation)
                        <update-occupation-card
                            v-bind:association="{{$association}}"
                            v-bind:event="{{$occupation->event}}"
                            v-bind:occupation="{{$occupation}}"
                            v-bind:room="{{$occupation->room}}"
                            class="my-3"
                        >
                        </update-occupation-card>
                    @endforeach
                @endforeach
            </v-col>
        </v-row>
    </v-container>
@endsection
