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
                dialog: false
            }
        },
        mounted() {
            axios.get('/api/images').then(response => {

                this.$set(this, 'images', response.data);

            }, error => {

            });
        },
        methods: {
            add(img) {
                this.images.push(img);
            }
        }
    }
</script>
