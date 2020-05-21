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
        name: "CreateCardComponent",
        props: ['association_id', 'locale'],
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
        },
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
                    this.snackbarText = $vuetify.lang.t('$vuetify.common.snackbar.created', [this.name]);
                    this.snackbar = true;
                }).finally(()=> {
                    window.location.href = "/" + this.locale + '/association/' + this.association_id
                })
            },
        }
    }
</script>

<style scoped>

</style>
