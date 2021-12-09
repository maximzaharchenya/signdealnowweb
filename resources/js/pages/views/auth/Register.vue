<template>
    <div>
        <auth-header></auth-header>

        <div class="auth--page content">

            <div class="bg-container"></div>
            <div class="content-container d-flex flex-column justify-content-center">

                <div v-if="show_email_confirm">
                    <h2 class="mb-4">Подтверждение</h2>
                    <p class="mb-40 color-text-grey pr-5">Письмо для потдверждения адреса электронной почты отправлено на Ваш email. <br>
                        Для того, чтобы завершить процесс регистрации, вам необходимо открыть данное ссобщение и перейти по ссылке.
                    </p>
                </div>

                <div v-else class="pt-5">
                    <h1 class="as-h2 mb-4">Регистрация</h1>

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
                        <div class="mb-20 form--item" :class="{'is-invalid': $v.password.$error, 'is-valid': !$v.password.$invalid}">
                            <label for="password">Пароль*</label>
                            <input id="password"
                                   type="password"
                                   autocomplete="off"
                                   @input="delayTouch($v.password)"
                                   v-model.trim="password"
                            >
                        </div>
                        <div class="mb-20 form--item" :class="{'is-invalid': $v.password_repeat.$error, 'is-valid': !$v.password_repeat.$invalid}">
                            <label for="password_repeat">Повторите пароль*</label>
                            <input id="password_repeat"
                                   type="password"
                                   autocomplete="off"
                                   @input="delayTouch($v.password_repeat)"
                                   v-model.trim="password_repeat"
                            >
                        </div>

                        <div class="mb-40 confirm--box">
                            <div class="checkbox">
                                <input type="checkbox" id="confirm"
                                       @input="delayTouch($v.checkbox_register)"
                                       v-model.trim="checkbox_register">
                                <label for="confirm" class="small">Я согласен с Условиями использования и политикой конфиденциальности</label>
                            </div>
                        </div>

                        <button @click="register()"  :disabled="$v.$invalid" class="btn-large btn-v1 mb-40">Зарегистрироваться</button>

                        <div class="auth--footer">
                            <p class="mb-0">У вас уже существует аккаунт?</p>
                            <router-link to="/login" class="btn-small btn-v2">Войти</router-link>
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
    import { emailRule, passwordRule, passwordRepeatRule, checkbox } from '../../../services/validation';
    const touchMap = new WeakMap();

    export default {

        data () {
            return {
                email: null,
                password: null,
                password_repeat: null,
                checkbox_register: false,

                loading: false,
                show_email_confirm: false

            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        methods: {
            register() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                } else {
                    this.loading = true;
                    let url = '/api/register';
                    let data = {
                        email: this.email,
                        password: this.password
                    };
                    axios.post(url, data)
                        .then(response => {
                            if(response.status == 200) {
                                this.show_email_confirm = true;
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
            password: passwordRule,
            password_repeat: passwordRepeatRule,
            checkbox_register: checkbox

        }
    }
</script>
