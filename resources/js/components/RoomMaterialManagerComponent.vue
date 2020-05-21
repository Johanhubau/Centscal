<template>
    <v-sheet class="mx-auto">
        <v-card-title>{{$vuetify.lang.t('$vuetify.general.roomMaterial.title')}}</v-card-title>
        <v-row justify="center">
            <v-col>
                <v-row justify="center">
                    <v-btn :href="'/' + this.locale + '/association/'+association_id+'/material/create'">{{$vuetify.lang.t('$vuetify.general.roomMaterial.nMate')}}</v-btn>
                </v-row>
            </v-col>
            <v-col>
                <v-row justify="center">
                    <v-btn :href="'/' + this.locale + '/association/'+association_id+'/room/create'">{{$vuetify.lang.t('$vuetify.general.roomMaterial.nRoom')}}</v-btn>
                </v-row>
            </v-col>
        </v-row>
    </v-sheet>
</template>

<script>
    export default {
        name: "RoomMaterialManagerComponent",
        props: ['association_id', 'locale'],
        mounted() {
            this.$vuetify.lang.current = this.locale
        }
    }
</script>

<style scoped>

</style>
