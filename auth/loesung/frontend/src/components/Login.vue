<script setup>
import axios from 'axios'
import { ref } from 'vue';
import { useAuthStore } from '@/auth'
import { useRouter } from 'vue-router'

const loginChoice = ref(false);

const email = ref('');
const password = ref('');
const message = ref('');

const showErrorText = ref(false);

const apiUrl = 'http://localhost:8000/api';

const router = useRouter()

const authStore = useAuthStore()

async function register() {
    showErrorText.value = false;
    try {
        const response = await axios.put(`${apiUrl}/users`, { email: email.value, password: password.value });
        authStore.login(response.data);
        router.push("/")
    }
    catch (e) {
        showErrorText.value = true;
        console.error("Fehler beim Registrieren", e)
    }
}

async function login() {
    showErrorText.value = false;
    try {
        const response = await axios.post(`${apiUrl}/api/login`, { email: email.value, password: password.value });
        authStore.login(response.data);
        router.push("/")
    }
    catch (e) {
        showErrorText.value = true;
        console.error("Fehler beim Registrieren", e)
    }
}

</script>
<template>
    <div class="container" v-if="loginChoice">
        <div>
            <h1>👤 Login <button class="secondary" @click="() => loginChoice = false">zur Registrierung</button></h1>

            <p v-if="showErrorText" class="error">Bei dieser Aktion ist ein Fehler aufgetreten. Details in der
                Entwicklerkonsole des Browsers.</p>

            <div class="form-group">
                <input v-model="email" type="email" placeholder="E-Mail" />
            </div>

            <div class="form-group">
                <input v-model="password" type="password" placeholder="Passwort" />
            </div>

            <button @click="login">Login</button>

        </div>
    </div>
    <div class="container" v-else>
        <div>
            <h1>👤 Registrieren <button class="secondary" @click="() => loginChoice = true">zum Login</button></h1>

            <p v-if="showErrorText" class="error">Bei dieser Aktion ist ein Fehler aufgetreten. Details in der
                Entwicklerkonsole des Browsers.</p>


            <div class="form-group">
                <input v-model="email" type="email" placeholder="E-Mail" />
            </div>

            <div class="form-group">
                <input v-model="password" type="password" placeholder="Passwort" />
            </div>

            <button @click="register">Registrieren</button>
        </div>
    </div>
    <div class="container" v-if="message">

        <p class="message">{{ message }}</p>
    </div>
</template>


<style scoped>
.container {
    max-width: 400px;
    margin: 60px auto;
    padding: 25px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    text-align: center;
}

h1 {
    margin-bottom: 20px;
}


.error {
    color: red;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

input {
    width: 95%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 8px;
    background: #2196F3;
    color: white;
    cursor: pointer;
    transition: 0.2s;
}

.secondary {
    width: auto;
    float: right;
    background-color: gray;
}

button:hover {
    background: #1976D2;
}

.message {
    margin-top: 15px;
    font-size: 14px;
}
</style>
