require('./bootstrap');
require('./services/server_responses');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import store from './store';
import { BSpinner } from 'bootstrap-vue';
import Vuelidate from 'vuelidate';

window.EventHandler = new Vue();

Vue.use(VueRouter, Vuex);
Vue.component('b-spinner', BSpinner);
Vue.use(Vuelidate);

if(localStorage.getItem('token')) {
    const token = localStorage.getItem('token').replace(/(\r\n|\n|\r)/gm, "");
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    window.Echo.connector.options.auth.headers['Authorization'] = 'Bearer ' + token;
}

require('./pages/components');

import router from './routes.js';

new Vue({
    router, store,

    created() {
        this.$store.dispatch('fetchUser');
    }

}).$mount('#app');

