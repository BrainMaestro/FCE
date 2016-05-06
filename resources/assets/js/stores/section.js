import { http } from 'vue';

export default {
    /**
     * Get all sections.
     *
     * @param  {Function} successCb
     */
    getAllSections(successCb) {
        // TODO remove questionSets from semester includes
        http.get('/api/sections?include=semester,school')
            .then(successCb)
            .catch();
    },
};
