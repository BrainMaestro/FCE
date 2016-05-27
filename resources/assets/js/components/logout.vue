<template>
    <!-- Slightly hacky. -->
    <button class="button is-primary is-outlined" @click="logout"
            v-if="userStore.isAuthenticated">
            Logout
    </button>
</template>

<script>
    import userStore from '../stores/user';

    export default {
        data() {
            return {
                userStore,
                logout: userStore.logout,
            };
        },
    };
</script>
