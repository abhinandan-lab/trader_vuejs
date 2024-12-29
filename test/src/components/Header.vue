<script setup>
import { defineProps } from 'vue';

import { inject } from 'vue';

const theme = inject('theme');

const toggleTheme = () => {
  console.log("before toggle:", theme.isDark);

  theme.isDark = !theme.isDark;

  console.log("after toggle:", theme.isDark);

  document.body.setAttribute('data-theme', theme.isDark ? 'light' : 'dark');
};



defineProps({
  welcome_msg: {
    type: String,
    default: "Welcome to trader's journal",
  }
});
</script>


<template>

  <div class="full_width bg_card">


    <div class="top_header">
      <i :class="theme.isDark ? 'pi pi-moon' : 'pi pi-sun'"></i>
      <i :class="theme.isDark ? 'pi pi-moon' : 'pi pi-sun'"></i>
      

      <p> {{ welcome_msg }} </p>

      {{ theme.isDark }}

      <div class="toggleUI">
        <div @change="toggleTheme" class="toggle-container">
          <input type="checkbox" id="toggle" class="toggle-checkbox" v-model="theme.isDark" />
          <label for="toggle" class="toggle-label">
            <span class="toggle-circle">
              <i :class="theme.isDark ? 'pi pi-moon' : 'pi pi-sun'"></i>
            </span>
          </label>
        </div>
      </div>
    </div>

  </div>
</template>
