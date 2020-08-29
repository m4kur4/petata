import Vue from "vue";
import VueRouter from "vue-router";

import Test from "./pages/Test.vue";
import Binder from "./pages/Binder.vue";
import Signup from "./pages/Signup.vue";
import Signin from "./pages/Signin.vue";
import BinderList from "./pages/BinderList.vue";
import BinderCreate from "./pages/BinderCreate.vue";

import store from './store'

Vue.use(VueRouter);

const routes = [
    {
        path: "/test",
        component: Test
    },
    {
        path: "/binder/detail/:id",
        name: "binder",
        component: Binder,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                next();
            } else {
                next({ name: "signin" });
            }
        }
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                next({ name: "binder-list" });
            } else {
                next();
            }
        }
    },
    {
        path: "/signin",
        name: "signin",
        component: Signin,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                next({ name: "binder-list" });
            } else {
                next();
            }
        }
    },
    {
        path: "/binder/list",
        name: "binder-list",
        component: BinderList,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                next();
            } else {
                next({ name: "signin" });
            }
        }
    },
    {
        path: "/binder/create",
        name: "binder-create",
        component: BinderCreate,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                next();
            } else {
                next({ name: "signin" });
            }
        }
    }
];

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;
