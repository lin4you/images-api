<template>
    <v-dialog v-model="dialog" width="500">
        <v-card>
            <v-card-title primary-title>
                <h2>Upload Image</h2>
            </v-card-title>

            <v-card-text>
                <v-form v-model="valid">
                    <v-container>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-text-field
                                        v-model="image.submitter"
                                        :counter="255"
                                        :disabled="loading"
                                        label="Submitter"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <v-text-field
                                        v-model="image.location"
                                        :counter="255"
                                        :disabled="loading"
                                        label="Location"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <v-text-field
                                        v-model="image.topic"
                                        :counter="255"
                                        :disabled="loading"
                                        label="Topic"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <v-btn block :disabled="loading" @click="select">Select Image</v-btn>

                                <span v-if="image.file !== null">{{ image.file.name }}</span>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-btn flat @click="dialog = false" :disabled="loading">
                    cancel
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" flat @click="upload" :disabled="loading || this.image.file === null" :loading="loading">
                    submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            value: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                dialog: false,
                valid: false,
                loading: false,
                image: {
                    submitter: '',
                    location: '',
                    topic: '',
                    file: null
                }
            }
        },
        watch: {
            value() {
                this.dialog = this.value;
            },
            dialog() {
                this.$emit('update:value', this.dialog);
            }
        },
        mounted() {
            this.dialog = this.value;
        },
        methods: {
            select() {
                let fileSelector = document.createElement('input');
                fileSelector.setAttribute('type', 'file');
                fileSelector.setAttribute('accept', 'image/jpeg,image/gif,image/png');

                fileSelector.addEventListener('change', event => {
                    this.image.file = event.target.files[0];
                });

                fileSelector.click();
            },
            upload() {
                if (this.loading) {
                    return;
                }

                this.loading = true;

                let formData = new FormData();
                _.each(this.image, (value, key) => {
                    formData.append(key, value);
                });

                axios.post(`/api/images/`, formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {

                        this.$emit('upload', response.data);

                        this.loading = false;
                        this.dialog = false;

                }, errorResponse => {
                    this.loading = false;
                });
            }
        }
    }
</script>
