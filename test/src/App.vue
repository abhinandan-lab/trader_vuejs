<script setup>
import { onMounted } from 'vue';
import Header from '@/components/Header.vue';
import { RouterView } from 'vue-router';
import { inject } from 'vue';

// const theme = inject('theme');

onMounted(() => {
  // Apply the theme based on the initial state
  // document.body.setAttribute('data-theme', 'light');

  // console.log(theme);

});
</script>

<template>
  <Header />
  <RouterView />
</template>
