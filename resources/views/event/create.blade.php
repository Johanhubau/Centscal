@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <create-event-card association_id="{{$association->id}}"></create-event-card>
            </v-col>
        </v-row>
    </v-container>
@endsection

