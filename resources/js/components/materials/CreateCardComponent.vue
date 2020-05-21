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
                v => !!v || $vuetify.lang.t('$vuetify.materials.create.nameRequired'),
                v => (v && v.length <= 255 && v.length >= 2) || $vuetify.lang.t('$vuetify.materials.create.nameLength') ,
            ]"
                            :label="$vuetify.lang.t('$vuetify.materials.create.name')"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="desc"
                            :counter="255"
                            :rules="[v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || $vuetify.lang.t('$vuetify.materials.create.descLength'),]"
                            :label="$vuetify.lang.t('$vuetify.materials.create.desc')"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="price"
                            :counter="255"
                            :rules="[
                v => ((v.length <= 255 && v.length >= 1) || v.length === 0) || $vuetify.lang.t('$vuetify.materials.create.priceLength'),
            ]"
                            :label="$vuetify.lang.t('$vuetify.materials.create.price')"
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
            desc: '',
            price: '',
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
        },
        methods: {
            validate() {
                this.$refs.form.validate()
                let data = {
                    "name": this.name,
                    "association_id": this.association_id,
                }
                if (this.desc !== '') {
                    data["desc"] = this.desc
                }
                if (this.price !== '') {
                    data["price"] = this.price
                }
                axios.post('/api/material', data).then((response) => {
                    status = response.status;
                    this.snackbarText = $vuetify.lang.t('$vuetify.common.snackbar.created', [this.name]);
                    this.snackbar = true;
                }).finally(()=>{
                    window.location.href = '/' + this.locale + '/association/' + this.association_id
                })
            },
        }
    }
</script>

<style scoped>

</style>
