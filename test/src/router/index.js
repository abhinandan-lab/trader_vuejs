import { createRouter, createWebHistory } from 'vue-router';
import AuthView from '@/views/AuthView.vue';
import HomeView from '@/views/HomeView.vue';

// Utility function to check authentication
const isAuthenticated = () => {
  console.log(document.cookie.includes('session'), ': isAuthenticated');
  return document.cookie.includes('session') || localStorage.getItem('session');
};

const routes = [
  {
    path: '/',
    name: 'auth',
    component: AuthView,
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView,
    meta: { requiresAuth: true }, // Add meta field to specify authentication requirement
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  // history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !isAuthenticated()) {
    next({ name: 'auth' });
  } else {
    next();
  }
});

export default router;
