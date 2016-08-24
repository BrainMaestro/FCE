<template>
    <div v-show="$root.authenticated">
    <button v-show="error" class="button is-danger">
      <span class="icon">
        <i class="fa fa-exclamation-circle"></i>
      </span>
      <span>Error!</span>
    </button>
    <button v-else class="button is-primary is-outlined" @click="logout"
            >
    <span>Logout</span>
      <span class="icon">
        <i class="fa fa-sign-out"></i>
      </span>

    </button>
    </div>
</template>

<script>
    import userStore from '../../stores/user';

    export default {
        data() {
            return {
                error: false,
            }
        },
        methods: {
            logout() {
                userStore.logout((response) => {
                    this.$dispatch('user:loggedout');
                }, (error) => {
                    this.error = true;
                });
            },
        },
    };
</script>