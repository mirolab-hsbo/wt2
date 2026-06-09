import { createRouter, createWebHashHistory } from 'vue-router'
import { useAuthStore } from '@/auth'
import Login from './components/Login.vue'
import List from './components/List.vue'

const router = createRouter({
    history: createWebHashHistory(import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: "todolist", component: List, meta: { auth_required: true, } },
        { path: '/login', name: "login", component: Login, meta: { auth_required: false, } },
    ],
})

router.beforeEach(async (to, from) => {
    const authStore = useAuthStore()

    if (to.meta.auth_required && !authStore.isAuthenticated) {
        return { name: 'login' }
    }
})

export default router
