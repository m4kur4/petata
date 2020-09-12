import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

import auth from "./common/auth";
import error from "./common/error";
import mode from "./common/mode";
import messageBox from "./common/message-box";

import binderCreate from "./form/binder-create";
import binderList from "./form/binder-list";
import binder from "./form/binder";
import labelAddDialog from "./form/label-add-dialog";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        auth,
        error,
        mode,
        messageBox,
        binderCreate,
        binderList,
        binder,
        labelAddDialog
    },
});

export default store;
