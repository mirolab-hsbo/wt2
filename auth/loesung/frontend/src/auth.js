import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('token') || null,
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
    },

    actions: {
        login(userInfo) {
            this.token = userInfo.token
            localStorage.setItem('token', userInfo.token)
        },
        logout() {
            this.token = null
            localStorage.removeItem('token')
        }
    }
})



