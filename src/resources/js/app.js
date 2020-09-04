import './bootstrap';

import Vue from 'vue';
import router from './router';
import store from './store';
import VueLazyLoad from 'vue-lazyload'

import App from './App.vue';

const initialize = async () => {
    // ログイン状態の反映
    await store.dispatch('auth/getUserInfo');

    Vue.use(VueLazyLoad);

    new Vue({
        el: '#app',
        router,
        store,
        components: { App },
        template: '<App />'
    });
};

initialize();