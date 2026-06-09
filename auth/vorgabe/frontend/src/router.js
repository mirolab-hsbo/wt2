import { createRouter, createWebHashHistory } from 'vue-router'
import Login from './components/Login.vue'
import List from './components/List.vue'

const router = createRouter({
    history: createWebHashHistory(import.meta.env.BASE_URL),
    routes: [
        { path: '/', name: "todolist", component: List },
        { path: '/login', name: "login", component: Login },
    ],
})



export default router
