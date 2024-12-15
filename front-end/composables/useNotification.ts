import { ref } from 'vue'

interface NotificationState {
    show: boolean
    message: string
    color: string
    timeout: number
}

export const useNotification = () => {
    const notification = ref<NotificationState>({
        show: false,
        message: '',
        color: 'success',
        timeout: 3000
    })

    const showNotification = (message: string, type: 'success' | 'error' | 'warning' = 'success') => {
        notification.value = {
            show: true,
            message,
            color: type,
            timeout: 3000
        }
    }

    return {
        notification,
        showNotification
    }
}
