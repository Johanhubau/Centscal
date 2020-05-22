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
                v => !!v || $vuetify.lang.t('$vuetify.associations.create.nameRequired'),
                v => (v && v.length <= 255 && v.length >= 2) || $vuetify.lang.t('$vuetify.associations.create.nameLength') ,
            ]"
                            :label="$vuetify.lang.t('$vuetify.associations.create.name')"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="desc"
                            :counter="255"
                            :rules="[v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || $vuetify.lang.t('$vuetify.associations.create.descLength'),]"
                            :label="$vuetify.lang.t('$vuetify.associations.create.desc')"
                            required
                        ></v-text-field>

                        <v-autocomplete
                            v-model="user"
                            :items="items"
                            :rules="[v => !!v || $vuetify.lang.t('$vuetify.associations.create.presidentRequired')]"
                            :label="$vuetify.lang.t('$vuetify.associations.create.president')"
                            required
                        ></v-autocomplete>
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
                            <v-color-picker hide-mode-switch mode="hexa" v-model="color"></v-color-picker>
                        </v-row>
                    </v-col>
                </v-row>
            </v-form>
        </v-sheet>
        <v-snackbar v-model="snackbar"
                    :timeout="6000">
            {{$vuetify.lang.t('$vuetify.common.snackbar.created', [this.name])}}
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
        props: ['users', 'locale'],
        data: () => ({
            valid: true,
            name: '',
            desc: '',
            user: null,
            checkbox: false,
            lazy: false,
            items: [],
            userNames: {},
            snackbar: false,
            color: "#FFFFFFFF",
        }),

        mounted() {
            this.$vuetify.lang.current = this.locale
            this.makeVars()
        },

        methods: {
            validate() {
                this.$refs.form.validate()
                let data = {
                    "name": this.name,
                    "president_id": this.userNames[this.user],
                    "color": this.color.substring(0, 7)
                }
                if(this.desc !== ""){
                    data["desc"] = this.desc
                }
                axios.post('/api/association', data).then((response) => {
                    status = response.status;
                    this.snackbar = true;
                }).finally(() => {
                    window.location.href = "/" + this.locale + '/admin/associations'
                })
            },
            makeVars() {
                this.users.forEach(user =>
                    this.items.push(user.first_name + " " + user.last_name)
                )
                this.users.forEach(user =>
                    this.userNames[user.first_name + " " + user.last_name] = user.id
                )
            }
        },
    }
</script>

<style scoped>

</style>
