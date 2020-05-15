<template>
    <v-card class="mx-auto p-3">
            <v-card-title>Update user role</v-card-title>
            <v-select
                v-model="role"
                :items="items"
                :rules="[v => !!v || 'Item is required']"
                label="Role"
                required
            ></v-select>
            <v-btn
                :disabled="!valid"
                color="success"
                class="mr-4"
                @click="validate"
            >
                Validate
            </v-btn>
            <v-snackbar v-model="snackbar"
                        :timeout="6000">
                {{ snackbarText }}
                <v-btn dark
                       text
                       @click="snackbar = false">
                    Close
                </v-btn>
            </v-snackbar>
    </v-card>
</template>

<script>
    export default {
        name: "UpdateAdminCardComponent",
        props: ['user'],
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
            this.makeVars()
        },
        methods: {
            validate() {
                if (this.role === this.roleToItem[this.user.role]) {
                    this.snackbarText = "Nothing to change!";
                    this.snackbar = true;
                } else {
                    axios.post('/api/user/' + this.user.id, {'role': this.itemToRole[this.role]}).then((response) => {
                        status = response.status;
                        console.log(status)
                        this.snackbarText = "Updated " + this.user.first_name;
                        this.snackbar = true;
                    })
                    window.location.href = "/admin/users"
                }
            },
            makeVars() {
                this.items = [
                    'User',
                    'Admin'
                ]
                this.itemToRole = {
                    'User': 'ROLE_USER',
                    'Admin': 'ROLE_ADMIN'
                }
                this.roleToItem = {
                    'ROLE_USER': 'User',
                    'ROLE_ADMIN': 'Admin'
                }
                this.role = this.roleToItem[this.user.role]
            }
        }
    }
</script>

<style scoped>

</style>
