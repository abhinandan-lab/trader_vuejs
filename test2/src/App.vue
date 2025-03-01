<script setup>
import { onMounted, reactive, provide } from 'vue';
import { RouterView } from 'vue-router';
import { currentUser } from '@/config/userStatus';
import HeaderVue from '@/components/Header.vue';

// const userDetail = reactive({username: '', profilePic: '', activeStrategy: ''});
// provide('userDetail', userDetail);


const themeData = reactive({ isDark: true });
provide('themeData', themeData);

onMounted(() => {
  // Apply the theme based on the initial state
  document.body.setAttribute('data-theme', 'dark');
});
</script>

<template>
  <HeaderVue />
  <RouterView />

 datatable
  https://chatgpt.com/share/67b76f80-38b4-800d-9af5-502dfc242499


</template>
