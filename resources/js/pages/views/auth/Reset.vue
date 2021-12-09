<template>
    <div>
        <auth-header></auth-header>

        <div class="auth--page content">

            <div class="bg-container"></div>
            <div class="content-container d-flex flex-column justify-content-center">
                <div>
                    <h1 class="as-h2 mb-4">Восстановление пароля</h1>

                    <div class="custom-form position-relative">

                        <div class="mb-40 form--item" :class="{'is-invalid': $v.email.$error, 'is-valid': !$v.email.$invalid}">
                            <label for="email">Email*</label>
                            <input id="email"
                                   autocomplete="off"
                                   type="email"
                                   @input="delayTouch($v.email)"
                                   v-model.trim="email">
                        </div>


                        <button @click="reset()"  :disabled="$v.$invalid" class="btn-large btn-v1 mb-40">Восстановить доступ</button>

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
    import { emailRule } from '../../../services/validation';
    const touchMap = new WeakMap();

    export default {

        data () {
            return {
                email: null,

                loading: false,

            }
        },

        methods: {
            reset() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                } else {
                    this.loading = true;
                    let url = '/api/recovery/store';
                    let data = {
                        email: this.email,
                    };
                    axios.post(url, data)
                        .then(response => {
                            if(response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Инструкция по смене пароля выслана на ваш Email',
                                }).then(() => {
                                    window.location.pathname = '/';
                                })
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

        validations: {
            email: emailRule,
        }
    }
</script>
