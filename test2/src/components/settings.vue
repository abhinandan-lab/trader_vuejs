<script setup>
import { ref, inject, onMounted } from 'vue';
import { API_BASE_URL, getCookie } from '@/config/config';
import axios from 'axios';
import { currentUser } from '@/config/userStatus';


const email = ref(currentUser.userEmail);
const username = ref(currentUser.userName);
const previewImage = ref(`${API_BASE_URL}/${currentUser.profilePic}`);
const oldPassword = ref('');
const password = ref('');
const confirmPassword = ref('');
const isPasswordVisible = ref(false);
const errorMessage = ref('');
const successMessage = ref('');
const selectedFile = ref(null);
const fileInput = ref(null);


const myStrategies = ref([]);
const deleteOption = ref(false);

// Function to fetch user data if not already available
const callApi = async () => {
  try {
    let mycookie = getCookie('session');
    const response = await axios.get(`${API_BASE_URL}/userData/${mycookie}`);

    const user = response.data.user;
    currentUser.profilePic = user.profilePic;
    currentUser.userName = user.username;
    currentUser.userId = user.id;
    currentUser.userEmail = user.email


    email.value = user.email;
    username.value = user.username;
    previewImage.value = `${API_BASE_URL}/${user.profilePic}`;
  } catch (error) {
    console.error('Error fetching API:', error);
  }
};

// Ensure API is called only if user data is not already available
onMounted(() => {
  if (!currentUser.userId ) {
    callApi();
  }
});

// Toggle password visibility
const togglePasswordVisibility = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

// Clear messages
const clearMessages = () => {
  errorMessage.value = '';
  successMessage.value = '';
};

// Handle form submission
const handleSubmit = async () => {
  clearMessages();
  if (password.value !== confirmPassword.value) {
    errorMessage.value = "Passwords do not match!";
    return;
  }

  try {
    const formData = new FormData();
    formData.append('email', email.value);
    formData.append('username', username.value);
    formData.append('oldPassword', oldPassword.value);
    formData.append('password', password.value);
    if (selectedFile.value) {
      formData.append('profilePic', selectedFile.value);
    }

    const response = await axios.put(`${API_BASE_URL}/updateUser`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });

    // userDetail_local.email = response.data.email;
    // userDetail_local.username = response.data.username;
    // userDetail_local.profilePic = response.data.profilePic;

    successMessage.value = "Settings updated successfully!";
  } catch (error) {
    errorMessage.value = "Error updating settings!";
    console.error('Error updating API:', error);
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
      <h1> <span>Settings</span> <button class="btn-common">Save</button></h1>

      <div class="form_div">

        <div class="right">

          <div class="form_control prof_div">
            <div class="profile_circle">
              <img :src="previewImage || 'https://placehold.co/150'" alt="profile pic">
              <input style="display: none;" id="profile-pic" type="file" accept="image/*" ref="fileInput"
                @change="handleFileChange" hidden />
              <button @click="triggerFileInput" class="edit btn-common"><i class="pi pi-pencil"></i></button>
            </div>
          </div>

          <div class="form_control">
            <label for="email"><small> Email </small> </label>
            <input disabled v-model="email" type="email" placeholder="Enter your email" />
          </div>


          <div class="form_control">
            <label for="text"><small> Username </small> </label>
            <input v-model="username" type="text" placeholder="Enter your username" />
          </div>

          <div class="form_control">
            <label for="old_pass"><small> Old Password </small> </label>
            <input type="email" placeholder="Enter your email" required />
          </div>

          <div class="form_control">
            <label for="new_pass"><small> New Password </small></label>
            <div class="password_flex">
              <input v-model="password" :type="isPasswordVisible ? 'text' : 'password'"
                placeholder="Enter your password" required />
              <button @click.prevent="togglePasswordVisibility" class="btn-common">
                <i :class="isPasswordVisible ? 'pi pi-eye-slash' : 'pi pi-eye'"></i>
              </button>
            </div>
          </div>









        </div>
        <div class="left">

          <h2>Strategies</h2>


          <div v-if="myStrategies.length === 0" class="empty_strategy">
            <div class="iconbox">
              <i class="pi pi-exclamation-circle" style="font-size: 2rem; font-weight: 100;"></i>
              <span class="text_light"> No Strategies created</span>
            </div>
            <!-- <p class="text_light"> <small><i class="pi pi-plus" ></i> Add new Strategy </small> </p> -->
          </div>


          <div class="strategy_list">
            <div class="item ">
              <p class="name">my strategy name</p>
              <button class="btn-common"> <i class="pi pi-trash"></i> </button>
            </div>


          </div>

          <div v-if="deleteOption" class="confirm_delete">
            <p>Confirm Delete</p>
            <span>random text 6 charchter</span>
            <div class="form_control">
              <div class="password_flex">
                <input type="text" placeholder="Enter above code" required />
                <button class="btn-common">
                  Confirm
                </button>
              </div>
            </div>
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

<style scoped>
.confirm_delete {
  border: 1px solid rgb(230, 161, 0);
  margin-top: 0.4rem;
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
  border-radius: 4px;
  padding: 0.8rem;

  span {
    /* font-family: 'Courier New', Courier, monospace; */
    /* font-weight: bold; */
    color: #007bff;
    font-size: 1.1rem;
  }

}


.strategy_list {
  /* border: 1px solid black; */
  display: flex;
  gap: 0.6rem;
  flex-direction: column;

  .item {
    border: 1px solid var(--divider-color);
    border-radius: 4px;
    padding: 0.4rem 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;


    button {
      padding: 0.2rem;
      /* background-color: transparent; */
      color: #dc3545;

    }
  }

  .item:hover {
    border: 1px solid #007bff;

    p {
      color: #007bff;
    }
  }
}


.form_control {
  margin-top: 0.6rem;
}

.prof_div {
  margin-top: 1rem;
}

.empty_strategy {
  /* border: 1px solid black; */
  padding: 2rem;
  font-family: "Quicksand", serif;


  .iconbox {
    gap: 0.6rem;
    justify-content: center;
    display: flex;
    align-items: center;
  }

  /* i {

    color: var(--text-color-light);
  } */
}


/* // <uniquifier>: Use a unique and descriptive class name */
/* // <weight>: Use a value from 300 to 700 */

/* .quicksand-<uniquifier> {
  font-family: "Quicksand", serif;
  font-optical-sizing: auto;
  font-weight: <weight>;
  font-style: normal;
} */


h1 {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.4rem;
}


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

  >div {
    flex: 1;
  }

  .right {
    /* width: 35%; */
    /* background-color: red; */
    /* border: 1px solid black; */
  }


  .left {
    flex-grow: 1;
    /* border: 1px solid black; */
    padding-top: 1rem;

    h2 {
      font-weight: normal;
      margin-bottom: 0.6rem;
    }
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
  max-width: 850px;
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
    max-width: 150px;
    aspect-ratio: 1;
    object-fit: cover;
  }

  button {

    position: absolute;
    right: 6.9rem;
    bottom: 0;

  }
}

.add_btn {
  display: inline-block;
  margin: 1rem auto;
  text-align: center;
  padding: 0.4rem 0.6rem;
  cursor: pointer;
  border-radius: 4px;
}
</style>
