<script setup>
import Settings from '@/components/settings.vue';
import { API_BASE_URL, getCookie } from '@/config/config';
import axios from 'axios';
import { inject, onMounted } from 'vue';
import { currentUser } from '@/config/userStatus';
// const userDetail_local = inject('userDetail');

const callApi = async () => {
  try {
    let mycookie = getCookie('session');
    const response = await axios.get(`${API_BASE_URL}/userData/${mycookie}`, {
      headers: {
        // 'Authorization': `Bearer ${userDetail_local.token}` 
      }
    });

    // console.log(response);

    let user = response.data.user;
    // userDetail_local.profilePic = user.profilePic;
    // userDetail_local.username = user.username;
    // userDetail_local.id = user.id;
    // userDetail_local.email = user.email;


    currentUser.isLoggedIn = true;
    currentUser.userId = user.id;
    currentUser.userEmail = user.email;
    currentUser.userName = user.username;
    currentUser.profilePic = user.profilePic;
    currentUser.selectedTheme = user.theme;

    console.log(currentUser);
    console.log(user);



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

  <!-- {{ userDetail_local }} -->
  <Settings />
</template>
