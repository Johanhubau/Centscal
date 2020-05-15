<template>
    <v-card v-if="show" class="mx-auto">
        <v-row class="p-3">
            <v-col>
                <v-card-title>
                    {{this.association.name + " requested " + this.material.name}}
                </v-card-title>
                <v-card-text>
                    {{this.begin + " to " + this.end}}
                    <v-select
                        v-model="selected"
                        :items="items"
                        label="Approve request?"
                        required
                    >
                    </v-select>
                    <v-btn
                        :disabled="!valid"
                        color="success"
                        class="mr-4"
                        @click="validate"
                    >
                        Validate
                    </v-btn>
                </v-card-text>
                <v-snackbar v-model="snackbar"
                            :timeout="6000">
                    {{ snackbarText }}
                    <v-btn dark
                           text
                           @click="snackbar = false">
                        Close
                    </v-btn>
                </v-snackbar>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    export default {
        name: "AdminUpdateComponent",
        props: ['association', 'rent', 'material', 'event'],
        data: () => ({
            items: ['Approve', 'Do not approve'],
            itemsToId: {'Approve': 1, 'Do not approve': 2},
            begin: '',
            end: '',
            valid: true,
            selected: '',
            snackbar: false,
            snackbarText: '',
            show: true
        }),
        mounted() {
            this.makeVars()
        },
        methods: {
            makeVars() {
                this.begin = this.formatDate(this.event.begin)
                this.end = this.formatDate(this.event.end)
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
                    this.snackbarText = "Nothing to change!";
                    this.snackbar = true;
                } else {
                    axios.post('/api/rent/' + this.rent.id, {'approved': this.itemsToId[this.selected]}).then((response) => {
                        status = response.status
                        this.snackbarText = "Updated";
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
