<script setup>
import { ref, onBeforeMount } from 'vue';
import { API_BASE_URL } from '@/config/config';
import { getCookie } from '@/config/config';
import { useRouter } from 'vue-router';


// Reactive state for form data
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const isRegistering = ref(false); // Tracks whether it's login or register mode
const isPasswordVisible = ref(false);
const username = ref('');


const selectedFile = ref(null);
const previewImage = ref(null);
const fileInput = ref(null);


const validMessage = ref({ type: '', content: '' });
const router = useRouter();


// On page load, check if the session cookie exists
onBeforeMount(() => {
  const sessionCookie = getCookie('session');
  if (sessionCookie) {
    router.push('/home'); // Redirect to home if session exists
  }
});

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
  validMessage.value = { type: '', content: '' };
};

// Handle form submission
const handleSubmit = async () => {
  clearMessages();

  if (!email.value || !password.value) {
    validMessage.value = { type: 'error', content: 'Email and password are required!' };
    return;
  }

  if (isRegistering.value && password.value !== confirmPassword.value) {
    validMessage.value = { type: 'error', content: 'Passwords do not match!' };
    return;
  }

  const endpoint = isRegistering.value ? `${API_BASE_URL}/register` : `${API_BASE_URL}/login`;

  // Create a FormData object
  const formData = new FormData();
  formData.append('email', email.value);
  formData.append('password', password.value);
  if (isRegistering) {
    formData.append('username', username.value);
    if (selectedFile.value) {
      formData.append('profileImage', selectedFile.value);
    }
  }

  console.log(formData);

  try {
    const response = await fetch(endpoint, {
      method: 'POST',
      body: formData,
    });

    const result = await response.json();
    console.log(result);

    validMessage.value = { type: result.status, content: result.message };
    console.log('settiing coolke');
    console.log(!isRegistering);
    // console.log(!isRegistering && result.status === 'success')
    if (isRegistering && result.status === 'success') {

      document.cookie = `session=${result.session_token}; path=/`; // Set session cookie

    }




    if (!response.ok) throw new Error(result.message || 'Something went wrong!');

  } catch (err) {
    validMessage.value = { type: 'error', content: err.message };
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

  abcd@aa.com
  <div class="full_width">
    <div class="register bg_card">
      <h1>{{ isRegistering ? 'Register' : 'Login' }}</h1>

      <div class="form_div">

        <div class="right">
          <div class="form_control">
            <div class="profile_circle">
              <img :src="previewImage || 'https://placehold.co/150'" alt="profile pic">
              <input style="display: none;" id="profile-pic" type="file" accept="image/*" ref="fileInput"
                @change="handleFileChange" hidden />
              <button @click="triggerFileInput" v-if="isRegistering" class="edit btn-common"><i
                  class="pi pi-pencil"></i></button>
            </div>
          </div>
        </div>
        <div class="left">




          <div v-if="isRegistering" class="form_control">
            <label for="confirm-password">Username</label>
            <input v-model="username" type="text" placeholder="Enter a unique username" required />
          </div>

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
      <div v-if="validMessage" :class="validMessage.type">
        {{ validMessage.content }}
      </div>
    </div>
  </div>
</template>

<style scoped>
.error {
  color: red;
  text-align: center;
}

.success {
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
    aspect-ratio: 1;
    object-fit: contain;
  }

  button {

    position: absolute;
    right: 1.5rem;
    bottom: 0;

  }
}
</style>
