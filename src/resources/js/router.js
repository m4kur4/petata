import Vue from 'vue';
import VueRouter from 'vue-router';

import Test from './pages/Test.vue';
import Binder from './pages/Binder.vue';

Vue.use(VueRouter);

const routes = [
    {
        path:'/test',
        component: Test
    },
    {
        path:'/',
        component: Binder
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;