<template>
    <v-card class="mx-auto p-3">
        <v-card-title>{{this.$vuetify.lang.t('$vuetify.users.update.title')}}</v-card-title>
        <v-select
            v-model="role"
            :items="items"
            :rules="[v => !!v || this.$vuetify.lang.t('$vuetify.users.update.itemRequired')]"
            :label="this.$vuetify.lang.t('$vuetify.users.update.role')"
            required
        ></v-select>
        <v-btn
            :disabled="!valid"
            color="success"
            class="mr-4"
            @click="validate"
        >
            {{$vuetify.lang.t('$vuetify.common.actions.validate')}}
        </v-btn>
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
        name: "UpdateAdminCardComponent",
        props: ['user', 'locale'],
        data: () => ({
            role: '',
            items: [],
            itemToRole: {},
            roleToItem: {},
            valid: true,
            snackbar: false,
            snackbarText: '',
        }),
        mounted() {
            this.$vuetify.lang.current = this.locale
            this.makeVars()
        },
        methods: {
            validate() {
                if (this.role === this.roleToItem[this.user.role]) {
                    this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.nothing')
                    this.snackbar = true;
                } else {
                    axios.post('/api/user/' + this.user.id, {'role': this.itemToRole[this.role]}).then((response) => {
                        status = response.status;
                        this.snackbarText = this.$vuetify.lang.t('$vuetify.common.snackbar.updated', [this.user.first_name]);
                        this.snackbar = true;
                    }).finally(() => {
                        window.location.href = '/' + this.locale + "/admin/users"
                    })
                }
            },
            makeVars() {
                this.items.push(this.$vuetify.lang.t('$vuetify.users.update.user'))
                this.items.push(this.$vuetify.lang.t('$vuetify.users.update.admin'))
                this.itemToRole[this.$vuetify.lang.t('$vuetify.users.update.user')] = "ROLE_USER"
                this.itemToRole[this.$vuetify.lang.t('$vuetify.users.update.admin')] = "ROLE_ADMIN"
                this.roleToItem['ROLE_USER'] = this.$vuetify.lang.t('$vuetify.users.update.user')
                this.roleToItem['ROLE_ADMIN'] = this.$vuetify.lang.t('$vuetify.users.update.admin')
                this.role = this.roleToItem[this.user.role]
            }
        }
    }
</script>

<style scoped>

</style>
