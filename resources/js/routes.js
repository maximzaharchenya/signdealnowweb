import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    scrollBehavior(to, from, savedPosition) {
        return {x: 0, y: 0}
    },
    routes: [

        /* DEFAULT */
        {
            path: '/',
            component: require('./pages/views/Index').default,
            name: 'page-index',
        },
        {
            path: '/register',
            component: require('./pages/views/auth/Register').default,
            name: 'register',
        },
        {
            path: '/login',
            component: require('./pages/views/auth/Login').default,
            name: 'login',
        },
        {
            path: '/restore',
            component: require('./pages/views/auth/Reset').default,
            name: 'restore',
        },
        {
            path: '/reset',
            component: require('./pages/views/auth/ResetAddNewPass').default,
            name: 'reset',
        },
        {
            path: '/email/check',
            component: require('./pages/views/auth/EmailCheck').default,
            name: 'email-check',
        },
        {
            path: '/authentication',
            component: require('./pages/views/auth/Authentication').default,
            name: 'authentication',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/support',
            component: require('./pages/views/support/Index').default,
            name: 'support',
        },

        /* External Deal */
        {
            path: '/api/external_deal',
            component: require('./pages/views/ExternalDeal').default,
            name: 'external_deal',
        },

        /* ACCOUNT */
        {
            path: '/account',
            component: require('./account/views/Index').default,
            name: 'account',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/account/edit',
            component: require('./account/views/profile/Edit').default,
            name: 'account-edit',
            meta: {
                requiresAuth: true
            },
        },

        /* deals */
        {
            path: '/account/deals',
            component: require('./account/views/deals/Index').default,
            name: 'account-deals',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/account/deal/:id/notary/register',
            component: require('./account/views/deals/partial/JoinNotaryFromEmail').default,
            name: 'account-deal-notary-register',
        },
        {
            path: '/account/deal/:id/register',
            component: require('./account/views/deals/partial/JoinFromEmail').default,
            name: 'account-deal-register',
        },

        {
            path: '/account/deals/create',
            component: require('./account/views/deals/Create').default,
            name: 'account-deal-create',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/account/deals/:id/show',
            component: require('./account/views/deals/Show').default,
            name: 'account-deals-show',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/account/deals/:id/video',
            component: require('./account/views/deals/Video').default,
            name: 'account-deals-video',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/account/deals/:id/signing',
            component: require('./account/views/deals/signing/Index').default,
            name: 'account-deals-signing',
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/account/deals/:id/create-data',
            component: require('./account/views/documents/Create').default,
            name: 'account-deals-create-data',
            meta: {
                requiresAuth: true
            },
        },

        {
            path: '/account/deals/:id/invite-notary',
            component: require('./account/views/notaries/Index').default,
            name: 'account-deals-invite-notary',
            meta: {
                requiresAuth: true
            },
        },

        {
            path: '/account/deals/:id/data-approval',
            component: require('./account/views/deals/approval/DataApproval').default,
            name: 'account-deals-data-approval',
            meta: {
                requiresAuth: true
            },
        },

        {
            path: '/account/deals/:id/payment',
            component: require('./account/views/deals/approval/PaymentDuty').default,
            name: 'account-deals-payment',
            meta: {
                requiresAuth: true
            },
        },

        {
            path: '/account/instructions',
            component: require('./account/views/instructions/Index').default,
            name: 'account-instructions',
            meta: {
                requiresAuth: true
            },
        },

        {
            path: '/account/support',
            component: require('./account/views/support/Index').default,
            name: 'account-support',
            meta: {
                requiresAuth: true
            },
        },





        /*404*/
        // {
        //     path: "*",
        //     component: require('./components/common/error/404').default,
        // }


    ]
});

router.beforeEach((to, from, next) => {
    /*if link with invitation*/
    if(to.query.pin) {
        if(to.params.id) localStorage.setItem('pin_id', to.params.id);
        if(to.name === 'account-deal-register') localStorage.setItem('pin', to.query.pin);
        if(to.name === 'account-deal-notary-register') localStorage.setItem('pin_notary', to.query.pin);
    }
    /*if not login and has link with invitation*/
    if ((to.name === 'account-deal-register' || to.name === 'account-deal-notary-register') && !localStorage.getItem('token')) {
        window.location.pathname = "/login";
    }
    else next();

    /*check login*/
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!localStorage.getItem('token')) {
            window.location.pathname = "/login";
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
