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
                            :rules="[
                v => !!v || $vuetify.lang.t('$vuetify.rooms.create.nameRequired'),
                v => (v && v.length <= 255 && v.length >= 2) || $vuetify.lang.t('$vuetify.rooms.create.nameLength') ,
            ]"
                            :label="$vuetify.lang.t('$vuetify.rooms.create.name')"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="location"
                            :counter="255"
                            :rules="[v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || $vuetify.lang.t('$vuetify.rooms.create.locLength'),]"
                            :label="$vuetify.lang.t('$vuetify.rooms.create.location')"
                            :hint="$vuetify.lang.t('$vuetify.rooms.create.locHint')"
                            required
                        ></v-text-field>

                        <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                        >
                            {{$vuetify.lang.t('$vuetify.common.actions.validate')}}
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
                {{$vuetify.lang.t('$vuetify.common.actions.close')}}
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
    export default {
        name: "updateCardComponent",
        props: ['room', 'locale'],
        data: () => ({
            lazy: false,
            snackbar: false,
            snackbarText: '',
            valid: true,
            name: '',
            location: '',
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
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
                    this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.nothing')
                    this.snackbar = true;
                } else {
                    axios.post('/api/room/' + this.room.id, data).then((response) => {
                        status = response.status;
                        this.snackbarText = $vuetify.lang.t('$vuetify.common.snackbar.updated', [this.name]);
                        this.snackbar = true;
                    }).finally(() => {
                        window.location.href = '/' + this.locale + '/association/' + this.association_id
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
