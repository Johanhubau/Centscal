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
                            :rules="titleRules"
                            label="Title"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="desc"
                            :counter="255"
                            :rules="descRules"
                            label="Description"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="location"
                            :counter="255"
                            :rules="locRules"
                            label="Location"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="link"
                            :counter="255"
                            :rules="linkRules"
                            label="Event link"
                            required
                            hint="Remember to add the http:// or https:// in front of the link"
                        ></v-text-field>

                        <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                        >
                            Validate
                        </v-btn>
                    </v-col>
                    <v-col align-self="center">
                        <v-row justify="center">
                            <transition name="fade" mode="out-in">
                                <div v-if="current_step === 1" key="1">
                                    <v-card-title>Select begin date</v-card-title>
                                    <v-date-picker v-model="date_begin"></v-date-picker>
                                </div>
                                <div v-if="current_step === 2" key="2">
                                    <v-card-title>Select begin time</v-card-title>
                                    <v-time-picker v-model="time_begin" format="24hr"></v-time-picker>
                                </div>
                                <div v-if="current_step === 3" key="3">
                                    <v-card-title>Select end date</v-card-title>
                                    <v-date-picker v-model="date_end"></v-date-picker>
                                </div>
                                <div v-if="current_step === 4" key="4">
                                    <v-card-title>Select end time</v-card-title>
                                    <v-time-picker v-model="time_end" format="24hr"></v-time-picker>
                                </div>
                                <v-card-title v-if="current_step === 5" key="5">Done!</v-card-title>
                            </transition>
                        </v-row>
                        <v-row justify="center" class="pt-3">
                            <v-btn @click="previous_step" :disabled="current_step === 1">Back</v-btn>
                            <v-btn @click="next_step" :disabled="current_step === 5">Next</v-btn>
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
                Close
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
    export default {
        props: ['event'],
        data: () => ({
            valid: true,
            title: '',
            titleRules: [
                v => !!v || 'Title is required',
                v => (v && v.length <= 255 && v.length >= 2) || 'Title must be between 2 and 255 characters',
            ],
            desc: '',
            descRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Description must be between 2 and 255 characters',
            ],
            location: '',
            locRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Location must be between 2 and 255 characters',
            ],
            link: '',
            linkRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Link must be between 2 and 255 characters',
            ],
            current_step: 1,
            date_begin: '',
            time_begin: '',
            date_end: '',
            time_end: '',
            lazy: false,
            snackbar: false,
            snackbarText: '',
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
        },

        methods: {
            validate() {
                this.$refs.form.validate()
                if (this.begin > this.end) {
                    this.snackbarText = "Beginning date should be before end date!";
                    this.snackbar = true;
                    this.current_step = 1;
                } else {
                    let data = {}
                    if(this.title !== this.event.title){
                        data["title"] = this.title
                    }
                    if (this.desc !== this.event.desc) {
                        data["desc"] = this.desc
                    }
                    if (this.link !== this.event.link) {
                        data["link"] = this.link
                    }
                    if (this.location !== this.event.location) {
                        data["location"] = this.location
                    }
                    if(this.date_begin !== this.getDate(this.event.begin) || this.time_begin !== this.getTime(this.event.begin)){
                        data['begin'] = this.convertDateToUTC(this.begin)
                    }
                    if(this.date_end !== this.getDate(this.event.end) || this.time_end !== this.getTime(this.event.end)){
                        data['end'] = this.convertDateToUTC(this.end)
                    }
                    if(Object.keys(data).length === 0){
                        this.snackbarText = "Nothing to change";
                        this.snackbar = true;
                    }else{
                        console.log(data)
                        axios.post('/api/event/'+this.event.id, data).then((response) => {
                            status = response.status;
                            this.snackbarText = "Updated " + this.title;
                            this.snackbar = true;
                        })
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
                this.desc = this.event.desc
                this.link = this.event.link
                this.location = this.event.location
                this.date_begin = this.getDate(this.event.begin)
                this.time_begin = this.getTime(this.event.begin)
                this.date_end = this.getDate(this.event.end)
                this.time_end = this.getTime(this.event.end)
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
