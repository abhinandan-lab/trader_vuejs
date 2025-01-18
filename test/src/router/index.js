import { createRouter, createWebHistory } from 'vue-router';
import AuthView from '@/views/AuthView.vue';
import HomeView from '@/views/HomeView.vue'; 

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'auth',
            component: AuthView,
        },
        {
            path: '/home',
            name: 'home',
            component: HomeView,
        },
    ],
});

export default router;
