import store from 'store';

export default {
    get(key, defaultVal = null) {
        const val = store.get(key);

        return val ? val : defaultVal;
    },

    set(key, val) {
        return store.set(key, val);
    },

    remove(key) {
        return store.remove(key);
    },
};