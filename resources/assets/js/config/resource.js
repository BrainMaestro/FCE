import Vue from 'vue';
import resource from 'vue-resource';
import store from 'store';

Vue.use(resource);

Vue.http.interceptors.push({
    request(req) {
        const token = store.get('jwt-token');

        if (token) {
            Vue.http.headers.common.Authorization = `Bearer ${token}`;
        }

        return req;
    },

    response(res) {
        res.data = res.data.data;

        if (res.data && res.data.token) {
            store.set('jwt-token', res.data.token);
        }

        return res;
    }
});
