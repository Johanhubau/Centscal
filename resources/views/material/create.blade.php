@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <create-material-card association_id="{{$association->id}}" locale="{{App::getLocale()}}"></create-material-card>
            </v-col>
        </v-row>
    </v-container>
@endsection

