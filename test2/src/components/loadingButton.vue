<script setup>
import { uiStatus } from '@/config/userStatus';

const props = defineProps({
       buttonText: {
              type: String,
              required: true
       }
});



</script>



<template>
       <span>{{ buttonText }}  <span class="spinner_span" v-if="uiStatus.showloading"><i class="pi pi-spin pi-spinner"></i></span></span>
</template>

<style scoped>

.spinner_span {
       font-size: 0.86rem;
       /* margin-left: 0.2rem; */
}

</style>