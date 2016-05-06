import { http } from 'vue';

export default function (searchString, searchValues, model, successCB) {
    // TODO Remove the includes. It is temporary.
    http.get(`/api/search?query=${searchString}&model=${model}&include=semester,school`, searchValues)
        .then(successCB)
        .catch();
}
