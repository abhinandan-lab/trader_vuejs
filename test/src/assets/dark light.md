Hi I am working on vue js project with composition api and in script to be short form method like <script setup>....</script 



hostinger db credentials

sql user 
u569028862_trader
sql pass
|p|7J4#$Rb7
db name
u569028862_trader







I want to apply a feature of dark and light theme 

how my dark and light theme colors are managed is 

by this css root variables
:root {
  --bg-color: #ebebeb;
  --text-color: #333;
  --card-bg: #fff;
  --divider-color: #ddd;
  --display_width: 1400px;
}
[data-theme="dark"] {
  --bg-color: #121212;
  --text-color: #e0e0e0;
  --card-bg: #1e1e1e;
  --divider-color: #333;
}
[data-theme="light"] {
  --bg-color: #ebebeb;
  --text-color: #333;
  --card-bg: #fff;
  --divider-color: #ddd;
}


Here is my App.vue

<script setup>
import { onMounted, reactive, provide } from 'vue';
import Header from '@/components/Header.vue';
import { RouterView } from 'vue-router';

// Define the theme as reactive and provide it to child components
const theme = reactive({ isDark: false });
provide('theme', theme);

onMounted(() => {
  // Set the initial theme on the body element
  document.body.setAttribute('data-theme', theme.isDark ? 'dark' : 'light');
});
</script>

<template>
  <Header />
  <RouterView />
</template>

____________________________________________________________________

here is my main.js

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

____________________________________________________________________


I have my toggle button html code you can covert this in component

      <div class="toggleUI">
        <div @change="toggleTheme" class="toggle-container">
          <input type="checkbox" id="toggle" class="toggle-checkbox" v-model="theme.isDark" />
          <label for="toggle" class="toggle-label">
            <span class="toggle-circle">
              <i :class="theme.isDark ? 'pi pi-moon' : 'pi pi-sun'"></i>
              as i want to show icons for light and dark (this could be optional if your dont pass it will be blank)
            </span>
          </label>
        </div>
      </div>



.toggleUI {
    .toggle-container {
        display: inline-block;
        position: relative;
        width: 50px;
        height: 25px;
    }

    .toggle-checkbox {
        display: none;
    }

    .toggle-label {
        background-color: #ccc;
        border-radius: 25px;
        cursor: pointer;
        display: inline-block;
        height: 100%;
        position: relative;
        transition: background-color 0.3s;
        width: 100%;
    }

    .toggle-circle {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: white;
        border-radius: 50%;
        height: 21px;
        position: absolute;
        top: 2px;
        left: 2px;
        transition: transform 0.3s;
        width: 21px;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #4caf50;
    }

    .toggle-checkbox:checked+.toggle-label .toggle-circle {
        transform: translateX(25px);
    }
}




____________________________________________________________________


header.vue
I want a header component with toggle button which toggles the theme 


can write all the nessary codes in header and if possible can you create reuseable toggle component to use anywhere for any purpose


rephrase me what you understood 

