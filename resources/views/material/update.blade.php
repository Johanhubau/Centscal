@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <update-material-card v-bind:material="{{$material}}"></update-material-card>
            </v-col>
        </v-row>
    </v-container>
@endsection
