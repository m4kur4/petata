import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

import auth from "./common/auth";
import error from "./common/error";
import mode from "./common/mode";

import binderCreate from "./form/binder-create";
import binderList from "./form/binder-list";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        error,
        mode,
        binderCreate,
        binderList
    },
});

export default store;
