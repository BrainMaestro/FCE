import Vue from 'vue';
import VueRouter from 'vue-router';
import userStore from '../stores/user';

import Login from '../components/pages/login.vue';
import Sections from '../components/pages/sections.vue';
import Semesters from '../components/pages/semesters.vue';
import Users from '../components/pages/users.vue';

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

    '/semesters': {
        component: Semesters,
        auth: true,
    },

    '/users': {
        component: Users,
        auth: true,
    },

});

router.beforeEach((transition) => {
    if (transition.to.auth && !userStore.isAuthenticated) {
        transition.redirect('/');
    } else if (!transition.to.auth && userStore.isAuthenticated) {
        transition.redirect('/sections');
    } else {
        transition.next();
    }
});

export default router;
