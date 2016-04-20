<template>
    <div id="app" class="is-flex">
        <app-header></app-header>

        <main>
            <div class="container">
                <router-view></router-view>
            </div>
        </main>

        <app-footer></app-footer>
    </div>
</template>

<script>
    import 'bulma/css/bulma.css';
    import 'font-awesome/css/font-awesome.css';

    import AppHeader from './components/app-header.vue';
    import AppFooter from './components/app-footer.vue';

    export default {
        components: { AppHeader, AppFooter },
    }
</script>

<style>
    #app {
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
        padding: 3em 0;
    }
</style>
