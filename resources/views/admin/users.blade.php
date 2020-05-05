@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                @foreach(\App\User::all() as $user)
                    <private-user-card
                        id="{{$user->id}}"
                        name="{{$user->first_name." ".$user->last_name}}"
                        role="{{$user->role}}"
                        class="my-5"
                    ></private-user-card>
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
            href="{{route('admin.users.create')}}"
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
