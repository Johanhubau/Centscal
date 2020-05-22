@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <create-event-card
                    association_id="{{$association->id}}"
                    v-bind:rooms="{{\App\Room::all()}}"
                    v-bind:materials="{{\App\Material::all()}}"
                    locale="{{App::getLocale()}}"></create-event-card>
            </v-col>
        </v-row>
    </v-container>
@endsection

