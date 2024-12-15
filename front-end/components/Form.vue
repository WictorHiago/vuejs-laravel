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

                <v-text-field v-model="senha.value.value" :error-messages="senha.errorMessage.value" label="Senha">
                </v-text-field>

                <v-btn class="me-4" type="submit" color="primary">
                    Salvar
                </v-btn>

                <v-btn @click="handleReset" color="warning">
                    Limpar
                </v-btn>
            </form>
        </v-card>
    </v-container>
</template>

<script setup>
    import { ref } from 'vue'
    import { useField, useForm } from 'vee-validate'

    // Variável de controle do formulário
    const showForm = ref(false)

    // Função para alternar a visibilidade do formulário
    const toggleForm = () => {
        showForm.value = !showForm.value
    }

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
                if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true
                return 'Deve ser um e-mail válido.'
            }
        },
    })

    const name = useField('name')
    const senha = useField('senha')
    const email = useField('email')
    const cpf = useField('cpf')

    // Função de envio
    const submit = handleSubmit(values => {
        alert(JSON.stringify(values, null, 2))
        // Limar os campos apos o envio
        handleReset()
        showForm.value = false // Fecha o formulário após o envio
    })
</script>

<style scoped>
    .v-btn {
        margin-bottom: 16px;
    }
</style>