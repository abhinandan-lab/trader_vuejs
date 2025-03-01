import '@/assets/login.css';

import 'primeicons/primeicons.css';

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)

const themeState = { isDark: false }; // Shared state
app.provide('theme', themeState); // Provide it globally

app.mount('#app')
