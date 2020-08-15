import Vue from "vue";
import Vuex from "vuex";

import auth from "./auth";
import error from "./error";
import mode from "./mode";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        error,
        mode
    }
});

export default store;
