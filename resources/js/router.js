import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new  VueRouter({
    mode: "history",
    routes: [

        { path: '/', name: 'Home',  component: () => import('./views/Home.vue') },
        { path: '/login', name: 'Login',  component: () => import('./views/Login.vue') },
        { path: '/verify-email',  name: 'Verify',  component: () => import('./views/Verify.vue') },
        { path: '/forget-password', name: 'ForgetPassword', component: () => import('./views/ForgetPassword.vue')  },
        { path: '/profile/:id',  name: 'Profile', component: () => import('./views/backend/Profile.vue') },
        { path: '/register',  name: 'Register',  component: () => import('./views/Register.vue')  },
        { path: '/categories',  name: 'Categories', component: () => import('./views/backend/pages/Categories.vue')  },
        { path: '/services', name: 'Services', component: () => import('./views/backend/pages/Services.vue') },
        { path: '/agents', name: 'Agents',  component: () => import('./views/backend/pages/Agents.vue')  },
        { path: '/hospitals', name: 'Hospitals', component: () => import('./views/backend/pages/Hospitals.vue')  },
        { path: '/appointments', name: 'Appointments', component: () => import('./views/backend/pages/Appointments.vue') },
        { path: '/plans', name: 'Plans', component: () => import('./views/backend/pages/Plans.vue') },
        { path: '/feedbacks', name: 'Feedbacks', component: () => import('./views/backend/pages/Feedbacks.vue') },
        { path: '/give-feedbacks', name: 'GiveFeedback', component: () => import('./views/backend/pages/GiveFeedback.vue') },
        { path: '/administer-treatment', name: 'AdministerTreatment', component: () => import('./views/backend/pages/AdministerTreatment.vue') },
        { path: '/treatments', name: 'Treatments', component: () => import('./views/backend/pages/Treatments.vue') },
        { path: '/get-refers', name: 'Refers', component: () => import('./views/backend/pages/Refers.vue') },
        { path: '/claims',  name: 'Claims', component: () => import('./views/backend/pages/Claims.vue')  },
        { path: '/dashboard',  name: 'Dashboard', component: () => import('./views/backend/Dashboard.vue') },
        { path: '/settings', name: 'Settings', component: () => import('./views/backend/Settings.vue') },
        { path: '/:pathMatch(.*)*', name: 'Notfound', component: () => import('./views/Notfound.vue') }
    ]
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/','/verify-email', '/login', '/forget-password', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');

    if (authRequired && !loggedIn) {
        return next('/');
    }else {
        next();
    }
});

export default router;

