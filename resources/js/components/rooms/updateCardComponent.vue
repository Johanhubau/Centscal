<template>
    <div>
        <v-sheet elevation="6">
            <v-form
                ref="form"
                v-model="valid">
                <v-row class="p-5">
                    <v-col>
                        <v-text-field
                            v-model="name"
                            :counter="255"
                            :rules="nameRules"
                            label="Name"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="location"
                            :counter="255"
                            :rules="locationRules"
                            label="Location"
                            hint="Be specific, we want people to find it right?"
                            required
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
        name: "updateCardComponent",
        props: ['room'],
        data: () => ({
            lazy: false,
            snackbar: false,
            snackbarText: '',
            valid: true,
            name: '',
            nameRules: [
                v => (v && v.length <= 255 && v.length >= 2) || 'Name must be between 2 and 255 characters',
            ],
            location: '',
            locationRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Location must be between 2 and 255 characters',
            ],
        }),
        mounted() {
            this.makeVars()
        },
        methods: {
            validate() {
                this.$refs.form.validate()
                let data = {}
                if (this.name !== this.room.name) {
                    data["name"] = this.name
                }
                if (this.location !== this.room.location) {
                    data["location"] = this.location
                }
                if (Object.keys(data).length === 0) {
                    this.snackbarText = "Nothing to change!";
                    this.snackbar = true;
                } else {
                    axios.post('/api/room/'+this.room.id, data).then((response) => {
                        status = response.status;
                        this.snackbarText = "Updated " + this.name;
                        this.snackbar = true;
                    })
                }
            },
            makeVars() {
                this.name = this.room.name
                this.location = this.room.location
            }
        }
    }
</script>

<style scoped>

</style>
