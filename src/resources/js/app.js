import './bootstrap';

import Vue from 'vue';
import router from './router';
import store from './store';
import VueLazyLoad from 'vue-lazyload'
import VTooltip from 'v-tooltip'

import App from './App.vue';

const initialize = async () => {
    // ログイン状態の反映
    await store.dispatch('auth/getUserInfo');

    Vue.use(VTooltip);
    Vue.use(VueLazyLoad, {
        loading: "./images/gif/Preloader_2.gif",
    });

    new Vue({
        el: '#app',
        router,
        store,
        components: { App },
        template: '<App />'
    });
};

initialize();