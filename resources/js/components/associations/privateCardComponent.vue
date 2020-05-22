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
                    <v-avatar
                        class="ma-3"
                        size="125"
                        tile
                        :color="color"
                    >
                        <!--                <v-img :src="item.src"></v-img>-->
                    </v-avatar>
                    <div class="w-100">
                        <v-card-title
                            class="headline"
                            v-text="name"
                        ></v-card-title>

                        <v-card-subtitle v-text="desc"></v-card-subtitle>
                        <v-card-actions>
                            <v-spacer></v-spacer>
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
            {{$vuetify.lang.t('$vuetify.common.snackbar.deleted', [this.name])}}
            <v-btn dark
                   text
                   @click="snackbar = false">
                {{$vuetify.lang.t('$vuetify.common.actions.close', [this.name])}}
            </v-btn>
        </v-snackbar>
    </div>
    <!--    </v-lazy>-->
</template>
<script>
    export default {
        name: "privateCardComponent",
        props: ['id', 'name', 'desc', 'color', 'locale'],
        data: () => ({
            isActive: false,
            snackbar: false,
            show: true,
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
        },
        methods: {
            deleteItem() {
                axios.delete('/api/association/' + this.id, {}).then((response) => {
                    status = response.status;
                    this.snackbar = true;
                    this.show = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
