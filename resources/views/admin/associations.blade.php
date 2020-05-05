@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                @foreach(\App\Association::all() as $association)
                    <private-association-card
                        id="{{$association->id}}"
                        name="{{$association->name}}"
                        desc="{{$association->desc}}"
                        color="{{$association->color}}"
                        class="my-5"
                    ></private-association-card>
                @endforeach
            </v-col>
        </v-row>
    </v-container>
    <div class="fab-container">
        <v-btn
            fab
            large
            dark
            bottom
            right
            class="v-btn--example"
            href="{{route('admin.associations.create')}}"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
    </div>
@endsection

<style>
    .fab-container{
        position: fixed;
        bottom: 5vh;
        right: 5vh;
    }
</style>
