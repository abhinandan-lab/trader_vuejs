<script setup>
import Settings from '@/components/settings.vue';
import { API_BASE_URL, getCookie } from '@/config/config';
import axios from 'axios';
import { inject, onMounted } from 'vue';

const userDetail_local = inject('userDetail');

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
    userDetail_local.profilePic = user.profilePic;
    userDetail_local.username = user.username;
    userDetail_local.id = user.id;
    userDetail_local.email = user.email;
  } catch (error) {
    console.error('Error fetching API:', error);
  }
};

onMounted(() => {
  if(!userDetail_local.id) {
    callApi();
  }
});
</script>


<template>

  <!-- {{ userDetail_local }} -->
  <Settings />
</template>
