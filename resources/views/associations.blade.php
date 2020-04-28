@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center" class="fill-height">
            <v-col>
                @foreach(\App\Association::all() as $association)
                    <public-association-card
                        id="{{$association->id}}"
                        name="{{$association->name}}"
                        desc="{{$association->desc}}"
                        color="{{$association->color}}"
                        class="my-5"
                    ></public-association-card>
                @endforeach
            </v-col>
        </v-row>
    </v-container>
@endsection
