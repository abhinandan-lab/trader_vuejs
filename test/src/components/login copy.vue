<script setup>

import { ref } from 'vue';

const isPasswordVisible = ref(false);

const togglePasswordVisibility = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};
</script>


<template>

  <div class="full_width">




    <div class="register bg_card">

      <h1>Register</h1>





      <div class="form_div">

        <div class="form_control">
          <div class="profile_circle">
            <img src="https://placehold.co/150" alt="profile pic">

            <button class="edit btn-common"><i class="pi pi-pencil"></i></button>
          </div>
        </div>



        <div class="form_control">
          <label for="email">Email</label>
          <input type="email" placeholder="Enter your email" />
        </div>

        <div class="form_control">
          <label for="email">Password</label>
          <div class="password_flex">
            <input :type="isPasswordVisible ? 'text' : 'password'" placeholder="Enter your password" />

            <button @click.prevent="togglePasswordVisibility" class="btn-common"><i
                :class="isPasswordVisible ? 'pi pi-eye-slash' : 'pi pi-eye'"></i></button>
          </div>
        </div>

        <div class="form_control">
          <div class="submit_div">
            <button class="btn-primary">Login</button>
          </div>
        </div>

        <div class="form_control">
          <p class="text_center">don't have account. <a href="#">Register</a></p>
        </div>
      </div>

    </div>
  </div>
</template>




<style scoped>
.edit {
  border-radius: 50%;
  padding: 1rem;
  width: 2.4rem;
  height: 2.4rem;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>