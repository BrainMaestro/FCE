import Vue, { http } from 'vue';
import resource from 'vue-resource';
import store from 'store';
import router from './router';

Vue.use(resource);

http.interceptors.push({
    request(req) {
        const token = store.get('jwt-token');

        if (token) {
            http.headers.common.Authorization = `Bearer ${token}`;
        }

        return req;
    },

    response(res) {
        // Remove duplicate data property.
        if (res.data.data) {
            res.data = res.data.data
        } else if (res.data.error) {
            res.error = res.data.error;
            delete res.data;
        }

        if (res.data && res.data.token) {
            store.set('jwt-token', res.data.token);
        }

        // Redirects user to home if token has expired.
        if (res.error && res.error.message == 'Token has expired') {
            store.remove('jwt-token');
            router.go('/');
        }

        return res;
    }
});
