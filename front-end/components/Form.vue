<template>
    <v-container>
        <!-- Botão para abrir o formulário -->
        <v-btn color="primary" @click="toggleForm">{{ showForm ? 'Fechar Formulário' : 'Novo Usuário' }}</v-btn>

        <!-- Formulário: exibido apenas quando showForm for true -->
        <v-card v-if="showForm" class="mt-4 pa-4">
            <form @submit.prevent="submit">
                <v-text-field v-model="name.value.value" :counter="100" :error-messages="name.errorMessage.value"
                    label="Nome">
                </v-text-field>

                <v-text-field v-model="cpf.value.value" :counter="11" :error-messages="cpf.errorMessage.value"
                    label="CPF">
                </v-text-field>

                <v-text-field v-model="email.value.value" :error-messages="email.errorMessage.value" label="E-mail">
                </v-text-field>

                <v-text-field v-model="senha.value.value" :error-messages="senha.errorMessage.value" label="Senha" type="password">
                </v-text-field>

                <v-btn class="me-4" type="submit" color="primary" :loading="loading">
                    Salvar
                </v-btn>

                <v-btn @click="handleReset" color="warning">
                    Limpar
                </v-btn>
            </form>
        </v-card>

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
    import { ref } from 'vue'
    import { useField, useForm } from 'vee-validate'
    import { useNuxtApp } from '#app'
    import { useNotification } from '~/composables/useNotification'

    const { $axios } = useNuxtApp()
    const { notification, showNotification } = useNotification()
    const loading = ref(false)

    // Emitir evento para o componente pai
    const emit = defineEmits(['user-created'])

    // Variável de controle do formulário
    const showForm = ref(false)

    // Função para alternar a visibilidade do formulário
    const toggleForm = () => {
        showForm.value = !showForm.value
    }

    // Regex para validação de email
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/

    // Validação com vee-validate
    const { handleSubmit, handleReset } = useForm({
        validationSchema: {
            cpf(value) {
                if (value?.length === 11) return true
                return 'CPF deve ter exatamente 11 caracteres.'
            },
            name(value) {
                if (value?.length >= 2) return true
                return 'O nome deve ter pelo menos 2 caracteres.'
            },
            senha(value) {
                if (value?.length >= 6) return true
                return 'A senha deve ter pelo menos 6 caracteres.'
            },
            email(value) {
                if (emailRegex.test(value)) return true
                return 'Digite um e-mail válido (exemplo: usuario.123@dominio.com)'
            }
        },
    })

    const name = useField('name')
    const senha = useField('senha')
    const email = useField('email')
    const cpf = useField('cpf')

    // Função de envio
    const submit = handleSubmit(async (values) => {
        loading.value = true
        try {
            console.log('Enviando dados:', values)
            
            // Envia os dados para a API Laravel
            const response = await $axios.post('/users', {
                name: values.name,
                email: values.email,
                cpf: values.cpf,
                password: values.senha
            })

            console.log('Resposta da API:', response.data)

            // Limpar os campos após o envio
            handleReset()
            showForm.value = false // Fecha o formulário após o envio
            
            // Emitir evento com os dados do novo usuário
            window.dispatchEvent(new CustomEvent('user-created', {
                detail: { user: response.data.user }
            }))
            
            showNotification('Usuário criado com sucesso!', 'success')
        } catch (error) {
            console.error('Erro ao criar usuário:', error)
            showNotification(error.response?.data?.error || 'Erro ao criar usuário', 'error')
        } finally {
            loading.value = false
        }
    })
</script>

<style scoped>
    .v-btn {
        margin-bottom: 16px;
    }
</style>