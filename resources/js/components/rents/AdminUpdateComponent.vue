<template>
    <v-card v-if="show" class="mx-auto">
        <v-row class="p-3">
            <v-col>
                <v-card-title>
                    {{this.association.name + " " + $vuetify.lang.t('$vuetify.rents.admin.requested') + " " + this.material.name}}
                </v-card-title>
                <v-card-text>
                    {{this.begin + " " + $vuetify.lang.t('$vuetify.rents.admin.to') + " " + this.end}}
                    <v-select
                        v-model="selected"
                        :items="items"
                        :label="$vuetify.lang.t('$vuetify.rents.admin.approveQ')"
                        required
                    >
                    </v-select>
                    <v-btn
                        :disabled="!valid"
                        color="success"
                        class="mr-4"
                        @click="validate"
                    >
                        {{this.$vuetify.lang.t('$vuetify.common.actions.validate')}}
                    </v-btn>
                </v-card-text>
                <v-snackbar v-model="snackbar"
                            :timeout="6000">
                    {{ snackbarText }}
                    <v-btn dark
                           text
                           @click="snackbar = false">
                        {{this.$vuetify.lang.t('$vuetify.common.actions.close')}}
                    </v-btn>
                </v-snackbar>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    export default {
        name: "AdminUpdateComponent",
        props: ['association', 'rent', 'material', 'event', 'locale'],
        data: () => ({
            items: [],
            itemsToId: {},
            begin: '',
            end: '',
            valid: true,
            selected: '',
            snackbar: false,
            snackbarText: '',
            show: true
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
            this.makeVars()
        },
        methods: {
            makeVars() {
                this.begin = this.formatDate(this.event.begin)
                this.end = this.formatDate(this.event.end)
                this.items.push(this.$vuetify.lang.t('$vuetify.rents.admin.approve'))
                this.items.push(this.$vuetify.lang.t('$vuetify.rents.admin.notApprove'))
                this.itemsToId[this.$vuetify.lang.t('$vuetify.rents.admin.approve')] = 1
                this.itemsToId[this.$vuetify.lang.t('$vuetify.rents.admin.notApprove')] = 2
            },
            formatDate(date) {
                let d = new Date(date)
                let hours = d.getHours()
                let min = d.getMinutes()
                if (hours < 10) {
                    hours = "0" + d.getHours()
                }
                if (min < 10) {
                    min = "0" + d.getMinutes()
                }
                return d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear() + " " + hours + ":" + min
            },
            validate() {
                if (this.selected === '') {
                    this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.nothing')
                    this.snackbar = true;
                } else {
                    axios.post('/api/rent/' + this.rent.id, {'approved': this.itemsToId[this.selected]}).then((response) => {
                        status = response.status
                        this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.updated', [""])
                        this.snackbar = true;
                        this.show = false
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
