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
        props: ['association_id'],
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
        },

        methods: {
            validate() {
                this.$refs.form.validate()
                if (this.begin > this.end) {
                    this.snackbarText = "Beginning date should be before end date!";
                    this.snackbar = true;
                    this.current_step = 1;
                } else {
                    let data = {
                        "title": this.title,
                        "association_id": this.association_id,
                        "begin": this.begin,
                        "end": this.end,
                    }
                    if (this.desc !== '') {
                        data["desc"] = this.desc
                    }
                    if (this.link !== '') {
                        data["link"] = this.link
                    }
                    if (this.location !== '') {
                        data["location"] = this.location
                    }
                    console.log(data)
                    axios.post('/api/event', data).then((response) => {
                        status = response.status;
                        this.snackbarText = "Created " + this.title;
                        this.snackbar = true;
                    })
                }
            },
            previous_step() {
                this.current_step -= 1
            },
            next_step() {
                this.current_step += 1
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
