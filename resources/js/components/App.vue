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
                <h1>content</h1>

                <upload-image-dialog v-if="dialog" :value.sync="dialog"></upload-image-dialog>
            </v-container>
        </v-content>
        <v-footer app></v-footer>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false
            }
        },
        mounted() {
        }
    }
</script>
