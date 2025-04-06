import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import Login from '../pages/LoginPage.vue';
import Clients from '../pages/Clients.vue';
import Home from '../pages/HomePage.vue';
import Reports from '../pages/Reports.vue';


const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/home',
    name: 'Home',
    component: Home,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/clients',
    name: 'Clients',
    component: Clients, 
  },
  {
    path: '/reports',
    name: 'Report',
    component: Reports, 
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

export default router;
