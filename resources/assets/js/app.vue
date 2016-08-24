<template>
    <div id="app" class="is-flex">
        <app-header></app-header>

        <main class="columns" v-if="authenticated">
            <side-menu class="column is-2"></side-menu>

            <div class="column">
                <router-view></router-view>
            </div>
        </main>
        <main v-else>
            <auth-form></auth-form>
        </main>

        <app-footer></app-footer>
    </div>
</template>

<script>
    import 'bulma/css/bulma.css';
    import 'font-awesome/css/font-awesome.css';

    import AppHeader from './components/layout/app-header.vue';
    import AppFooter from './components/layout/app-footer.vue';
    import SideMenu from './components/layout/side-menu.vue';
    import AuthForm from './components/auth/auth-form.vue';
    import userStore from './stores/user';
    import store from './services/store';
    import router from './config/router';

    export default {
        components: { AppHeader, AppFooter, SideMenu, AuthForm },

        data() {
            return {
                authenticated: false,
            };
        },
        ready() {
            const token = store.get('jwt-token');
            if (token) {
                this.authenticated = true;
                this.init();
                router.go('/sections');
            }
        },
        methods: {
            init() {
                //Tell 'em
                this.$broadcast('fce:up');
            },
            teardown() {
                this.$broadcast('fce:down');
            },
            logout() {
                store.remove('jwt-token');
                this.authenticated = false;
                this.teardown();
                router.go('/'); 
            },
            login(response) {
                store.set('jwt-token', response.data.token);
                this.authenticated = true;
                this.init();
                router.go('/sections'); 
            }
        },
        events: {
            'user:loggedin': function (response) {
                this.login(response);
            },
            'user:loggedout': function () {
                this.logout();
            },
        }
    }
</script>

<style>
    #app {
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
        padding: 3em;
    }
</style>
