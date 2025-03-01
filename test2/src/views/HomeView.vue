<script setup>
import Settings from '@/components/settings.vue';
import { API_BASE_URL, getCookie } from '@/config/config';
import axios from 'axios';
import {  onMounted } from 'vue';
import { currentUser } from '@/config/userStatus';

const callApi = async () => {
  try {
    let mycookie = getCookie('session');
    const response = await axios.get(`${API_BASE_URL}/userData/${mycookie}`, {
      headers: {
        // 'Authorization': `Bearer ${userDetail_local.token}` 
      }
    });

    console.log(response);

    let user = response.data.user;
    currentUser.isLoggedIn = true;
    currentUser.userId = user.id;
    currentUser.userEmail = user.email;
    currentUser.userName = user.username;
    currentUser.profilePic = user.profilePic;
    currentUser.selectedTheme = user.theme;

    console.log(currentUser);
    // console.log(user);



  } catch (error) {
    console.error('Error fetching API:', error);
  }
};

onMounted(() => {
  if (!currentUser.userId) {
    callApi();
  }
});
</script>


<template>


  <Settings />
</template>
