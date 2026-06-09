<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'
import { useAuthStore } from '@/auth'
import { useRouter } from 'vue-router'

const todos = ref([]);
const newTodo = ref("");

const showErrorText = ref(false);

const apiUrl = 'http://localhost:8000/api';

const router = useRouter()

const authStore = useAuthStore()

axios.defaults.headers.common = { 'Authorization': `Bearer ${authStore.token}`, 'Accept': 'application/json' }

async function loadTodos() {
    showErrorText.value = false;
    try {
        const res = await axios.get(`${apiUrl}/todos`)
        todos.value = res.data
    } catch (e) {
        showErrorText.value = true;
        console.error('Fehler beim Laden', e)
    }
}
async function addTodo() {
    showErrorText.value = false;
    if (!newTodo.value.trim()) return
    try {
        const res = await axios.put(`${apiUrl}/todos`, { text: newTodo.value })
        todos.value.push(res.data)
        newTodo.value = ''
    } catch (e) {
        showErrorText.value = true;
        console.error('Fehler beim Hinzufügen', e)
    }
}
async function updateTodo(todo) {
    showErrorText.value = false;
    try {
        await axios.post(`${apiUrl}/todo/${todo.id}`, { text: todo.text })
    } catch (e) {
        showErrorText.value = true;
        console.error('Fehler beim Aktualisieren', e)
    }
}
async function deleteTodo(id) {
    showErrorText.value = false;
    try {
        await axios.delete(`${apiUrl}/todo/${id}`)
        todos.value = todos.value.filter(t => t.id !== id)
    } catch (e) {
        showErrorText.value = true;
        console.error('Fehler beim Löschen', e)
    }
}

onMounted(() => {
    loadTodos();
})

async function logout() {
    showErrorText.value = false;
    try {
        await axios.post(`${apiUrl}/auth/logout`)
        authStore.logout()
        router.push("/login")
    } catch (e) {
        showErrorText.value = true;
        console.error('Fehler beim Logout', e)
    }
}

</script>
<template>
    <div class="todo-container">
        <h1>📝 Meine ToDo-Liste <button class="secondary" @click="logout">Logout</button></h1>

        <p v-if="showErrorText" class="error">Bei dieser Aktion ist ein Fehler aufgetreten. Details in der
            Entwicklerkonsole des Browsers.</p>

        <div class="input-row">
            <input v-model="newTodo" @keyup.enter="addTodo" placeholder="Neues ToDo..." />
            <button @click="addTodo">Hinzufügen</button>
        </div>

        <ul>
            <li v-for="todo in todos" :key="todo.id" class="todo-item">
                <input type="checkbox" @change="deleteTodo(todo.id)" />
                <input class="todo-text" v-model="todo.text" @blur="updateTodo(todo)" @keyup.enter="updateTodo(todo)" />
            </li>
        </ul>
    </div>
</template>


<style scoped>
.todo-container {
    max-width: 500px;
    margin: 40px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.error {
    color: red;
    text-align: center;
}


.input-row {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.input-row input {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.input-row button,
.secondary {
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    background: #4CAF50;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.secondary {
    float: right;
    background-color: gray;
}

.input-row button:hover {
    background: #43a047;
}

ul {
    list-style: none;
    padding: 0;
}

.todo-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
    background: #f7f7f7;
    transition: 0.2s;
}

.todo-item:hover {
    background: #eeeeee;
}

.todo-text {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 14px;
}

.todo-text:focus {
    outline: none;
}

.delete-btn {
    background: transparent;
    border: none;
    color: #e53935;
    font-size: 18px;
    cursor: pointer;
}

.delete-btn:hover {
    color: #b71c1c;
}
</style>
