@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5 py-0 fill-height">
        <v-row
            justify="center" class="fill-height">
            <v-col>
                <home-calendar-component></home-calendar-component>
            </v-col>
        </v-row>
    </div>
@endsection
