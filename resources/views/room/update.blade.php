@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <update-room-card v-bind:room="{{$room}}"></update-room-card>
            </v-col>
        </v-row>
    </v-container>
@endsection
