@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5 py-0 fill-height">
        <v-row
            justify="center" class="fill-height">
            <v-col>
                <home-calendar-component v-bind:associations="{{\App\Association::all('id', 'name', 'color')}}" locale="{{App::getLocale()}}"></home-calendar-component>
            </v-col>
        </v-row>
    </div>
@endsection
