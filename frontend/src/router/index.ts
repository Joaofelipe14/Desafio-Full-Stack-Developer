import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';

import ClientsPage from '../pages/ClientsPage.vue';
import ReportsPage from '../pages/ReportsPage.vue';
import LoginPage from '../pages/LoginPage.vue';
import HomePage from '../pages/HomePage.vue';
import AuthService from '../services/authService';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'Home',
    component: HomePage,
  },
  {
    path: '/home',
    name: 'Home',
    component: HomePage,
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginPage,
  },
  {
    path: '/clients',
    name: 'Clients',
    component: ClientsPage, 
    meta: { requiresAuth: true },  
  },
  {
    path: '/reports',
    name: 'Report',
    component: ReportsPage, 
    meta: { requiresAuth: true },  
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'Home',
    component: HomePage,
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
