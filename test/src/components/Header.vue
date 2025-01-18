<script setup>
import { onMounted } from 'vue';
import { inject } from 'vue';

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
</template>


<style scoped>
.icon {
  margin-right: 0.4rem;
}


.toggle-circle {
  color: black;
}
</style>