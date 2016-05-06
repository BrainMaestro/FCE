import Vue from 'vue';
import VueRouter from 'vue-router';
import store from 'store';

import Login from '../components/pages/login.vue';
import Sections from '../components/pages/sections.vue';

Vue.use(VueRouter);

const router = new VueRouter();

router.map({
    '/': {
        component: Login,
    },

    '/sections': {
        component: Sections,
        auth: true,
    },
});

router.beforeEach((transition) => {
    if (transition.to.auth && !store.get('jwt-token')) {
        transition.redirect('/');
    } else {
        transition.next();
    }
});

export default router;
