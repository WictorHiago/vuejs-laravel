<template>
    <v-container>
        <!-- Tabela de Usuários -->
        <v-data-table :headers="headers" :items="users" class="elevation-1">
            <template v-slot:[`item.actions`]="{ item }">
                <v-row class="flex-wrap" no-gutters>
                    <v-col cols="12" xs="12" sm="6" class="pa-1">
                        <v-btn color="primary" block @click="openEditModal(item)">EDITAR</v-btn>
                    </v-col>
                    <v-col cols="12" xs="12" sm="6" class="pa-1">
                        <v-btn color="red" block dark @click="deleteUser(item)">APAGAR</v-btn>
                    </v-col>
                </v-row>
            </template>
        </v-data-table>

        <!-- Modal de Edição -->
        <v-dialog v-model="showEditModal" max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Editar Usuário</span>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form">
                        <v-text-field label="Nome" v-model="selectedUser.name" outlined></v-text-field>
                        <v-text-field label="CPF" v-model="selectedUser.cpf" outlined></v-text-field>
                        <v-text-field label="Email" v-model="selectedUser.email" outlined></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="saveUser">Salvar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                headers: [
                    { text: 'ID', value: 'id' },
                    { text: 'Nome', value: 'name' },
                    { text: 'CPF', value: 'cpf' },
                    { text: 'Email', value: 'email' },
                    { text: 'Ações', value: 'actions', sortable: false },
                ],
                users: [
                    { id: 1, name: 'Wictor Hiago', cpf: '123.456.789-00', email: 'wictor@example.com' },
                    { id: 2, name: 'João Silva', cpf: '987.654.321-00', email: 'joao@example.com' },
                    { id: 3, name: 'Maria Oliveira', cpf: '456.789.123-00', email: 'maria@example.com' },
                ],
                showEditModal: false,
                selectedUser: {}, // Armazena o usuário selecionado
            };
        },
        methods: {
            openEditModal(user) {
                this.selectedUser = { ...user }; // Clona o usuário selecionado
                this.showEditModal = true; // Abre o modal
            },

            saveUser() {
                const index = this.users.findIndex((u) => u.id === this.selectedUser.id);
                if (index !== -1) {
                    this.$set(this.users, index, { ...this.selectedUser }); // Atualiza o usuário
                }
                this.closeEditModal();
            },
            deleteUser(user) {
                this.users = this.users.filter((u) => u.id !== user.id);
            },
        },
    };
</script>

<style scoped>
    .v-btn {
        width: 100%;
    }
</style>