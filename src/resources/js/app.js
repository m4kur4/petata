import './bootstrap';

import Vue from 'vue';
import router from './router';
import store from './store';

import App from './App.vue';

const initialize = async () => {
    // ログイン状態の反映
    await store.dispatch('auth/getUserInfo');

    new Vue({
        el: '#app',
        router,
        store,
        components: { App },
        template: '<App />'
    });
};

initialize();