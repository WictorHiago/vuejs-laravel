<template>
    <v-container>
        <!-- Tabela de Usuários -->
        <v-data-table
            :headers="headers"
            :items="users"
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:item="{ item }">
                <tr>
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.cpf }}</td>
                    <td>{{ item.email }}</td>
                    <td>
                        <v-row dense>
                            <v-col cols="auto">
                                <v-btn
                                    color="primary"
                                    size="small"
                                    @click="openEditModal(item)"
                                >
                                    <v-icon>mdi-pencil</v-icon>
                                    Editar
                                </v-btn>
                            </v-col>
                            <v-col cols="auto">
                                <v-btn
                                    color="error"
                                    size="small"
                                    @click="confirmDelete(item)"
                                >
                                    <v-icon>mdi-delete</v-icon>
                                    Excluir
                                </v-btn>
                            </v-col>
                        </v-row>
                    </td>
                </tr>
            </template>

            <template v-slot:no-data>
                <v-alert
                    type="info"
                    variant="tonal"
                    class="ma-2"
                >
                    {{ loading ? 'Carregando usuários...' : 'Nenhum usuário encontrado' }}
                </v-alert>
            </template>
        </v-data-table>

        <!-- Modal de Edição -->
        <v-dialog v-model="showEditModal" max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">Editar Usuário</span>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" @submit.prevent="saveUser">
                        <v-text-field
                            v-model="selectedUser.name"
                            label="Nome"
                            required
                            :rules="[v => !!v || 'Nome é obrigatório']"
                        ></v-text-field>
                        <v-text-field
                            v-model="selectedUser.cpf"
                            label="CPF"
                            required
                            :rules="[
                                v => !!v || 'CPF é obrigatório',
                                v => v?.length === 11 || 'CPF deve ter 11 dígitos'
                            ]"
                        ></v-text-field>
                        <v-text-field
                            v-model="selectedUser.email"
                            label="Email"
                            required
                            :rules="[
                                v => !!v || 'Email é obrigatório',
                                v => /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(v) || 'Digite um e-mail válido (exemplo: usuario.123@dominio.com)'
                            ]"
                        ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey-darken-1"
                        variant="text"
                        @click="showEditModal = false"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="primary"
                        variant="text"
                        @click="saveUser"
                        :loading="saving"
                        :disabled="saving"
                    >
                        Salvar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Dialog de Confirmação de Exclusão -->
        <v-dialog v-model="showDeleteDialog" max-width="400px">
            <v-card>
                <v-card-title class="text-h5">
                    Confirmar Exclusão
                </v-card-title>
                <v-card-text>
                    Tem certeza que deseja excluir o usuário "{{ selectedUser?.name }}"?
                    Esta ação não pode ser desfeita.
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey-darken-1"
                        variant="text"
                        @click="showDeleteDialog = false"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        color="error"
                        variant="text"
                        @click="deleteUser"
                        :loading="deleting"
                        :disabled="deleting"
                    >
                        Excluir
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Snackbar para notificações -->
        <v-snackbar
            v-model="notification.show"
            :color="notification.color"
            :timeout="notification.timeout"
            location="top"
        >
            {{ notification.message }}
            <template v-slot:actions>
                <v-btn
                    variant="text"
                    @click="notification.show = false"
                >
                    Fechar
                </v-btn>
            </template>
        </v-snackbar>
    </v-container>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useNuxtApp } from '#app'
import { useNotification } from '~/composables/useNotification'

const { $axios } = useNuxtApp()
const { notification, showNotification } = useNotification()

const loading = ref(false)
const saving = ref(false)
const deleting = ref(false)
const users = ref([])
const showEditModal = ref(false)
const showDeleteDialog = ref(false)
const selectedUser = ref({})

const headers = [
    { title: 'ID', key: 'id', align: 'start' },
    { title: 'Nome', key: 'name', align: 'start' },
    { title: 'CPF', key: 'cpf', align: 'start' },
    { title: 'Email', key: 'email', align: 'start' },
    { title: 'Ações', key: 'actions', sortable: false, align: 'center' },
]

// Buscar usuários
const fetchUsers = async () => {
    loading.value = true
    try {
        const response = await $axios.get('/users')
        console.log('Dados recebidos:', response.data)
        if (response.data && response.data.users) {
            users.value = response.data.users
        } else {
            console.error('Formato de resposta inesperado:', response.data)
            users.value = []
        }
    } catch (error) {
        console.error('Erro ao buscar usuários:', error)
        if (error.response) {
            console.error('Status:', error.response.status)
            console.error('Data:', error.response.data)
        }
        showNotification('Erro ao carregar usuários', 'error')
        users.value = []
    } finally {
        loading.value = false
    }
}

// Atualizar lista localmente
const updateLocalList = (updatedUser) => {
    const index = users.value.findIndex(user => user.id === updatedUser.id)
    if (index !== -1) {
        users.value[index] = updatedUser
    }
}

// Adicionar usuário localmente
const addUserToList = (newUser) => {
    console.log('Adicionando novo usuário à lista:', newUser)
    if (newUser && newUser.id) {
        users.value = [...users.value, newUser]
    } else {
        console.error('Dados do usuário inválidos:', newUser)
    }
}

// Remover usuário localmente
const removeUserFromList = (userId) => {
    users.value = users.value.filter(user => user.id !== userId)
}

// Abrir modal de edição
const openEditModal = (item) => {
    selectedUser.value = { ...item }
    showEditModal.value = true
}

// Confirmar exclusão
const confirmDelete = (item) => {
    selectedUser.value = { ...item }
    showDeleteDialog.value = true
}

// Salvar usuário
const saveUser = async () => {
    saving.value = true
    try {
        const response = await $axios.put(`/users/${selectedUser.value.id}`, selectedUser.value)
        updateLocalList(response.data.user)
        showEditModal.value = false
        showNotification('Usuário atualizado com sucesso!', 'success')
    } catch (error) {
        console.error('Erro ao atualizar usuário:', error)
        showNotification(error.response?.data?.error || 'Erro ao atualizar usuário', 'error')
    } finally {
        saving.value = false
    }
}

// Deletar usuário
const deleteUser = async () => {
    deleting.value = true
    try {
        await $axios.delete(`/users/${selectedUser.value.id}`)
        removeUserFromList(selectedUser.value.id)
        showDeleteDialog.value = false
        showNotification('Usuário excluído com sucesso!', 'success')
    } catch (error) {
        console.error('Erro ao excluir usuário:', error)
        showNotification(error.response?.data?.error || 'Erro ao excluir usuário', 'error')
    } finally {
        deleting.value = false
    }
}

// Função para atualizar a lista quando um novo usuário for criado
const handleUserCreated = (event) => {
    console.log('Evento user-created recebido', event?.detail)
    if (event?.detail?.user) {
        const newUser = event.detail.user
        console.log('Novo usuário a ser adicionado:', newUser)
        addUserToList(newUser)
    } else {
        console.error('Dados do usuário não encontrados no evento:', event)
        fetchUsers() // Fallback: recarrega a lista completa
    }
}

// Montar componente e adicionar listener
onMounted(() => {
    console.log('Componente montado, buscando usuários...')
    fetchUsers()
    window.addEventListener('user-created', handleUserCreated)
})

// Limpar listener ao desmontar
onUnmounted(() => {
    window.removeEventListener('user-created', handleUserCreated)
})
</script>

<style scoped>
.v-btn {
    width: 100%;
}
</style>