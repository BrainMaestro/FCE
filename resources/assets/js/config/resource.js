import Vue, { http } from 'vue';
import resource from 'vue-resource';
import router from './router';
import userStore from '../stores/user';

Vue.use(resource);

http.interceptors.push({
    request(req) {
        if (userStore.isAuthenticated) {
            http.headers.common.Authorization = `Bearer ${userStore.token}`;
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

        // Redirects user to home if token has expired.
        if (res.error && res.status == 401) {
            userStore.isAuthenticated = false;
            userStore.deleteToken();
            return router.go('/');
        }

        return res;
    },
});
