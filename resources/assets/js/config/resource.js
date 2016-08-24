import Vue, { http } from 'vue';
import resource from 'vue-resource';
import router from './router';
import userStore from '../stores/user';
import store from '../services/store';

const app = new Vue(require('../app.vue'));

Vue.use(resource);

http.interceptors.push({
    request(req) {
        const token = store.get('jwt-token');
        if (token) {
            http.headers.common.Authorization = `Bearer ${token}`;
        } else {
            delete http.headers.common.Authorization;
        }

        return req;
    },

    response(res) {
        // Remove duplicate data property.
        if (res.data.data) {
            if (res.data.meta) {
                res.meta = res.data.meta;
            }
            res.data = res.data.data;
        } else if (res.data.error) {
            res.error = res.data.error;
            delete res.data;
        }

        // Redirects user to auth-form if token has expired.
        if (res.error && res.status == 401) {
            app.logout();
        }

        return res;
    },
});
