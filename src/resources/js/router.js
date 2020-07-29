import Vue from 'vue';
import VueRouter from 'vue-router';
import Test from './pages/Test.vue';

Vue.use(VueRouter);

const routes = [
    {
        path:'/',
        component: Test
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;