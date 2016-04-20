<template>
    <div class="columns is-flex">
        <div class="column is-half is-offset-one-quarter">
            <!--Tab-->
            <div class="tabs is-centered is-boxed">
                <ul>
                    <li :class="{ 'is-active': evaluationTab }">
                        <a @click="switchTabs"><i class="fa fa-check-square-o"></i> Evaluation</a>
                    </li>
                    <li :class="{ 'is-active': !evaluationTab }">
                        <a @click="switchTabs"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
                </ul>
            </div>

            <!--Evaluation input-->
            <div class="has-text-centered" v-show="evaluationTab">
                <label class="label">Key</label>
                <p class="control has-icon">
                    <input class="input" type="text" placeholder="ABCDEF">
                    <i class="fa fa-key"></i>
                </p>
                <button class="button is-primary">Ready</button>
            </div>

            <!--Login input-->
            <div class="has-text-centered" v-else="evaluationTab">
                <label class="label">Email</label>
                <p class="control has-icon">
                    <input class="input" type="email" placeholder="fce@aun.edu.ng" v-model="email">
                    <i class="fa fa-envelope"></i>
                </p>

                <label class="label">Password</label>
                <p class="control has-icon">
                    <input class="input" type="password" placeholder="password" v-model="password">
                    <i class="fa fa-lock"></i>
                </p>

                <button class="button is-primary" @click="login">Login</button>
            </div>
        </div>
    </div>
</template>

<script>
    import userStore from '../stores/user';
    import router from '../config/router';
    import store from 'store';

    export default {
        data() {
            return {
                evaluationTab: true,
                email: '',
                password: '',
            }
        },

        ready() {
            if (store.get('jwt-token')) {
                router.go('/sections');
            }
        },

        methods: {
            switchTabs() {
                this.evaluationTab = !this.evaluationTab;
            },

            login() {
                userStore.login(this.email, this.password);
            }
        }
    };
</script>
