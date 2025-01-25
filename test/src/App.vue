<script setup>
import { onMounted, reactive, provide } from 'vue';
import { RouterView } from 'vue-router';

import Header from '@/components/Header.vue';

const userDetail = reactive({username: '', profilePic: '', activeStrategy: ''});
provide('userDetail', userDetail);


const themeData = reactive({ isDark: true });
provide('themeData', themeData);

onMounted(() => {
  // Apply the theme based on the initial state
  document.body.setAttribute('data-theme', 'dark');
});
</script>

<template>
  <Header />
  <RouterView />
</template>
