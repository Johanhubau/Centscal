<template>
<!--    TODO add lazy loading-->
    <div class="py-3">
        <v-card
            class="mx-auto"
            v-if="show">
            <div class="d-flex flex-no-wrap justify-space-between">
                <div class="w-100">
                    <v-card-title
                        class="headline"
                        v-text="event.title"
                    ></v-card-title>
                    <v-card-subtitle v-text="formatDate(event.begin) + ' to ' + formatDate(event.end)"></v-card-subtitle>
                    <v-card-text v-if="event.desc !== '' && event.desc !== null"  v-text="event.desc" class="py-0"></v-card-text>
                    <v-card-text v-for="(rent, id) in computedRents" v-text="rent" v-bind:key="id" class="py-0"></v-card-text>
                    <v-card-text v-if="occupation !== ''" v-text="room[0].name + ': ' + status[occupation.approved]" class="py-0"></v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            :href="'/event/'+event.id">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn
                            icon
                            @click="deleteItem">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </v-card-actions>
                </div>
            </div>
        </v-card>
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
        name: "privateCardComponent",
        props: ['event', 'materials', 'rents', 'room', 'occupation'],
        data: () => ({
            isActive: false,
            snackbar: false,
            snackbarText: '',
            show: true,
            idToMaterial: {},
            computedRents: [],
            status: {0: 'Pending', 1: 'Approved', 2: 'Not approved'}
        }),
        mounted() {
            this.makeVars()
        },
        methods: {
            deleteItem() {
                axios.delete('/api/event/' + this.event.id, {}).then((response) => {
                    status = response.status;
                    this.snackbarText = "Deleted " + this.event.title;
                    this.snackbar = true;
                    this.show = false;
                })
            },
            formatDate(date) {
                let d = new Date(date)
                let hours = d.getHours()
                let min = d.getMinutes()
                if(hours < 10){
                    hours = "0" + d.getHours()
                }
                if(min < 10){
                    min = "0" + d.getMinutes()
                }
                return d.getDate() + "-" + (d.getMonth()+1) + "-" + d.getFullYear() + " " + hours + ":" + min
            },
            makeVars(){
                this.materials.forEach(material =>
                    this.idToMaterial[material.id] = material.name
                )
                this.rents.forEach(rent =>
                    this.computedRents.push(this.idToMaterial[rent.material_id] + ": " + this.status[rent.approved])
                )

            }
        }
    }
</script>

<style scoped>

</style>
