<template>
    <div>
        <auth-header></auth-header>

        <div class="auth--page content">

            <div class="bg-container"></div>
            <div class="content-container d-flex flex-column justify-content-center">
                <div>
                    <h1 class="as-h2 mb-4">Аутентификация <br>в системе</h1>

                    <div class="custom-form position-relative" v-if="transaction_id">
                        <div class="bg-primary-light p-4 d-flex flex-row align-items-center justify-content-between">
                            <p class="mb-0">Код подтверждения</p>
                            <h3 class="mb-0 text-primary" v-if="transaction && transaction.code">{{ transaction.code }}</h3>
                        </div>
                    </div>

                    <div class="custom-form position-relative">


                        <div class="authentication--nav mb-40" v-if="!transaction_id">
                            <div class="nav-item"
                                 :class="{'active': active == item.id}"
                                 v-for="item in authentication_types"
                                 @click="active = item.id">
                                {{ item.name }}
                            </div>
                        </div>

                        <div v-if="!transaction_id && active == 1">
                            <button @click="authentication_1()" class="btn-large btn-v1 mb-40">
                                Авторизоваться
                            </button>
                        </div>


                        <div v-if="!transaction_id && active == 2">

                            <div>
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

                                <div class="mb-40 form--item"
                                     :class="{'is-invalid': $v.code_1.$error, 'is-valid': !$v.code_1.$invalid}">
                                    <label for="code_1">Личный код*</label>
                                    <input id="code_1"
                                           min="1"
                                           autocomplete="off"
                                           type="number"
                                           @input="delayTouch($v.code_1)"
                                           v-model.trim="code_1">
                                </div>

                                <button @click="authentication_2()" class="btn-large btn-v1 mb-40">
                                    Авторизоваться
                                </button>
                            </div>

                        </div>

                        <div v-if="!transaction_id && active == 3">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.country.$error, 'is-valid': !$v.country.$invalid}">
                                <label for="phone">Тип документа*</label>
                                <multiselect v-model="identity_type"
                                             :options="smart_id_types"
                                             :allow-empty="false"
                                             :searchable="false"
                                             label="name"
                                             track-by="code"
                                ></multiselect>
                            </div>

                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.country.$error, 'is-valid': !$v.country.$invalid}">
                                <label for="phone">Страна*</label>
                                <multiselect v-model="country"
                                             :options="countries_options"
                                             :allow-empty="false"
                                             :searchable="false"
                                ></multiselect>
                            </div>

                            <div class="mb-40 form--item"
                                 :class="{'is-invalid': $v.code_2.$error, 'is-valid': !$v.code_2.$invalid}">
                                <label for="code_2">Личный код*</label>
                                <input id="code_2"
                                       min="1"
                                       autocomplete="off"
                                       type="number"
                                       @input="delayTouch($v.code_2)"
                                       v-model.trim="code_2">
                            </div>

                            <button @click="authentication_3()" class="btn-large btn-v1 mb-40" v-if="!transaction_id">
                                Авторизоваться
                            </button>
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
import {requiredRule} from '../../../services/validation';
import RequestsServices from '../../../services/requests';

const touchMap = new WeakMap();

import {VueTelInput} from 'vue-tel-input';
import Multiselect from 'vue-multiselect'

export default {
    components: {
        VueTelInput,
        Multiselect
    },

    computed: {
        user() {
            return this.$store.getters.getUser;
        }
    },

    data() {
        return {
            active: 2,
            authentication_types: [
                /*{id: 1, name: 'ID-card'},*/
                {id: 2, name: 'Mobile-ID'},
                {id: 3, name: 'Smart-ID'},
            ],

            smart_id_types: [
                {code: 'PNO', name: 'Personal number'},
                {code: 'PAS', name: 'Passport number'},
                {code: 'IDC', name: 'National identity card number'},
            ],

            phone: null,
            code_1: null,
            country: null,
            code_2: null,
            identity_type: null,

            /*data for vue-tel-input*/
            dynamicPlaceholder: true,
            validCharactersOnly: true,
            enabledCountryCode: true,
            inputOptions: {
                showDialCode: true,
            },
            mode: 'international',
            phoneValid: '',
            possible: '',
            /**/

            countries_options: null,

            loading: false,

            transaction_id: null,
            transaction: null,
        }
    },

    methods: {

        checkTransaction() {
            const url = '/api/skid/check';
            const options = {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem('token')
                }
            };
            axios.get(url, options)
                .then(response => {
                    if (response.status == 200) {
                        this.transaction = response.data;
                        if (!this.transaction.data) setTimeout(() => this.checkTransaction(), 3000);
                        else {
                            if (this.transaction.status == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Вы успешно прошли аутентификацию',
                                }).then(() => {
                                    window.location.href = '/account/edit';
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Не получилось аутентифицировать',
                                    html: 'Попробуйте еще раз',
                                }).then(() => {
                                    this.transaction = null;
                                    this.transaction_id = null;
                                    this.loading = false;
                                })
                            }
                        }
                    }
                })
        },

        authentication_1() {

        },

        authentication_2() {
            this.$v.$touch();
            if (this.$v.code_1.$invalid || !this.phoneValid) {
                if (!this.phoneValid) this.possible = true;
                return;
            } else {
                this.loading = true;
                const url = '/api/skid/auth';
                let data = {
                    authenticationType: 'mobile_id',
                    phoneNumber: this.phone,
                    personalCode: this.code_1,
                };
                const options = {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('token')
                    }
                };
                axios.post(url, data, options)
                    .then(response => {
                        if (response.status == 200) {
                            this.transaction_id = response.data.transaction_id;
                            this.checkTransaction();
                        }
                    })
            }
        },
        authentication_3() {
            this.$v.$touch();
            if (this.$v.country.$invalid || this.$v.code_2.$invalid) {
                return;
            } else {
                this.loading = true;
                const url = '/api/skid/auth';
                let data = {
                    authenticationType: 'smart_id',
                    phoneNumber: this.phone,
                    country: this.country,
                    personalCode: this.code_2,
                    identityType: this.identity_type,
                };
                const options = {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem('token')
                    }
                };
                axios.post(url, data, options)
                    .then(response => {
                        if (response.status == 200) {
                            this.transaction_id = response.data.transaction_id;
                            this.checkTransaction();
                        }
                    })
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

    created() {
        RequestsServices.countries().then(response => {
            this.countries_options = response;
        });
    },

    validations: {
        phone: requiredRule,
        country: requiredRule,
        code_1: requiredRule,
        code_2: requiredRule,
    }
}
</script>
