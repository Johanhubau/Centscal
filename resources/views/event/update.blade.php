@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <update-event-card v-bind:event="{{$event}}"></update-event-card>
            </v-col>
        </v-row>
    </v-container>
@endsection
