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
                        v-text="room.name"
                    ></v-card-title>
                    <v-card-subtitle v-text="this.location" class="py-0"></v-card-subtitle>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            :href="'/room/'+room.id">
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
        name: "CardComponent",
        props: ['room'],
        data: () => ({
            isActive: false,
            snackbar: false,
            snackbarText: '',
            show: true,
            location: '',
        }),
        mounted() {
            this.makeVars()
        },
        methods: {
            deleteItem() {
                axios.delete('/api/room/' + this.room.id, {}).then((response) => {
                    status = response.status;
                    this.snackbarText = "Deleted " + this.room.name;
                    this.snackbar = true;
                    this.show = false;
                })
            },
            makeVars() {
                if(this.room.location !== 'null'){
                    this.location = this.room.location
                }
            }
        }
    }
</script>

<style scoped>

</style>
