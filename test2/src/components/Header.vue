<script setup>
import { onMounted, inject } from 'vue';

import { API_BASE_URL, getCookie } from '@/config/config';
const userDetail_local = inject('userDetail');

const themeData_local = inject('themeData');

const toggleTheme = () => {
  themeData_local.isDark = !themeData_local.isDark;
  document.body.setAttribute('data-theme', themeData_local.isDark ? 'dark' : 'light');
};

defineProps({
  welcome_msg: {
    type: String,
    default: "Welcome to trader's journal",
  }
});

onMounted(() => {
  document.body.setAttribute('data-theme', themeData_local.isDark ? 'dark' : 'light');
});
</script>

<template>
  <div class="full_width bg_card">
    <div class="top_header">
      <p>{{ welcome_msg }}</p>
      <div class="toggleUI">
        <div class="toggle-container">
          <input type="checkbox" id="toggle" class="toggle-checkbox" v-model="themeData_local.isDark"
            @click="toggleTheme" />
          <label for="toggle" class="toggle-label">
            <span class="toggle-circle">
              <i :class="themeData_local.isDark ? 'pi pi-moon' : 'pi pi-sun'"></i>
            </span>
          </label>
        </div>
      </div>
    </div>
  </div>



  {{ userDetail_local }}

  <div class="top_header ">

    <p> Welcome {{ userDetail_local.username }} </p>

    <button class="btn-primary">Add New trade</button>

    <div class="logged_user">

      <button class="btn-common">settings</button>

      <button class="btn-common">logout</button>

      <div class="profilepic">

        <img :src="API_BASE_URL + '/' + userDetail_local.profilePic || 'https://placehold.co/30'" alt="user profile">

      </div>

      <div class="themebox">

        <!-- dont delete the below empty span we need it to show border left -->

        <!-- <span></span> -->

        <!-- <span>icon</span> -->

        <div class="toggleUI">

          <div class="toggle-container">

            <input type="checkbox" id="toggle" class="toggle-checkbox" v-model="themeData_local.isDark"
              @click="toggleTheme" />

            <label for="toggle" class="toggle-label">

              <span class="toggle-circle">

                <i :class="themeData_local.isDark ? 'pi pi-moon' : 'pi pi-sun'"></i>

              </span>

            </label>

          </div>

        </div>

      </div>

    </div>

  </div>
</template>


<style scoped>
.icon {
  margin-right: 0.4rem;
}


.toggle-circle {
  color: black;
}

.profilepic {

img {

width: 100%;

/* height: 100; */

}

}
</style>