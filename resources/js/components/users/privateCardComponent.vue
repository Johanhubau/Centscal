<template>
    <!--    TODO repair v-lazy-->
    <!--    <v-lazy-->
    <!--        v-model="isActive"-->
    <!--        :options="{-->
    <!--          threshold: .5-->
    <!--        }"-->
    <!--        min-height="200"-->
    <!--        :key="id"-->
    <!--    >-->
    <div>
        <v-card
            class="mx-auto"
            v-if="show">
            <div class="d-flex flex-no-wrap justify-space-between">
                <div class="w-100">
                    <v-card-title
                        class="headline"
                        v-text="name"
                    ></v-card-title>

                    <v-card-subtitle v-text="role"></v-card-subtitle>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            icon
                            :href=userlink>
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
    <!--    </v-lazy>-->
</template>
<script>
    export default {
        name: "privateCardComponent",
        props: ['id', 'name', 'role'],
        data: () => ({
            isActive: false,
            snackbar: false,
            snackbarText: '',
            show: true,
        }),
        computed: {
            userlink() {
                return '/admin/user/'+ this.id +'/edit'
            }
        },
        methods: {
            deleteItem() {
                axios.delete('/api/user/' + this.id, {}).then((response) => {
                    status = response.status;
                    this.snackbarText = "Deleted " + this.name;
                    this.snackbar = true;
                    this.show = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
