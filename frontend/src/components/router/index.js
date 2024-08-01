import { createRouter, createWebHistory } from 'vue-router'
import Home from '../screens/Home.vue'
import Login from '../screens/Login.vue'
import Register from '../screens/Register.vue'
import AddCar from '../screens/AddCar.vue'
import RentCar from '../screens/RentCar.vue'
import EndRentCar from '../screens/EndRentCar.vue'

const isAuthenticated = () => {
    return !!localStorage.getItem('dataUser');
}

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: { requiresAuth: true } // Add meta field for routes that require authentication
    },
    {
        path: '/add-car',
        name: 'addCar',
        component: AddCar,
        meta: { requiresAuth: true } // Add meta field for routes that require authentication
    },
    {
        path: '/rent-car/:id', // Route dengan parameter ID mobil
        name: 'rent-car',
        component: RentCar,
        props: true // Mengirim parameter sebagai props
    },
    {
        path: '/end-rent-car/:id', // Route dengan parameter ID mobil
        name: 'end-rent-car',
        component: EndRentCar,
        props: true // Mengirim parameter sebagai props
    },

]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

// Global navigation guard
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !isAuthenticated()) {
        // Redirect to login if not authenticated
        next({ name: 'login' });
    } else {
        next(); // Proceed to the route
    }
});

export default router
