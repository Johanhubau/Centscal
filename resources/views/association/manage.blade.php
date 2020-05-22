@extends('layouts.app')

@section('content')
    <v-container>
        <v-row
            justify="center">
            <v-col>
                <association-dashboard
                    v-bind:association="{{$association}}"
                    v-bind:users="{{App\User::all('id', 'first_name', 'last_name')}}"
                    first_name="{{Auth::user()->first_name}}"
                    last_name="{{Auth::user()->last_name}}"
                    locale="{{App::getLocale()}}"
                ></association-dashboard>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col>
                <v-row align="center" justify="space-between" class="px-5">
                    <v-card-title>@lang('app.latestEvents', ['amount' => '3'])</v-card-title>
                    <v-btn
                        v-if="$vuetify.breakpoint.smAndUp"
                        class="mr-4"
                        href="/association/{{$association->id}}/events"
                    >
                        @lang('app.seeAllEvents')
                    </v-btn>
                </v-row>
                @foreach($association->events->reverse() as $event)
                    <private-event-card
                        v-bind:event="{{$event}}"
                        v-bind:materials="{{$event->materials}}"
                        v-bind:rents="{{$event->rents}}"
                        locale="{{App::getLocale()}}"
                        @if($event->occupation != null)
                        v-bind:room="{{$event->room}}"
                        v-bind:occupation="{{$event->occupation}}"
                        @else
                        room=""
                        occupation=""
                        @endif
                    ></private-event-card>
                    @if ($loop->iteration == 3)
                        @break
                    @endif
                @endforeach
                <v-btn
                    v-if="$vuetify.breakpoint.xsOnly"
                    :block="$vuetify.breakpoint.xsOnly"
                    class="mr-4"
                    href="/{{App::getLocale()}}/association/{{$association->id}}/events"
                >
                    @lang('app.seeAllEvents')
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col>
                <room-material-manager association_id="{{$association->id}}" locale="{{App::getLocale()}}"></room-material-manager>
                <v-row justify="center">
                    <div class="col-sm">
                        <v-card-title>@lang('app.materials')</v-card-title>
                        @foreach($association->materials as $material)
                            <material-card v-bind:material="{{$material}}" locale="{{App::getLocale()}}"></material-card>
                        @endforeach
                    </div>
                    <div class="col-sm">
                        <v-card-title>@lang('app.rooms')</v-card-title>
                        @foreach($association->rooms as $room)
                            <room-card v-bind:room="{{$room}}" locale="{{App::getLocale()}}"></room-card>
                        @endforeach
                    </div>
                </v-row>
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
            href="{{url(App::getLocale().'/association/'.$association->id.'/event/create')}}"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
    </div>
@endsection

<style>
    .fab-container {
        position: fixed;
        bottom: 5vh;
        left: 5vh;
    }
</style>
