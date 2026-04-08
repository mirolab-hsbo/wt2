<script setup>
import { onMounted, ref } from 'vue'

const todos = ref([]);
const newTodo = ref("");

async function loadTodos() {
    //TODO
}
async function addTodo() {
    //TODO
}
async function updateTodo(todo) {
    //TODO
}
async function deleteTodo(id) {
    //TODO
}

onMounted(() => {
    loadTodos();
})

</script>
<!-- KI-generiert (gpt-5), mit Anpassungen -->
<template>
    <div class="todo-container">
        <h1>📝 Meine ToDo-Liste</h1>

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

.input-row button {
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    background: #4CAF50;
    color: white;
    cursor: pointer;
    transition: 0.2s;
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
