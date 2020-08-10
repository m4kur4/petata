import Vue from 'vue';
import VueRouter from 'vue-router';

import Test from './pages/Test.vue';
import Main from './pages/Main.vue';

Vue.use(VueRouter);

const routes = [
    {
        path:'/test',
        component: Test
    },
    {
        path:'/',
        component: Main
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;