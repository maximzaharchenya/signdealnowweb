<template>
    <div>
        <div class="custom-form position-relative w-100">

            <div class="row justify-content-between">
                <div class="col-lg-6">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.name.$error, 'is-valid': !$v.name.$invalid}">
                        <label for="name">Имя*</label>
                        <input id="name"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.name)"
                               v-model.trim="name"
                        >
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible}">
                        <label for="phone">Телефон*</label>
                        <vue-tel-input id="phone"
                                       autocomplete="off"
                                       type="text"
                                       @input="delayTouch($v.phone)"
                                       v-model.trim="phone"
                                       @validate="telValidate"
                                       @blur="blur"
                                       :validCharactersOnly="validCharactersOnly"
                                       :inputOptions="inputOptions"
                                       :mode="mode"
                        ></vue-tel-input>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.email.$error, 'is-valid': !$v.email.$invalid}">
                        <label for="email">Email*</label>
                        <input id="email"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.email)"
                               v-model.trim="email"
                        >
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-40 form--item"
                         :class="{'is-invalid': $v.message.$error, 'is-valid': !$v.message.$invalid}">
                        <label for="text">Сообщение*</label>
                        <textarea id="text"
                                  rows="4"
                                  autocomplete="off"
                                  @input="delayTouch($v.message)"
                                  v-model.trim="message"
                        ></textarea>
                    </div>
                </div>
            </div>

            <button @click="login()" :disabled="$v.$invalid || !phoneValid" class="btn-large btn-v1">Отправить</button>

            <div class="load-box" v-if="loading">
                <b-spinner></b-spinner>
            </div>
        </div>
    </div>
</template>

<script>
    import {requiredRule, emailRule} from '../../../../services/validation';

    const touchMap = new WeakMap();

    import {VueTelInput} from 'vue-tel-input';

    export default {
        props: ['data'],
        components: {
            VueTelInput,
        },

        data() {
            return {
                name: null,
                phone: null,
                message: null,
                email: null,

                loading: false,

                dynamicPlaceholder: true,
                validCharactersOnly: true,
                enabledCountryCode: true,
                inputOptions: {
                    showDialCode: true,
                },
                mode: 'international',
                phoneValid: '',
                possible: '',

            }
        },

        watch: {
            data() {
                if(this.data) this.init();
            }
        },

        mounted() {
            if(this.data) this.init();
        },

        methods: {
            login() {
                this.$v.$touch();

                if (this.$v.$invalid || !this.phoneValid) {
                    if(!this.phoneValid) this.possible = true;
                    return;
                } else {
                    this.loading = true;
                    let url = '/api/support/store';
                    let data = {
                        name: this.name,
                        phone: this.phone,
                        message: this.message,
                        email: this.email,
                    };
                    axios.post(url, data)
                        .then(response => {
                            if (response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: `Ваш вопрос успешно сохранен. <br> Администратор свяжется с Вами в ближайшее время!`,
                                }).then(() => {
                                    window.location.pathname = '/';
                                })
                            }
                        })
                        .finally(() => {
                            this.loading = false
                        });
                }
            },

            init() {
                if(this.data) {
                    this.name = this.data.name;
                    this.phone = this.data.phone;
                    this.email = this.data.email;
                }
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000))
            },

            telValidate(number, isValid, country) {
                this.phoneValid = number.valid;
                this.possible = number.possible;
            },
            blur() {
                if (this.phoneValid == false) {
                    this.possible = true;
                }
            },
        },

        validations: {
            name: requiredRule,
            phone: requiredRule,
            message: requiredRule,
            email: emailRule,
        }
    }
</script>
