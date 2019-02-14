<template>
    <v-app dark>
        <v-toolbar app>
            <v-toolbar-title>Image-API</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat @click="dialog = true">Upload image</v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-content>
            <v-container fluid>
                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs12 md3>
                            <v-text-field :disabled="loading" @keyup.enter="loadImages" v-model="filter.submitter" label="Submitter"></v-text-field>
                        </v-flex>
                        <v-flex xs12 md3>
                            <v-text-field :disabled="loading" @keyup.enter="loadImages" v-model="filter.location" label="Location"></v-text-field>
                        </v-flex>
                        <v-flex xs12 md3>
                            <v-text-field :disabled="loading" @keyup.enter="loadImages" v-model="filter.topic" label="Topic"></v-text-field>
                        </v-flex>
                        <v-flex xs12 md3>
                            <v-btn block :loading="loading" :disabled="loading" @click="loadImages">Search</v-btn>
                        </v-flex>
                    </v-layout>
                </v-container>

                <v-container grid-list-md>
                    <v-layout row wrap>
                        <v-flex xs12 md4 :key="img.id" v-for="img in images">
                            <v-img :src="img.href"></v-img>
                        </v-flex>
                    </v-layout>
                </v-container>

                <upload-image-dialog v-if="dialog" @upload="add" :value.sync="dialog"></upload-image-dialog>
            </v-container>
        </v-content>
        <v-footer app></v-footer>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                images: [],
                filter: {
                    submitter: '',
                    location: '',
                    topic: ''
                },
                dialog: false,
                loading: false
            }
        },
        mounted() {
            this.loadImages();
        },
        methods: {
            loadImages() {
                this.loading = true;

                axios.get('/api/images', {
                    params: this.filter
                }).then(response => {

                    this.$set(this, 'images', response.data);
                    this.loading = false;

                }, error => {
                    this.loading = false;
                });
            },
            add(img) {
                this.images.push(img);
            }
        }
    }
</script>
