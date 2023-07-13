import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './style.css'
import About from './views/About.vue'
import Home from './views/Home.vue'
import App from './App.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/', name:'Home', component: Home},
        {path: '/about', name:'About', component: About},
        {path: '/login', name:'Login', component: Login},
        {path: '/register', name:'Register', component: Register},
    ]
})



createApp(App).use(router).mount('#app')
