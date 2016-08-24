<template>
    <div class="columns is-flex">
        <div class="column is-tablet is-one-third is-offset-one-third">
        	<div class="notification is-danger" v-if="error.status">
			  <button @click="clearError" class="delete"></button>
			  {{ error.message }}
			</div>
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
                <p class="control has-icon">
                    <input class="input" type="text" placeholder="Evaluation Key">
                    <i class="fa fa-key"></i>
                </p>
                <button class="button is-primary">Ready</button>
            </div>

            <!--Login input-->
            <div class="has-text-centered" v-else="evaluationTab">
                <p class="control has-icon">
                    <input class="input" type="email" placeholder="AUN Email" v-model="email">
                    <i class="fa fa-envelope"></i>
                </p>
                <p class="control has-icon">
                    <input class="input" type="password" placeholder="FCE Password" v-model="password">
                    <i class="fa fa-lock"></i>
                </p>
                <button class="button is-primary" @click="login">Login</button>
            </div>
        </div>
    </div>
</template>

<script>
    import userStore from '../../stores/user';

    export default {
        data() {
            return {
                evaluationTab: true,
                email: '',
                password: '',
                error: {
                	status: false,
                	message: '',
                },
            }
        },

        methods: {
            switchTabs() {
                this.evaluationTab = !this.evaluationTab;
            },

            clearError() {
            	this.error.status = false;
            	this.error.message = '';
            },

            login() {
                userStore.login(this.email, this.password, (response) => {
                	this.$dispatch('user:loggedin', response);
                	//Just debug info *useless
                	console.log(response);
            	}, (errors) => {
            		// Of course this has to change. Just to help in debugging.
            		this.error.status = true;
            		this.error.message = "Bounced!!! Sorry";
            		// Couldn't get this to work
            		console.log(errors);
            	}

                );
            }
        }
    };
</script>
