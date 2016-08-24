import store from 'store';
import router from '../config/router';

import http from '../services/http';

export default {
    /**
     * Log a user in.
     *
     * @param  {String} email
     * @param  {String} password
     */
    login(email, password, successCb = null, errorCb = null) {
        http.post('/login', { email, password }, (response) => successCb(response), (errors) => errorCb(errors))
    },

    /**
     * Log a user out.
     */
    logout(successCb = null, errorCb = null) {
        http.delete('/logout', (response) => successCb(response), (errors) => errorCb(errors))
    },

    /**
     * Get all users.
     *
     * @param  {Function} successCb
     */
    getAllUsers(successCb) {
        http.get('/api/users?include=roles')
            .then(successCb)
            .catch();
    }
};

