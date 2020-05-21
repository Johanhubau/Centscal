<template>
    <div>
        <v-sheet elevation="6">
            <v-form
                ref="form"
                v-model="valid">
                <v-row class="p-5">
                    <v-col>
                        <v-text-field
                            v-model="title"
                            :counter="255"
                            :rules="[
                v => !!v || this.$vuetify.lang.t('$vuetify.events.create.titleRequired'),
                v => (v && v.length <= 255 && v.length >= 2) || this.$vuetify.lang.t('$vuetify.events.create.titleLength'),]"
                            :label="this.$vuetify.lang.t('$vuetify.events.create.title')"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="desc"
                            :counter="255"
                            :rules="[
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || this.$vuetify.lang.t('$vuetify.events.create.descLength'),
            ]"
                            :label="this.$vuetify.lang.t('$vuetify.events.create.desc')"
                            required
                        ></v-text-field>

                        <v-autocomplete
                            v-model="room"
                            :items="computedRooms"
                            :counter="255"
                            :label="this.$vuetify.lang.t('$vuetify.events.create.room')"
                            required
                        ></v-autocomplete>

                        <v-text-field
                            v-model="location"
                            v-if="this.room === 'Other'"
                            :counter="255"
                            :label="this.$vuetify.lang.t('$vuetify.events.create.location')"
                            required
                            :rules="[
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || this.$vuetify.lang.t('$vuetify.events.create.locationLength'),
            ]">
                        </v-text-field>

                        <v-text-field
                            v-model="link"
                            :counter="255"
                            :rules="[
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || this.$vuetify.lang.t('$vuetify.events.create.linkLength'),
            ]"
                            :label="this.$vuetify.lang.t('$vuetify.events.create.link')"
                            required
                            :hint="$vuetify.lang.t('$vuetify.events.create.linkHint')"
                        ></v-text-field>

                        <v-autocomplete
                            v-model="selectedMaterials"
                            :items="computedMaterials"
                            :label="this.$vuetify.lang.t('$vuetify.events.create.materials')"
                            chips
                            small-chips
                            multiple
                        >
                        </v-autocomplete>

                        <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                        >
                            {{$vuetify.lang.t('$vuetify.common.actions.validate')}}
                        </v-btn>
                    </v-col>
                    <v-col align-self="center">
                        <v-row justify="center">
                            <transition name="fade" mode="out-in">
                                <div v-if="current_step === 1" key="1">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.create.beginDate')}}</v-card-title>
                                    <v-date-picker v-model="date_begin"></v-date-picker>
                                </div>
                                <div v-if="current_step === 2" key="2">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.create.beginTime')}}</v-card-title>
                                    <v-time-picker v-model="time_begin" format="24hr"></v-time-picker>
                                </div>
                                <div v-if="current_step === 3" key="3">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.create.endDate')}}</v-card-title>
                                    <v-date-picker v-model="date_end"></v-date-picker>
                                </div>
                                <div v-if="current_step === 4" key="4">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.create.endTime')}}</v-card-title>
                                    <v-time-picker v-model="time_end" format="24hr"></v-time-picker>
                                </div>
                                <v-card-title v-if="current_step === 5" key="5">{{$vuetify.lang.t('$vuetify.events.create.done')}}</v-card-title>
                            </transition>
                        </v-row>
                        <v-row justify="center" class="pt-3">
                            <v-btn @click="previous_step" :disabled="current_step === 1">{{$vuetify.lang.t('$vuetify.common.actions.previous')}}</v-btn>
                            <v-btn @click="next_step" :disabled="current_step === 5">{{$vuetify.lang.t('$vuetify.common.actions.next')}}</v-btn>
                        </v-row>
                    </v-col>
                </v-row>
            </v-form>
        </v-sheet>
        <v-snackbar v-model="snackbar"
                    :timeout="6000">
            {{ snackbarText }}
            <v-btn dark
                   text
                   @click="snackbar = false">
                {{$vuetify.lang.t('$vuetify.common.actions.close')}}
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
    export default {
        props: ['association_id', 'rooms', 'materials', 'locale'],
        data: () => ({
            valid: true,
            title: '',
            desc: '',
            location: '',
            link: '',
            current_step: 1,
            date_begin: '',
            time_begin: '',
            date_end: '',
            time_end: '',
            lazy: false,
            snackbar: false,
            snackbarText: '',
            computedRooms: [],
            roomsToId: {},
            room: '',
            selectedMaterials: [],
            computedMaterials: [],
            materialToId: {},
        }),

        computed: {
            begin() {
                return this.date_begin + "T" + this.time_begin
            },
            end() {
                return this.date_end + "T" + this.time_end
            }
        },

        mounted() {
            this.$vuetify.lang.current = this.locale
            this.makeVars()
        },

        methods: {
            validate() {
                this.$refs.form.validate()

                let reserveRoom = false;
                let reserveMaterial = false;

                if (this.begin > this.end) {
                    this.snackbarText = this.$vuetify.lang.t('$vuetify.events.create.dateOrder')
                    this.snackbar = true;
                    this.current_step = 1;
                } else {
                    let data = {
                        "title": this.title,
                        "association_id": this.association_id,
                        "begin": this.convertDateToUTC(this.begin),
                        "end": this.convertDateToUTC(this.end),
                    }
                    if (this.desc !== '') {
                        data["desc"] = this.desc
                    }
                    if (this.link !== '') {
                        data["link"] = this.link
                    }
                    if(this.roomsToId[this.location] !== null){
                        reserveRoom = true;
                    }else if(this.location !== ''){
                        if(this.room === 'Other'){
                            data["location"] = this.location
                        }
                    }
                    if(Object.keys(this.selectedMaterials).length !== 0){
                        reserveMaterial = true
                    }
                    axios.post('/api/event', data).then((response) => {
                        status = response.status;
                        let eventId = response.data.id
                        if(reserveRoom){
                            axios.post('/api/occupation', {'event_id': eventId, 'room_id': this.roomsToId[this.room]}).then((response) => {
                                status = response.status;
                            })
                        }
                        if(reserveMaterial){
                            this.selectedMaterials.forEach(material =>
                                axios.post('/api/rent', {'event_id': eventId, 'material_id': this.materialToId[material]}).then((response) => {
                                    status = response.status;
                                })
                            )
                        }
                        this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.created', [this.title])
                        this.snackbar = true;
                    }).finally(()=>{
                        window.location.href = '/' + this.locale + '/association/'+this.association_id
                    })
                }
            },
            previous_step() {
                this.current_step -= 1
            },
            next_step() {
                this.current_step += 1
            },
            convertDateToUTC(d) {
                d+=":00"
                console.log(d)
                let date = new Date(d)
                return date.getUTCFullYear() + "-" + (date.getUTCMonth()+1) + "-" + date.getUTCDate() + "T" + date.getUTCHours() + ":" + date.getUTCMinutes()
            },
            makeVars() {
                this.rooms.forEach(room =>
                    this.computedRooms.push(room.name)
                )
                this.computedRooms.push('Other')
                this.rooms.forEach(room =>
                    this.roomsToId[room.name] = room.id
                )
                this.materials.forEach(material =>
                    this.computedMaterials.push(material.name + ": " +material.price)
                )
                this.materials.forEach(material =>
                    this.materialToId[material.name + ": " +material.price] = material.id
                )
            }
        },
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .2s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }
</style>
