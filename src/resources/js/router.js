import Vue from 'vue';
import VueRouter from 'vue-router';

import Test from './pages/Test.vue';
import Binder from './pages/Binder.vue';
import Signup from './pages/Signup.vue';
import Signin from './pages/Signin.vue';

Vue.use(VueRouter);

const routes = [
    {
        path:'/test',
        component: Test
    },
    {
        path:'/',
        component: Binder
    },
    {
        path:'/signup',
        component: Signup
    },
    {
        path:'/signin',
        component: Signin
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;