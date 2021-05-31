import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login.vue'
import Register from './components/Register.vue'
import Home from './components/Home.vue'
import Admin from './components/Admin.vue'
import Artist from './components/admin/Artist.vue'
import Album from './components/admin/Album.vue'
import Song from './components/admin/Song.vue'

Vue.use(VueRouter)

const routes = [
    {
      path: '/',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/home',
      name: 'Home',
      component: Home
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin
    },
    {
      path: '/admin-artist',
      name: 'Artist',
      component: Artist
    },
    {
      path: '/admin-album',
      name: 'Album',
      component: Album
    },
    {
      path: '/admin-song',
      name: 'Song',
      component: Song
    },
];

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router