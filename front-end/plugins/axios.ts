// plugins/axios.ts
import axios from 'axios'

export default defineNuxtPlugin(nuxtApp => {
  const axiosInstance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    withCredentials: true
  })

  // Interceptor para tratar erros
  axiosInstance.interceptors.response.use(
    response => response,
    error => {
      console.error('Erro na requisição:', error)
      if (error.response) {
        console.error('Status:', error.response.status)
        console.error('Data:', error.response.data)
        if (error.response.status === 405) {
          console.error('Método não permitido. Verifique a configuração do backend.')
        }
      }
      return Promise.reject(error)
    }
  )

  // Adiciona o axios à instância do Nuxt
  nuxtApp.provide('axios', axiosInstance)
})
