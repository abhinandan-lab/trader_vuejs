import { reactive } from "vue";
import { API_BASE_URL} from '@/config/config';

// avaialbe on every view
export const currentUser = reactive({
  isLoggedIn: false,
  userName: "",
  profilePic: "",
  activeStrategy: "",
  userId: "",
  userEmail: "",
  selectedTheme: '',

  getProfilePicUrl() {
    // Note: Using a regular function so that `this` correctly refers to currentUser.

    console.log(this.profilePic)

    if(this.profilePic == null){
      return 'https://placehold.co/30';
    }else {
      return `${API_BASE_URL}/${this.profilePic}`
    }


    // return this.profilePic 
    //   ? `${API_BASE_URL}/${this.profilePic}` 
    //   : 'https://placehold.co/30';
  },
});


export const userSettings = reactive({

})


export const uiStatus = reactive({
  showloading: false,
  loadingMessage: '',
  btnText: '',

})



