import Vue from 'vue'

//** common **//
Vue.component('lang-select', require('./../partial/lang/LangSelect').default);

// ** app ** //
Vue.component('account-content', require('./views/App').default);

Vue.component('account-sidebar', require('./views/partial/Sidebar').default);
Vue.component('account-header', require('./views/partial/Header').default);

Vue.component('add-user', require('./views/partial/modal/AddUser').default);
Vue.component('add-notary', require('./views/partial/modal/AddNotary').default);

/*deal*/
Vue.component('deal-show-details', require('./views/deals/partial/DealShowDetails').default);
Vue.component('timing-show', require('./views/deals/partial/Timing').default);

/*documents*/
Vue.component('client-data', require('./views/documents/ClientData').default);
Vue.component('seller-data', require('./views/documents/SellerData').default);
Vue.component('property-data', require('./views/documents/PropertyData').default);
Vue.component('note-data', require('./views/documents/NoteData').default);
Vue.component('seller-legal-data', require('./views/documents/SellerLegalData').default);
Vue.component('client-legal-data', require('./views/documents/ClientLegalData').default);
Vue.component('user-data', require('./views/documents/UserData').default);
Vue.component('user-common-data', require('./views/documents/partial/UserCommonData').default);
Vue.component('mortgage-common-data', require('./views/documents/partial/MortgageCommonData').default);
Vue.component('mortgage-show-data', require('./views/documents/partial/MortgageShowData').default);
Vue.component('holder-show-data', require('./views/documents/partial/HolderShowData').default);
Vue.component('contributors-data', require('./views/documents/partial/ContributorsShowData').default);

/*chat*/
Vue.component('chat-index', require('./views/chat/Index').default);
