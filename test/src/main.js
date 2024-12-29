import '@/assets/login.css';

import 'primeicons/primeicons.css';

import router from './router';


import { createApp } from 'vue';
import App from './App.vue';

// Create the app instance
const app = createApp(App);


app.use(router);



// Global theme state
const themeState = { isDark: false }; // Shared state
app.provide('theme', themeState); // Provide it globally

// Mount the app
app.mount('#app');