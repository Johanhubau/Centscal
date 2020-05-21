@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <update-user-card
                    v-bind:user="{{\App\User::find($user->id)}}" locale="{{App::getLocale()}}"
                ></update-user-card>
            </v-col>
        </v-row>
    </v-container>
@endsection
