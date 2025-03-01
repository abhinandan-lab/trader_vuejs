import { reactive } from "vue";

// avaialbe on every view
export const currentUser = reactive({
  isLoggedIn: false,
  userName: "",
  profilePic: "",
  activeStrategy: "",
  userId: "",
  userEmail: "",
  selectedTheme: '',
});


export const userSettings = reactive({

})



