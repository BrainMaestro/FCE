import { http } from 'vue';
import store from 'store';
import router from '../config/router';

const userStore = {
    isAuthenticated: !!store.get('jwt-token'),

    get token() {
        return store.get('jwt-token');
    },

    set token(token) {
        store.set('jwt-token', token);
    },

    deleteToken() {
        store.remove('jwt-token');
    },

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
                userStore.token = res.data.token;
                router.go('/sections');
            })
            .catch((res) => console.log(res));
    },

    /**
     * Log a user out.
     */
    logout() {
        http.delete('/logout')
            .then(() => {
                userStore.isAuthenticated = false;
                userStore.deleteToken();
                router.go('/');
            })
            .catch((res) => console.log(res));
    },

    /**
     * Get all users.
     *
     * @param  {Function} successCb
     */
    getAllUsers(successCb) {
        http.get('/api/users')
            .then(successCb)
            .catch();
    }
};

export default userStore;
