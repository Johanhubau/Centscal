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
                            label="Description"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="price"
                            :counter="255"
                            :rules="priceRules"
                            label="Price"
                            required
                        ></v-text-field>

                        <v-btn
                            :disabled="!valid"
                            color="success"
                            class="mr-4"
                            @click="validate"
                        >
                            Validate
                        </v-btn>
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
        name: "updateCardComponent",
        props: ['material'],
        data: () => ({
            lazy: false,
            snackbar: false,
            snackbarText: '',
            valid: true,
            name: '',
            nameRules: [
                v => (v && v.length <= 255 && v.length >= 2) || 'Name must be between 2 and 255 characters',
            ],
            desc: '',
            descRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Description must be between 2 and 255 characters',
            ],
            price: '',
            priceRules: [
                v => ((v.length <= 255 && v.length >= 2) || v.length === 0) || 'Price must be between 2 and 255 characters',
            ],
        }),
        mounted() {
            this.makeVars()
        },
        methods: {
            validate() {
                this.$refs.form.validate()
                let data = {}
                if (this.name !== this.material.name) {
                    data["name"] = this.name
                }
                if (this.desc !== this.material.desc) {
                    data["desc"] = this.desc
                }
                if (this.price !== this.material.price) {
                    data["price"] = this.price
                }
                if (Object.keys(data).length === 0) {
                    this.snackbarText = "Nothing to change!";
                    this.snackbar = true;
                } else {
                    axios.post('/api/material/'+this.material.id, data).then((response) => {
                        status = response.status;
                        this.snackbarText = "Updated " + this.name;
                        this.snackbar = true;
                    }).finally(()=>{
                        window.location.href = '/association/' + this.association_id
                    })
                }
            },
            makeVars() {
                this.name = this.material.name
                this.desc = this.material.desc
                this.price = this.material.price
            }
        }
    }
</script>

<style scoped>

</style>
