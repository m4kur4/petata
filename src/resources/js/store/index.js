import Vue from "vue";
import Vuex from "vuex";

import auth from "./common/auth";
import error from "./common/error";
import mode from "./common/mode";

import binderCreate from "./form/binder-create";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        error,
        mode,
        binderCreate
    }
});

export default store;
