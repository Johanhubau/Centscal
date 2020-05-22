<template>
    <v-card class="mx-auto">
        <div class="d-flex flex-no-wrap justify-space-between">
            <v-avatar
                class="profile"
                :color="association.color"
                size="150"
                tile
            >
            </v-avatar>
            <div class="w-100">
                <v-card-title
                    class="headline"
                    v-text="association.name"
                ></v-card-title>

                <v-card-subtitle v-text="association.desc"></v-card-subtitle>
            </div>
        </div>
        <v-row class="mx-auto" justify="center">
            <div class="col-sm-2">
                <v-card-title>{{$vuetify.lang.t('$vuetify.common.actions.update')}}</v-card-title>
            </div>
            <div class="col-sm-10">
                <v-row justify="center">
                    <div class="col-sm">
                        <v-text-field v-model="name"
                                      :label="$vuetify.lang.t('$vuetify.associations.dashboard.name')"></v-text-field>
                        <v-text-field v-model="desc"
                                      :label="$vuetify.lang.t('$vuetify.associations.dashboard.desc')"></v-text-field>
                        <v-autocomplete
                            v-model="user"
                            :items="items"
                            :label="$vuetify.lang.t('$vuetify.associations.dashboard.president')"
                            required
                        ></v-autocomplete>
                        <v-btn v-if="$vuetify.breakpoint.smAndUp" @click="update">{{$vuetify.lang.t('$vuetify.common.actions.update')}}</v-btn>
                    </div>
                    <div class="col-sm">
                        <v-color-picker class="mb-7" hide-mode-switch mode="hexa" v-model="color"></v-color-picker>
                        <v-btn v-if="$vuetify.breakpoint.xsOnly" :block="$vuetify.breakpoint.xsOnly" @click="update">{{$vuetify.lang.t('$vuetify.common.actions.update')}}</v-btn>
                    </div>
                </v-row>
            </div>
        </v-row>
        <v-row class="mx-auto">

        </v-row>
        <v-snackbar v-model="snackbar"
                    :timeout="6000">
            {{ snackbarText }}
            <v-btn dark
                   text
                   @click="snackbar = false">
                {{$vuetify.lang.t('$vuetify.common.actions.close')}}
            </v-btn>
        </v-snackbar>
    </v-card>
</template>

<script>
    export default {
        name: "dashboardComponent",
        props: ['association', 'users', 'first_name', 'last_name', 'locale'],
        data: () => ({
            name: '',
            desc: '',
            president_id: '',
            color: '',
            user: "",
            items: [],
            userNames: {},
            snackbar: false,
            snackbarText: '',
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
            this.makeVars()
        },
        methods: {
            makeVars() {
                this.name = this.association.name
                this.desc = this.association.desc
                this.color = this.association.color
                this.users.forEach(user =>
                    this.items.push(user.first_name + " " + user.last_name)
                )
                this.users.forEach(user =>
                    this.userNames[user.first_name + " " + user.last_name] = user.id
                )
                this.user = this.first_name + " " + this.last_name
            },
            update(){
                let data = {}
                if(this.name !== this.association.name){
                    data['name'] = this.name
                }
                if(this.desc !== this.association.desc){
                    data['desc'] = this.desc
                }
                if(this.color !== this.association.color){
                    data['color'] = this.color
                }
                if(this.userNames[this.user] !== this.association.president_id){
                    data['president_id'] = this.userNames[this.user]
                }
                if(Object.keys(data).length !== 0){
                    axios.post('/api/association/' + this.association.id, data).then((response) => {
                        status = response.status;
                        this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.updated', [this.name])
                        this.snackbar = true;
                        this.association.name = this.name
                        this.association.desc = this.desc
                        this.association.color = this.color
                    })
                }else{
                    this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.nothing')
                    this.snackbar = true
                }
            }
        }
    }
</script>

<style scoped>

</style>
