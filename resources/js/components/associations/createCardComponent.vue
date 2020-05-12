<template>
    <div>
        <v-sheet elevation="6">
            <v-form
                ref="form"
                v-model="valid">
                <v-row class="p-5">
                    <v-col>
                        <v-text-field
                            v-model="name"
                            :counter="255"
                            :rules="nameRules"
                            label="Name"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="desc"
                            :counter="255"
                            :rules="descRules"
                            label="Desc"
                            required
                        ></v-text-field>

                        <v-autocomplete
                            v-model="user"
                            :items="items"
                            :rules="[v => !!v || 'Item is required']"
                            label="President"
                            required
                        ></v-autocomplete>
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                        >
                            Validate
                        </v-btn>
                    </v-col>
                    <v-col align-self="center">
                        <v-row justify="center">
                            <v-color-picker hide-mode-switch mode="hexa" v-model="color"></v-color-picker>
                        </v-row>
                    </v-col>
                </v-row>
            </v-form>
        </v-sheet>
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
        props: ['users'],
        data: () => ({
            valid: true,
            name: '',
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 255 && v.length >= 2) || 'Name must be between 2 and 255 characters',
            ],
            desc: '',
            descRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Desc must be between 2 and 255 characters',
            ],
            user: null,
            checkbox: false,
            lazy: false,
            items: [],
            userNames: {},
            snackbar: false,
            snackbarText: '',
            color: "#FFFFFFFF",
        }),

        mounted() {
            this.makeVars()
        },

        methods: {
            validate() {
                this.$refs.form.validate()
                let data = {
                    "name": this.name,
                    "desc": this.desc,
                    "president_id": this.userNames[this.user],
                    "color": this.color.substring(0, 7)
                }
                axios.post('/api/association', data).then((response) => {
                    status = response.status;
                    this.snackbarText = "Created " + this.name;
                    this.snackbar = true;
                }).finally(()=>{
                    window.location.href = '/admin/associations'
                })
            },
            makeVars() {
                this.users.forEach(user =>
                    this.items.push(user.first_name + " " + user.last_name)
                )
                this.users.forEach(user =>
                    this.userNames[user.first_name + " " + user.last_name] = user.id
                )
            }
        },
    }
</script>

<style scoped>

</style>
