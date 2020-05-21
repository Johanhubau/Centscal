@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <update-event-card v-bind:event="{{$event}}"
                                   v-bind:rooms="{{\App\Room::all()}}"
                                   v-bind:materials="{{\App\Material::all()}}"
                                   v-bind:rents="{{$event->rents}}"
                                   locale="{{App::getLocale()}}"
                                   @if($event->occupation != null)
                                   v-bind:occupation="{{$event->occupation}}"
                                   @else
                                   occupation=""
                    @endif
                ></update-event-card>
            </v-col>
        </v-row>
    </v-container>
@endsection
