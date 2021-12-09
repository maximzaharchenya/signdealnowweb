import Vue from 'vue'

//** common **//
Vue.component('lang-select', require('./../partial/lang/LangSelect').default);

// ** app ** //
Vue.component('app-content', require('./views/App').default);

// ** auth header ** //
Vue.component('auth-header', require('./views/auth/Header').default);

// ** partial ** //
Vue.component('support-form', require('./views/partial/forms/Support').default);
