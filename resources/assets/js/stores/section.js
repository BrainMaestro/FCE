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
    /**
     * Add a section.
     * @param {Object} section   section to be added
     * @param {Function} successCb function to be called
     */
    addSection(section, successCb) {
        http.post('/api/sections', section)
            .then(successCb)
            .catch();
    }
};
