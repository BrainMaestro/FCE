import { http } from 'vue';
import router from '../config/router';

export default {
    /**
     * Log a user in.
     *
     * @param  {String} email
     * @param  {String} password
     */
    login(email, password) {
        http.post('/login', {email, password})
            .then(() => router.go('/sections'))
            .catch((res) => console.log(res));
    }
};
