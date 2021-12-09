import Vue from 'vue';
import {BFormFile, EmbedPlugin, CollapsePlugin, PopoverPlugin, BFormTextarea } from 'bootstrap-vue';
import {ModalPlugin} from 'bootstrap-vue';
import VueMask from 'v-mask'

const environment = document.head.querySelector('meta[name="environment"]');
if (environment && environment.content == 'local') window.localEnvironment = true;

Vue.use(VueMask);
Vue.component('b-form-file', BFormFile);
Vue.component('b-form-textarea', BFormTextarea);
Vue.use(ModalPlugin);
Vue.use(EmbedPlugin);
Vue.use(CollapsePlugin);
Vue.use(PopoverPlugin);

if (window.location.pathname != '/account/deals/create' && localStorage.getItem('external_deal'))
    window.location.href = '/account/deals/create';

require('./components');
require('./../app');


