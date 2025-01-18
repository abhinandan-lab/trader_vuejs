<script setup>
import { onMounted, reactive, ref, provide } from 'vue';
import { RouterView } from 'vue-router';


const themeData = reactive({ isDark: true });
provide('themeData', themeData)



onMounted(() => {
  // Apply the theme based on the initial state
  document.body.setAttribute('data-theme', 'dark');
});


</script>

<template>
  <RouterView />
</template>
