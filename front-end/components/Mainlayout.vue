<template>
    <v-responsive class="mx-auto" max-width="1980px">
        <v-app :theme="theme">
            <v-app-bar class="px-3">
                <div>
                    <v-avatar color="surface-variant"></v-avatar>
                    <span class="pl-4">Wictor Hiago</span>

                </div>
                <v-spacer></v-spacer>
                <v-btn :prepend-icon="theme === 'light' ? 'mdi-weather-sunny' : 'mdi-weather-night'"
                    :text="theme === 'light' ? 'Light' : 'Dark'" slim @click="onClick"></v-btn>
            </v-app-bar>

            <v-main>
                <v-container>
                    <h1>Cadastro de Usuários</h1>
                    <Form></Form>
                    <v-separator></v-separator>
                    <ListUser></ListUser>
                </v-container>
            </v-main>
        </v-app>
    </v-responsive>
</template>

<script setup>
    import { ref } from 'vue'
    /* components */
    import Form from './Form.vue'
    import ListUser from './ListUser.vue'

    const theme = ref('light')

    function onClick() {
        theme.value = theme.value === 'light' ? 'dark' : 'light'
    }
</script>