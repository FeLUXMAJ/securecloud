<template>
    <md-whiteframe md-elevation="4" id="auth-panel" :class="type">
        <md-spinner :md-size="100" :md-stroke="1" id="auth-card-loader" md-indeterminate></md-spinner>
        <form>
            <header class="md-primary">
                <h2 v-if="this.type == 'login'">Login</h2>
                <h2 v-else>Registrierung</h2>
                <!-- todo: make a link instead!? -->
                <md-button v-if="type == 'login'" class="md-fab md-mini" id="register-button" href="/register">
                    <md-icon>add</md-icon>
                    <md-tooltip md-direction="top">Registrieren</md-tooltip>
                </md-button>
            </header>
            <md-layout md-gutter class="content">
                <md-layout id="login-area">

                    <div v-if="type != 'register'">
                        <md-input-container>
                            <label>Username</label>
                            <md-input name="name" autocomplete="off" v-model="formData.name"></md-input>
                            <span class="md-error"></span>
                        </md-input-container>
                    </div>

                    <vue-camera :type="type"></vue-camera>

                    <input type="hidden" name="photo">

                    <md-input-container id="password-login">
                        <label>Passwort</label>
                        <md-input type="password" name="password" v-model="formData.password"></md-input>
                        <span class="md-error"></span>
                    </md-input-container>

                </md-layout>

                <md-layout md-column id="user-data" v-if="type == 'register'">
                    <md-input-container>
                        <label>Username</label>
                        <md-input name="name" autocomplete="off" v-model="formData.name"></md-input>
                        <span class="md-error"></span>
                    </md-input-container>

                    <md-input-container>
                        <label>Passwort</label>
                        <md-input type="password" name="password" v-model="formData.password"></md-input>
                        <span class="md-error"></span>
                    </md-input-container>

                    <md-input-container>
                        <label>Passwort bestätigen</label>
                        <md-input type="password" name="passwordConfirm" v-model="formData.passwordConfirm"></md-input>
                        <span class="md-error"></span>
                    </md-input-container>

                    <md-button class="md-fab md-accent" @click.native="registerUser">
                        <md-icon>send</md-icon>
                    </md-button>

                </md-layout>
                <div v-else>
                    <md-button class="md-fab md-accent" @click.native="loginWithPassword" id="login-button">
                        <md-icon>send</md-icon>
                    </md-button>
                </div>
            </md-layout>
        </form>
    </md-whiteframe>
</template>

<script>

    import Ajax from '../support/Ajax';
    import VueCamera from './VueCamera';
    import Camera from '../support/Camera';
    import { EventBus } from '../support/EventBus';

    export default {

        props: ['type'],

        data () {
            return{
                formData: {}
            }
        },

        methods: {

            registerUser: function() {

                Ajax.showLoader();

                this.formData.photo = Camera.exportImage();

                this.$http.post('/register', this.formData).then(response => {
                    Ajax.showAlert(response, Ajax.redirectUserIfRequired(response));
                }, response => {
                    Ajax.handleValidationErrors(response);
                    Ajax.handleServerError(response);
                });

            },

            loginUser: function() {

                Ajax.showLoader();

                this.formData.photo = Camera.exportImage();

                this.$http.post('/login', this.formData).then(response => {
                    Ajax.showAlert(response, Ajax.redirectUserIfRequired(response));
                }, response => {
                    // at first, check if all inputs are filled
                    Ajax.handleValidationErrors(response);

                    // handle 500 errors if there are some
                    Ajax.handleServerError(response);

                    // then, validate login error response and go on
                    Ajax.showAlert(response, function() {
                        if( 'password_required' in response.data ) {
                            this.showLoginStep2();
                        }
                    }.bind(this));
                });

            },

            loginWithPassword: function() {

                this.$http.post('/login/password', this.formData).then(response => {
                    Ajax.showAlert(response, Ajax.redirectUserIfRequired(response));
                }, response => {
                    Ajax.handleValidationErrors(response);
                    Ajax.showAlert(response);
                });

            },

            showLoginStep2: function() {

                $('.content').removeClass('content');

                $('#vue-camera').slideUp(400);
                $('#register-button').fadeOut(400);

                $('#password-login').slideDown(400, function() {
                    $('#login-button').fadeIn(400);
                });

                // reset photo to keep the ajax requests small
                this.formData.photo = null;

            },

        },

        components:{
            'vue-camera': VueCamera
        },

        created: function() {

            // catch login event
            EventBus.$on('do-login', this.loginUser);

        },

}

</script>