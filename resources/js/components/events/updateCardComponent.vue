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
                v => !!v || this.$vuetify.lang.t('$vuetify.events.update.titleRequired'),
                v => (v && v.length <= 255 && v.length >= 2) || this.$vuetify.lang.t('$vuetify.events.update.titleLength'),]"
                            :label="this.$vuetify.lang.t('$vuetify.events.update.title')"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="desc"
                            :counter="255"
                            :rules="[
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || this.$vuetify.lang.t('$vuetify.events.update.descLength'),
            ]"
                            :label="this.$vuetify.lang.t('$vuetify.events.update.desc')"
                            required
                        ></v-text-field>

                        <v-autocomplete
                            v-model="room"
                            :items="computedRooms"
                            :counter="255"
                            :label="this.$vuetify.lang.t('$vuetify.events.update.room')"
                            required
                        ></v-autocomplete>

                        <v-text-field
                            v-model="location"
                            v-if="this.room === 'Other'"
                            :counter="255"
                            :label="this.$vuetify.lang.t('$vuetify.events.update.location')"
                            required
                            :rules="[
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || this.$vuetify.lang.t('$vuetify.events.update.locationLength'),
            ]">
                        </v-text-field>

                        <v-text-field
                            v-model="link"
                            :counter="255"
                            :rules="[
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || this.$vuetify.lang.t('$vuetify.events.update.linkLength'),
            ]"
                            :label="this.$vuetify.lang.t('$vuetify.events.update.link')"
                            required
                            :hint="$vuetify.lang.t('$vuetify.events.update.linkHint')"
                        ></v-text-field>

                        <v-autocomplete
                            v-model="selectedMaterials"
                            :items="computedMaterials"
                            :label="this.$vuetify.lang.t('$vuetify.events.update.materials')"
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
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.update.beginDate')}}</v-card-title>
                                    <v-date-picker v-model="date_begin"></v-date-picker>
                                </div>
                                <div v-if="current_step === 2" key="2">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.update.beginTime')}}</v-card-title>
                                    <v-time-picker v-model="time_begin" format="24hr"></v-time-picker>
                                </div>
                                <div v-if="current_step === 3" key="3">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.update.endDate')}}</v-card-title>
                                    <v-date-picker v-model="date_end"></v-date-picker>
                                </div>
                                <div v-if="current_step === 4" key="4">
                                    <v-card-title>{{$vuetify.lang.t('$vuetify.events.update.endTime')}}</v-card-title>
                                    <v-time-picker v-model="time_end" format="24hr"></v-time-picker>
                                </div>
                                <v-card-title v-if="current_step === 5" key="5">{{$vuetify.lang.t('$vuetify.events.update.done')}}</v-card-title>
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
        props: ['event', 'rooms', 'materials', 'rents', 'occupation', 'locale'],
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
            idToMaterial: {},
            idToRoom: {},
            initialMaterials: [],
            materialToRentId: {},
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
            this.makeVars()
            this.$vuetify.lang.current = this.locale
        },

        methods: {
            validate() {
                this.$refs.form.validate()
                if (this.begin > this.end) {
                    this.snackbarText = this.$vuetify.lang.t('$vuetify.events.update.dateOrder')
                    this.snackbar = true;
                    this.current_step = 1;
                } else {
                    let data = {}
                    let reserveRoom = false
                    let reserveMaterial = false
                    let deleteOccupation = false
                    if(this.title !== this.event.title){
                        data["title"] = this.title
                    }
                    if (this.desc !== this.event.desc && this.event.desc != null) {
                        data["desc"] = this.desc
                    }
                    if (this.link !== this.event.link && this.event.link != null) {
                        data["link"] = this.link
                    }
                    if (this.room !== this.roomsToId[this.occupation.room_id] || this.location !== this.event.location) {
                        if(this.room !== 'Other' && this.room !== ''){
                            reserveRoom = true;
                        }else if(this.location !== ''){
                            if(this.room === 'Other'){
                                data["location"] = this.location
                                if(this.occupation !== ''){
                                    deleteOccupation = true
                                }
                            }
                        }
                    }
                    if (this.initialMaterials !== this.selectedMaterials){
                        reserveMaterial = true
                    }
                    if(this.date_begin !== this.getDate(this.event.begin) || this.time_begin !== this.getTime(this.event.begin)){
                        data['begin'] = this.convertDateToUTC(this.begin)
                    }
                    if(this.date_end !== this.getDate(this.event.end) || this.time_end !== this.getTime(this.event.end)){
                        data['end'] = this.convertDateToUTC(this.end)
                    }
                    if(Object.keys(data).length === 0 && !reserveRoom && !reserveMaterial){
                        this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.nothing')
                        this.snackbar = true;
                    }else{
                        if(reserveRoom) {
                            if(this.occupation !== ''){
                                axios.post('/api/occupation/' + this.occupation.id, {
                                    'approved': 0,
                                    'room_id': this.roomsToId[this.location]
                                }).then((response) =>
                                    status = response.status
                                )
                            }else{
                                axios.post('/api/occupation', {'event_id': this.event.id, 'room_id': this.roomsToId[this.room]}).then((response) => {
                                    status = response.status;
                                })
                            }
                        }
                        if(deleteOccupation){
                            axios.delete('/api/occupation/' + this.occupation.id).then((response) =>
                                status = response.status
                            )
                        }
                        if(reserveMaterial){
                            let creates = this.selectedMaterials.filter(x => !this.initialMaterials.includes(x));
                            let deletes = this.initialMaterials.filter(x => !this.selectedMaterials.includes(x));
                            creates.forEach(material =>
                                axios.post('/api/rent', {'event_id': this.event.id, 'material_id': this.materialToId[material]}).then((response) => {
                                    status = response.status;
                                })
                            )
                            deletes.forEach(material =>
                                axios.delete('/api/rent/'+this.materialToRentId[this.materialToId[material]]).then((response) => {
                                    status = response.status;
                                })
                            )
                        }
                        if(Object.keys(data).length !== 0) {
                            axios.post('/api/event/' + this.event.id, data).then((response) => {
                                status = response.status;
                                this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.updated', [this.title])
                                this.snackbar = true;
                            })
                        }
                        this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.updated', [this.title])
                        this.snackbar = true;
                    }
                }
            },
            previous_step() {
                this.current_step -= 1
            },
            next_step() {
                this.current_step += 1
            },
            getDate(date){
                let d = new Date(date)
                let month = (d.getMonth()+1)
                let day = d.getDate()
                if(month < 10){
                    month = "0" + (d.getMonth()+1)
                }
                if(day < 10){
                    day = "0" + d.getDate()
                }
                return d.getFullYear() + '-' + month + "-" + day
            },
            getTime(date){
                let d = new Date(date)
                let hours = d.getHours()
                let min = d.getMinutes()
                if(hours < 10){
                    hours = "0" + d.getHours()
                }
                if(min < 10){
                    min = "0" + d.getMinutes()
                }
                return hours + ":" + min
            },
            makeVars() {
                this.title = this.event.title
                if(this.event.desc !== null){
                    this.desc = this.event.desc
                }
                if (this.event.link !== null){
                    this.link = this.event.link
                }
                this.date_begin = this.getDate(this.event.begin)
                this.time_begin = this.getTime(this.event.begin)
                this.date_end = this.getDate(this.event.end)
                this.time_end = this.getTime(this.event.end)
                this.rooms.forEach(room =>
                    this.computedRooms.push(room.name)
                )
                this.computedRooms.push('Other')
                this.rooms.forEach(room =>
                    this.roomsToId[room.name] = room.id
                )
                this.rooms.forEach(room =>
                    this.idToRoom[room.id] = room.name
                )
                this.materials.forEach(material =>
                    this.computedMaterials.push(material.name + ": " +material.price)
                )
                this.materials.forEach(material =>
                    this.materialToId[material.name + ": " +material.price] = material.id
                )
                this.materials.forEach(material =>
                    this.idToMaterial[material.id] = material.name + ": " +material.price
                )
                this.rents.forEach(rent =>
                    this.selectedMaterials.push(this.idToMaterial[rent.material_id])
                )
                this.rents.forEach(rent =>
                    this.materialToRentId[rent.material_id] = rent.id
                )
                this.initialMaterials = this.selectedMaterials
                if(this.occupation === ""){
                    this.location = this.event.location
                    if(this.location !== null){
                        this.room = 'Other'
                    }
                }else{
                    this.room = this.idToRoom[this.occupation.room_id]
                }
            },
            convertDateToUTC(d) {
                d+=":00"
                console.log(d)
                let date = new Date(d)
                return date.getUTCFullYear() + "-" + (date.getUTCMonth()+1) + "-" + date.getUTCDate() + "T" + date.getUTCHours() + ":" + date.getUTCMinutes()
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
