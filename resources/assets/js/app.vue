<template>
    <div id="app" class="is-flex">
        <app-header></app-header>

        <main class="columns">
            <side-menu class="column is-2" v-if="userStore.isAuthenticated"></side-menu>

            <div class="column">
                <router-view></router-view>
            </div>
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
    import userStore from './stores/user';

    export default {
        components: { AppHeader, AppFooter, SideMenu },

        data() {
            return {
                userStore,
            };
        },
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
