import { reactive } from "vue";

// avaialbe on 
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



