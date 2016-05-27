<template>
    <header class="header">
        <div class="container">
            <!-- Left side -->
            <div class="header-left">
                <a class="header-tab is-active" href="#">
                    Faculty Course Evaluation
                </a>
            </div>

            <!-- Hamburger menu (on mobile) -->
            <span class="header-toggle">
                <span></span>
                <span></span>
                <span></span>
            </span>

            <!-- Right side -->
            <div class="header-right header-menu">
                <span class="header-item">
                    <logout></logout>
                </span>
            </div>
        </div>
    </header>
</template>

<script>
    import Logout from '../logout.vue';

    export default {
        components: { Logout }
    }
</script>

<style>
    .header {
        background: #333275;
        color: white;
    }
</style>
