import Vue from 'vue';
import router from '../config/router';

export default {
    /**
     * Log a user in.
     *
     * @param  {String} email
     * @param  {String} password
     */
    login(email, password) {
        Vue.http.post('/login', {email, password})
            .then(() => router.go('/sections'))
            .catch((res) => console.log(res));
    }
};
