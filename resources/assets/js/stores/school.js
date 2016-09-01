import { http } from 'vue';

export default {
    /**
     * Get all schools.
     *
     * @param  {Function} successCb
     */
    getAllSchools(successCb) {
        http.get('/api/schools')
            .then(successCb)
            .catch();
    },
};