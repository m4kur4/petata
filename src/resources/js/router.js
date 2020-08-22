import Vue from "vue";
import VueRouter from "vue-router";

import Test from "./pages/Test.vue";
import Binder from "./pages/Binder.vue";
import Signup from "./pages/Signup.vue";
import Signin from "./pages/Signin.vue";
import BinderList from "./pages/BinderList.vue";
import BinderCreate from "./pages/BinderCreate.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/test",
        component: Test
    },
    {
        path: "/",
        component: Binder
    },
    {
        path: "/signup",
        component: Signup
    },
    {
        path: "/signin",
        component: Signin
    },
    {
        path: "/binder/list",
        component: BinderList
    },
    {
        path: "/binder/create",
        component: BinderCreate
    }
];

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;
