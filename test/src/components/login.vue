<template>
    <div class="auth-container">
      <div class="form-wrapper">
        <h2>{{ isLogin ? "Login" : "Register" }}</h2>
        
        <!-- Profile Picture Section -->
        <div v-if="!isLogin" class="profile-picture-section">
          <!-- Circle Profile Picture with Pencil Icon (only for registration) -->
          <div class="profile-picture-container">
            <img
              v-if="formData.profilePicture"
              :src="formData.profilePicture"
              alt="Profile Picture"
              class="profile-picture"
            />
            <img
              v-else
              src="https://via.placeholder.com/150"
              alt="Placeholder Profile Picture"
              class="profile-picture"
            />
            <div v-if="!formData.profilePicture" class="pencil-icon" @click="triggerFileInput">
              &#9998;
            </div>
          </div>
          <input
            ref="fileInput"
            type="file"
            id="profilePicture"
            @change="handleProfilePictureChange"
            accept="image/*"
            style="display: none;"
          />
        </div>
  
        <!-- Login / Register Form -->
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" v-model="formData.email" id="email" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              v-model="formData.password"
              id="password"
              required
            />
          </div>
          <div v-if="!isLogin" class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input
              type="password"
              v-model="formData.confirmPassword"
              id="confirmPassword"
              required
            />
          </div>
          <button type="submit">{{ isLogin ? "Login" : "Register" }}</button>
        </form>
  
        <!-- Toggle Link -->
        <p @click="toggleForm" class="toggle-link">
          {{ isLogin
            ? "Don't have an account? Register here."
            : "Already have an account? Login here." }}
        </p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { reactive, ref } from "vue";
  
  const isLogin = ref(true);
  
  const formData = reactive({
    email: "",
    password: "",
    confirmPassword: "",
    profilePicture: null, // Store profile picture here
  });
  
  const toggleForm = () => {
    isLogin.value = !isLogin.value;
    // Reset the form data when switching
    formData.email = "";
    formData.password = "";
    formData.confirmPassword = "";
    formData.profilePicture = null; // Reset profile picture
  };
  
  const handleSubmit = () => {
    if (!isLogin.value && formData.password !== formData.confirmPassword) {
      alert("Passwords do not match!");
      return;
    }
    alert(`${isLogin.value ? "Logged in" : "Registered"} successfully!`);
    // Add logic for API calls here
  };
  
  // Handle profile picture change
  const handleProfilePictureChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        formData.profilePicture = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  };
  
  // Trigger file input when pencil icon is clicked
  const triggerFileInput = () => {
    const fileInput = ref("fileInput");
    fileInput.value.click();
  };
  </script>
  
  <style scoped>
  .auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f3f3f3;
  }
  
  .form-wrapper {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
  }
  
  .form-group {
    margin-bottom: 15px;
    text-align: left;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }
  
  input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
  }
  
  button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }
  
  button:hover {
    background-color: #0056b3;
  }
  
  .toggle-link {
    margin-top: 10px;
    cursor: pointer;
    color: #007bff;
    text-decoration: underline;
  }
  
  .toggle-link:hover {
    color: #0056b3;
  }
  
  .profile-picture-section {
    margin-bottom: 15px;
  }
  
  .profile-picture-container {
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #ccc;
  }
  
  .profile-picture {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .pencil-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 5px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
  }
  
  .pencil-icon:hover {
    background-color: rgba(0, 0, 0, 0.7);
  }
  </style>
  