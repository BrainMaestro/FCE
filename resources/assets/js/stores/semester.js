import { http } from 'vue';

export default {
    /**
     * Get all semesters.
     *
     * @param  {Function} successCb
     */
    getAllSemesters(successCb) {
        http.get('/api/semesters')
            .then(successCb)
            .catch();
    },
};