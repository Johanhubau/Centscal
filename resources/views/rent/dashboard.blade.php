@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                @foreach(Auth::user()->president_associations as $association)
                    @foreach($association->rents->where('approved', 0) as $rent)
                <update-rent-card
                    v-bind:association="{{$association}}"
                    v-bind:event="{{$rent->event}}"
                    v-bind:rent="{{$rent}}"
                    v-bind:material="{{$rent->material}}"
                    class="my-3"
                >
                </update-rent-card>
                    @endforeach
                @endforeach
            </v-col>
        </v-row>
    </v-container>
@endsection
