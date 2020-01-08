import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    meta: {title: 'Home'},
    component: () => import('../views/Home.vue')
  },
  {
    path: '/login',
    name: 'login',
    meta: {title: 'Login'},
    component: () => import('../views/Login.vue')
  },
  {
    path: '/restore',
    name: 'restore',
    meta: {title: 'Restore'},
    component: () => import('../views/Restore.vue')
  },
  {
    path: '/register',
    name: 'register',
    meta: {title: 'Register'},
    component: () => import('../views/Register.vue')
  },
  {
    path: '/update',
    name: 'update',
    meta: {title: 'Update'},
    component: () => import('../views/Update.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
