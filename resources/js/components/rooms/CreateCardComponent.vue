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
        name: "CreateCardComponent",
        props: ['association_id'],
        data: () => ({
            lazy: false,
            snackbar: false,
            snackbarText: '',
            valid: true,
            name: '',
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 255 && v.length >= 2) || 'Name must be between 2 and 255 characters',
            ],
            location: '',
            locationRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Location must be between 2 and 255 characters',
            ],
        }),
        methods: {
            validate() {
                this.$refs.form.validate()
                let data = {
                    "name": this.name,
                    "owner_id": this.association_id,
                }
                if (this.location !== '') {
                    data["location"] = this.location
                }
                axios.post('/api/room', data).then((response) => {
                    status = response.status;
                    this.snackbarText = "Created " + this.title;
                    this.snackbar = true;
                })
                window.location.href = '/association/' + this.association_id
            },
        }
    }
</script>

<style scoped>

</style>
