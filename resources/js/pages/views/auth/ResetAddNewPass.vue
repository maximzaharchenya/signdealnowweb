<template>
    <div>
        <auth-header></auth-header>

        <div class="auth--page content">

            <div class="bg-container"></div>
            <div class="d-flex flex-column justify-content-center">
                <div>
                    <h1 class="as-h2 mb-4">Восстановление пароля</h1>

                    <div class="custom-form position-relative">

                        <div class="mb-20 form--item" :class="{'is-invalid': $v.password.$error, 'is-valid': !$v.password.$invalid}">
                            <label for="password">Новый пароль*</label>
                            <input id="password"
                                   autocomplete="off"
                                   type="password"
                                   @input="delayTouch($v.password)"
                                   v-model.trim="password">
                        </div>

                        <div class="mb-40 form--item" :class="{'is-invalid': $v.password_repeat.$error, 'is-valid': !$v.password_repeat.$invalid}">
                            <label for="password_repeat">Повторите пароль*</label>
                            <input id="password_repeat"
                                   autocomplete="off"
                                   type="password"
                                   @input="delayTouch($v.password_repeat)"
                                   v-model.trim="password_repeat">
                        </div>


                        <button @click="reset()"  :disabled="$v.$invalid" class="btn-large btn-v1 mb-40">Подтвердить</button>

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
    import { passwordRule, passwordRepeatRule } from '../../../services/validation';
    const touchMap = new WeakMap();

    export default {

        data () {
            return {
                password: null,
                password_repeat: null,

                loading: false,

            }
        },

        methods: {
            reset() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                } else {
                    if(this.$route.query.pin) {
                        this.loading = true;
                        let url = '/api/recovery/delete';
                        let data = {
                            password: this.password,
                            pin: this.$route.query.pin
                        };
                        axios.post(url, data)
                            .then(response => {
                                if(response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Готово',
                                        html: `Пароль успешно изменен. <br> Введите новые данные для доступа в личный кабинет.`,
                                    }).then(() => {
                                        window.location.pathname = '/login';
                                    })
                                }
                            })
                            .finally(() => {
                                this.loading = false
                            });
                    }
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

        validations: {
            password: passwordRule,
            password_repeat: passwordRepeatRule,
        }
    }
</script>
