<template>
    <div class="overflow-hidden vh-100">
        <auth-header></auth-header>

        <div class="auth--page content">

            <div class="bg-container"></div>
            <div class="content-container d-flex flex-column justify-content-center">
                <div>
                    <h1 class="as-h2 mb-4">Вход</h1>

                    <div class="custom-form position-relative">

                        <div class="mb-20 form--item" :class="{'is-invalid': $v.email.$error, 'is-valid': !$v.email.$invalid}">
                            <label for="email">Email*</label>
                            <input id="email"
                                   autocomplete="off"
                                   type="email"
                                   @input="delayTouch($v.email)"
                                   v-model.trim="email"
                            >
                        </div>
                        <div class="form--item mb-1" :class="{'is-invalid': $v.password.$error, 'is-valid': !$v.password.$invalid}">
                            <label for="password">Пароль*</label>
                            <input id="password"
                                   type="password"
                                   autocomplete="off"
                                   @input="delayTouch($v.password)"
                                   v-model.trim="password"
                            >
                        </div>
                        <div class="mb-40">
                            <router-link to="/restore" class="text-primary ">Забыли пароль?</router-link>
                        </div>

                        <button @click="login()"  :disabled="$v.$invalid" class="btn-large btn-v1 mb-40">Войти в личный кабинет</button>

                        <div class="auth--footer">
                            <p class="mb-0">Еще нет аккаунта?</p>
                            <router-link to="/register" class="btn-small btn-v2">Зарегистрироваться</router-link>
                        </div>

                        <div class="load-box" v-if="loading">
                            <b-spinner></b-spinner>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>



<script>
    import { emailRule, passwordRule } from '../../../services/validation';
    const touchMap = new WeakMap();

    export default {

        data () {
            return {
                email: null,
                password: null,

                loading: false,
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        methods: {
            login() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return false;
                } else {
                    this.loading = true;

                    let url = '/api/login';
                    let data = {
                        email: this.email,
                        password: this.password
                    };

                    let formData = new FormData();
                    formData.append('email', this.email);
                    formData.append('password', this.password);

                    axios.post(url, formData)
                        .then(response => {
                            if(response.status == 200) {
                                localStorage.setItem('token', response.data.access_token);
                                this.$store.dispatch('fetchUser');
                                window.location.pathname = "/account";
                            }
                        })
                        .finally(() => {
                            this.loading = false
                        })

                }
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000))
            }
        },

        watch: {
            user() {
                if(this.user && this.user.id) window.location.href = '/account';
            }
        },

        created() {
            if(this.user && this.user.id) window.location.href = '/account';
        },

        validations: {
            email: emailRule,
            password: passwordRule
        }
    }
</script>
