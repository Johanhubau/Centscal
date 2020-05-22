@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <create-association-card v-bind:users="{{App\User::all('id', 'first_name', 'last_name')}}" locale="{{App::getLocale()}}"></create-association-card>
            </v-col>
        </v-row>
    </v-container>
@endsection
