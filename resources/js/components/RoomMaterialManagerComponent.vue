<template>
    <v-sheet class="mx-auto">
        <v-card-title>Manage your equipments and rooms</v-card-title>
        <v-row justify="center">
            <v-col>
                <v-row justify="center">
                    <v-btn :href="'/association/'+association_id+'/material/create'">New Equipment</v-btn>
                </v-row>
            </v-col>
            <v-col>
                <v-row justify="center">
                    <v-btn :href="'/association/'+association_id+'/room/create'">New Room</v-btn>
                </v-row>
            </v-col>
        </v-row>
    </v-sheet>
</template>

<script>
    export default {
        name: "RoomMaterialManagerComponent",
        props: ['association_id']
    }
</script>

<style scoped>

</style>
