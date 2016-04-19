import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from './components/login.vue';

Vue.use(VueRouter);

const router = new VueRouter();

router.map({
    '/': {
        component: Login
    }
});

export default router;
