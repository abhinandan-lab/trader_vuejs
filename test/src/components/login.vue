<script setup>
import { ref } from 'vue';

// Reactive state for form data
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const isRegistering = ref(false); // Tracks whether it's login or register mode
const isPasswordVisible = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

const selectedFile = ref(null);
const previewImage = ref(null);
const fileInput = ref(null);

// Toggle password visibility
const togglePasswordVisibility = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

// Toggle between login and register forms
const toggleForm = () => {
  isRegistering.value = !isRegistering.value;
  clearMessages();
};

// Clear messages
const clearMessages = () => {
  errorMessage.value = '';
  successMessage.value = '';
};

// Handle form submission
const handleSubmit = async () => {
  clearMessages();

  if (!email.value || !password.value) {
    errorMessage.value = 'Email and password are required!';
    return;
  }

  if (isRegistering.value && password.value !== confirmPassword.value) {
    errorMessage.value = 'Passwords do not match!';
    return;
  }

  const endpoint = isRegistering.value ? '/api/register' : '/api/login';

  try {
    const response = await fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email.value, password: password.value }),
    });

    const result = await response.json();
    if (!response.ok) throw new Error(result.message || 'Something went wrong!');

    successMessage.value = isRegistering.value
      ? 'Registration successful! You can now log in.'
      : 'Login successful!';
  } catch (err) {
    errorMessage.value = err.message;
  }
};



// Trigger file input click
const triggerFileInput = () => {
  fileInput.value.click();
};

// Handle file selection
const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedFile.value = file;

    // Create a preview URL for the selected file
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};
</script>

<template>
  <div class="full_width">
    <div class="register bg_card">
      <h1>{{ isRegistering ? 'Register' : 'Login' }}</h1>

      <div class="form_div">

        <div class="right">
          <div class="form_control">
            <div class="profile_circle">
              <img  :src="previewImage || 'https://placehold.co/150'"  alt="profile pic">
              <input style="display: none;" id="profile-pic" type="file" accept="image/*" ref="fileInput" @change="handleFileChange" hidden />
              <button @click="triggerFileInput" v-if="isRegistering" class="edit btn-common"><i class="pi pi-pencil"></i></button>
            </div>
          </div>
        </div>
        <div class="left">


          <div class="form_control">
            <label for="email">Email</label>
            <input v-model="email" type="email" placeholder="Enter your email" required />
          </div>

          <div class="form_control">
            <label for="password">Password</label>
            <div class="password_flex">
              <input v-model="password" :type="isPasswordVisible ? 'text' : 'password'"
                placeholder="Enter your password" required />
              <button @click.prevent="togglePasswordVisibility" class="btn-common">
                <i :class="isPasswordVisible ? 'pi pi-eye-slash' : 'pi pi-eye'"></i>
              </button>
            </div>
          </div>

          <div v-if="isRegistering" class="form_control">
            <label for="confirm-password">Confirm Password</label>
            <div class="password_flex">
              <input v-model="confirmPassword" :type="isPasswordVisible ? 'text' : 'password'"
                placeholder="Confirm your password" required />
            </div>
          </div>

          <div class="form_control">
            <div class="submit_div">
              <button @click="handleSubmit" class="btn-primary">
                {{ isRegistering ? 'Register' : 'Login' }}
              </button>
            </div>
          </div>

          <div class="form_control">
            <p class="">
              {{ isRegistering
                ? 'Already have an account?'
                : "Don't have an account?" }}
              <a href="#" @click.prevent="toggleForm">
                {{ isRegistering ? 'Login' : 'Register' }}
              </a>
            </p>
          </div>
        </div>

      </div>

      <!-- Display messages -->
      <div v-if="errorMessage" class="error_message">
        {{ errorMessage }}
      </div>
      <div v-if="successMessage" class="success_message">
        {{ successMessage }}
      </div>
    </div>
  </div>
</template>

<style>
.error_message {
  color: red;
  text-align: center;
}

.success_message {
  color: green;
  text-align: center;
}

.edit {
  border-radius: 50%;
  padding: 1rem;
  width: 2.4rem;
  height: 2.4rem;
  display: flex;
  justify-content: center;
  align-items: center;
}

.form_div {
  display: flex;
  gap: 2.6rem;

  .right {
    width: 35%;
    /* background-color: red; */
  }


  .left {
    flex-grow: 1;
  }
}


.submit_div {
  display: flex;
  /* justify-content: center; */
  /* align-items: center; */


  .btn-primary {
    padding-left: 2rem;
    padding-right: 2rem;
  }
}

.register {
  margin: auto;
  padding: 2rem;
  max-width: 700px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  padding-top: 2rem;
  padding-bottom: 2rem;
  border-radius: 10px;
  margin-top: 2rem;


  h1 {
    text-align: center;
    color: var(--text-color);
  }

}



.profile_circle {
  display: flex;
  align-items: center;
  justify-content: center;
  /* width: fit-content; */
  margin: auto;

  position: relative;

  img {
    border-radius: 50%;
    width: 85%;
  }

  button {

    position: absolute;
    right: 1.5rem;
    bottom: 0;

  }
}
</style>
