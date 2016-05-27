import { http } from 'vue';
import store from 'store';
import router from '../config/router';

const userStore = {
    isAuthenticated: !!store.get('jwt-token'),

    /**
     * Log a user in.
     *
     * @param  {String} email
     * @param  {String} password
     */
    login(email, password) {
        http.post('/login', { email, password })
            .then((res) => {
                userStore.isAuthenticated = true;
                store.set('jwt-token', res.data.token);
                router.go('/sections');
            })
            .catch((res) => console.log(res));
    },

    /**
     * Log a user out.
     */
    logout(successCb) {
        http.delete('/logout')
            .then(() => {
                userStore.isAuthenticated = false;
                store.remove('jwt-token');
                router.go('/');
            })
            .catch((res) => console.log(res));
    }
};

export default userStore;
