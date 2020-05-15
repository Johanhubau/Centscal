@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <create-room-card association_id="{{$association->id}}"></create-room-card>
            </v-col>
        </v-row>
    </v-container>
@endsection

