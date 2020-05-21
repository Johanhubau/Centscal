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
    <v-card
        class="mx-auto">
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
            </div>
        </div>
    </v-card>
    <!--    </v-lazy>-->
</template>
<script>
    export default {
        name: "publicCardComponent",
        props: ['id', 'name', 'desc', 'color', 'locale'],
        data: () => ({
            isActive: false,
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
        },
    }
</script>

<style scoped>

</style>
