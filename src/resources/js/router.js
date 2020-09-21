import Vue from "vue";
import VueRouter from "vue-router";

import Test from "./pages/Test.vue";
import Binder from "./pages/Binder.vue";
import Signup from "./pages/Signup.vue";
import Signin from "./pages/Signin.vue";
import BinderList from "./pages/BinderList.vue";
import BinderCreate from "./pages/BinderCreate.vue";
import PasswordReset from "./pages/PasswordReset.vue";

import store from "./store";
import { TRANSITION_TYPE } from "./const";

Vue.use(VueRouter);

const routes = [
    {
        path: "/test",
        component: Test
    },
    {
        // バインダー詳細
        path: "/binder/detail/:id",
        name: "binder",
        component: Binder,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                store.commit("error/setCode", null);
                store.commit("mode/setTransitionType", TRANSITION_TYPE.PAGE_IN);
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
    },
    {
        // サインアップ
        path: "/signup",
        name: "signup",
        component: Signup,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                // ログイン済みの場合はバインダー一覧へリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "binder-list" });
            } else {
                // エラー情報をクリア
                store.dispatch("error/clearMessages");
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next();
            }
        }
    },
    {
        // サインイン
        path: "/signin",
        name: "signin",
        component: Signin,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                // ログイン済みの場合はバインダー一覧へリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "binder-list" });
            } else {
                // エラー情報をクリア
                store.dispatch("error/clearMessages");
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next();
            }
        }
    },
    {
        // バインダー一覧
        path: "/binder/list",
        name: "binder-list",
        component: BinderList,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.PAGE_OUT
                );
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
    },
    {
        // バインダー作成
        path: "/binder/create",
        name: "binder-create",
        component: BinderCreate,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                // エラー情報をクリア
                store.commit("error/setCode", null);
                store.dispatch("error/clearMessages");
                
                store.commit("mode/setTransitionType", TRANSITION_TYPE.PAGE_IN);
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
    },
    {
        // バインダー編集(バインダー作成と同じ画面)
        path: "/binder/edit",
        name: "binder-edit",
        component: BinderCreate,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                // エラー情報をクリア
                store.dispatch("error/clearMessages");
                store.commit("mode/setTransitionType", TRANSITION_TYPE.PAGE_IN);
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
    },
    {
        // パスワードリセット
        path: "/user/auth/password/reset",
        name: "password-reset",
        component: PasswordReset,
    },
    {
        // URLがマッチングしない場合(バインダー一覧へリダイレクト)
        path: "/*",
        name: "not-found",
        component: BinderList,
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.PAGE_OUT
                );
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
    },
];

const router = new VueRouter({
    mode: "history",
    routes
});

export default router;
