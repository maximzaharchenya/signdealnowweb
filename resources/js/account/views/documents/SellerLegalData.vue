<template>
    <div class="custom-form" :class="{'card--common': !show_for_notary}">

        <div class="card--common__header header-sticky" v-if="!show_for_notary">
            <h3 class="mb-0">Договорной процесс</h3>

            <div class="d-none d-md-block">
                <button class="btn-small btn-v2 mr-3"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
                <button class="btn-small btn-v1" @click="saveData()" v-if="!disabled">
                    <span v-if="edit_page">Сохранить изменения</span>
                    <span v-if="!edit_page">Сохранить</span>
                </button>
            </div>

        </div>

        <div :class="{'card--common__body': !show_for_notary}">
            <p class="mb-20 font-500" v-if="!disabled">Выберите банк продавца:</p>
            <p class="mb-20 font-500" v-if="disabled">Банк продавца:</p>

            <div class="mb-40 row" v-if="!disabled">
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="local_bank = 1"
                            :class="{'btn-filter-active': local_bank == 1}">
                        Местный банк
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="local_bank = 0"
                            :class="{'btn-filter-active': local_bank == 0}">
                        Зарубежный банк
                    </button>
                </div>
            </div>

            <div v-if="disabled" class="row mb-40">
                <div class="col-6">
                    <button class="btn-small btn-filter btn-filter-active no-effects">
                        <span v-if="local_bank == 1">Местный банк</span>
                        <span v-if="local_bank == 0">Зарубежный банк</span>
                    </button>
                </div>

            </div>

            <div class="row mb-40">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_name.$error, 'is-valid': !$v.postData.bank_name.$invalid, 'disabled--item': disabled}">
                        <label for="bank_name">Наименование банка*</label>
                        <input :disabled="disabled" id="bank_name"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_name)"
                               v-model.trim="postData.bank_name">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_number.$error, 'is-valid': !$v.postData.bank_number.$invalid, 'disabled--item': disabled}">
                        <label for="bank_number">Номер банка*</label>
                        <input :disabled="disabled" id="bank_number"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_number)"
                               v-model.trim="postData.bank_number">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_code.$error, 'is-valid': !$v.postData.bank_code.$invalid, 'disabled--item': disabled}">
                        <label for="bank_code">Регистрационный код филиала*</label>
                        <input :disabled="disabled" id="bank_code"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_code)"
                               v-model.trim="postData.bank_code">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.seller_account_number.$error, 'is-valid': !$v.postData.seller_account_number.$invalid, 'disabled--item': disabled}">
                        <label for="seller_account_number">Номер счета*</label>
                        <input :disabled="disabled" id="seller_account_number"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.seller_account_number)"
                               v-model.trim="postData.seller_account_number">
                    </div>
                </div>

                <div class="col-8">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_address.$error, 'is-valid': !$v.postData.bank_address.$invalid, 'disabled--item': disabled}">
                        <label for="bank_address">Адрес банка*</label>
                        <input :disabled="disabled" id="bank_address"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_address)"
                               v-model.trim="postData.bank_address">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_email.$error, 'is-valid': postData.bank_email && !$v.postData.bank_email.$invalid, 'disabled--item': disabled}">
                        <label for="bank_email">Email банка</label>
                        <input :disabled="disabled" id="bank_email"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_email)"
                               v-model.trim="postData.bank_email">
                    </div>
                </div>
            </div>

            <div class="mb-40" v-if="local_bank == 0">
                <hr>

                <p class="mb-20 font-500">Заполните данные о местном филиале зарубежного банка покупателя:</p>

                <div class="row">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.filial_bank_name}">
                            <label for="filial_bank_name">Наименование банка</label>
                            <input :disabled="disabled" id="filial_bank_name"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.filial_bank_name">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.filial_bank_number}">
                            <label for="filial_bank_number">Номер банка</label>
                            <input :disabled="disabled" id="filial_bank_number"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.filial_bank_number">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.filial_bank_code}">
                            <label for="filial_bank_code">Регистрационный код филиала</label>
                            <input :disabled="disabled" id="filial_bank_code"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.filial_bank_code">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.filial_bank_email.$error, 'is-valid': postData.filial_bank_email && !$v.postData.filial_bank_email.$invalid, 'disabled--item': disabled}">
                            <label for="filial_bank_email">Email банка</label>
                            <input :disabled="disabled" id="filial_bank_email"
                                   autocomplete="off"
                                   type="text"
                                   @input="delayTouch($v.postData.filial_bank_email)"
                                   v-model.trim="postData.filial_bank_email">
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.filial_bank_address}">
                            <label for="filial_bank_address">Адрес банка</label>
                            <input :disabled="disabled" id="filial_bank_address"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.filial_bank_address">
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <p class="mb-20 font-500" v-if="!disabled">Заполните данные о представителе банка:</p>
            <p class="mb-20 font-500" v-if="disabled">Данные о представителе банка:</p>

            <div class="row mb-40">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.bank_representative_name}">
                        <label for="bank_representative_name">Имя</label>
                        <input :disabled="disabled" id="bank_representative_name"
                               autocomplete="off"
                               type="text"
                               v-model="postData.bank_representative_name">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.bank_representative_surname}">
                        <label for="bank_representative_surname">Фамилия</label>
                        <input :disabled="disabled" id="bank_representative_surname"
                               autocomplete="off"
                               type="text"
                               v-model="postData.bank_representative_surname">
                    </div>
                </div>

                <div class="col-4" v-if="!disabled">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_representative_personal_code.$error, 'is-valid': postData.bank_representative_personal_code && !$v.postData.bank_representative_personal_code.$invalid, 'disabled--item': disabled}">
                        <label for="bank_representative_personal_code">Личный код</label>
                        <input :disabled="disabled" id="bank_representative_personal_code"
                               autocomplete="off"
                               type="text"
                               v-model="postData.bank_representative_personal_code">
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex flex-wrap align-items-center justify-content-between mb-16">
                <p class="mb-2 font-500">Продаваемый объект находится в залоге:</p>
                <div class="checkbox mb-2" :class="{'disabled--item': disabled}">
                    <input :disabled="disabled" type="checkbox" id="is_pledged"
                           v-model="is_pledged">
                    <label for="is_pledged">Да, находится в залоге</label>
                </div>
            </div>

            <div class="row mb-40" v-if="is_pledged">
                <div class="col-8">
                    <div class="mb-0 form--item" :class="{'disabled--item': disabled}">
                        <label for="investment_return">Сумма возврата инвестиций финансирующей организации</label>
                        <input :disabled="disabled" id="investment_return"
                               autocomplete="off"
                               type="text"
                               v-model="postData.investment_return">
                    </div>
                </div>
            </div>
            <div v-else class="pb-1"></div>

            <hr>

            <p class="mb-20 font-500">Реквизиты держателя ипотеки:</p>

            <div class="row mb-40">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.mortgage_holder_name}">
                        <label for="mortgage_holder_name">Наименование</label>
                        <input :disabled="disabled" id="mortgage_holder_name"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_name">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.mortgage_holder_code}">
                        <label for="mortgage_holder_code">Регистрационный код</label>
                        <input :disabled="disabled" id="mortgage_holder_code"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_code">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item">
                        <label for="mortgage_holder_account_number">Номер счета</label>
                        <input :disabled="disabled" id="mortgage_holder_account_number"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_account_number">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.mortgage_holder_email.$error, 'is-valid': postData.mortgage_holder_email && !$v.postData.mortgage_holder_email.$invalid, 'disabled--item': disabled}">
                        <label for="mortgage_holder_email">Email</label>
                        <input :disabled="disabled" id="mortgage_holder_email"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.mortgage_holder_email)"
                               v-model.trim="postData.mortgage_holder_email">
                    </div>
                </div>

                <div class="col-8">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.mortgage_holder_address}">
                        <label for="mortgage_holder_address">Адрес</label>
                        <input :disabled="disabled" id="mortgage_holder_address"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_address">
                    </div>
                </div>
            </div>


            <hr>

            <p class="mb-20 font-500" v-if="!disabled">Заполните данные о представителе держателя ипотеки:</p>
            <p class="mb-20 font-500" v-if="disabled">Данные о представителе держателя ипотеки:</p>

            <div class="row">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.mortgage_holder_representative_name}">
                        <label for="mortgage_holder_representative_name">Имя</label>
                        <input :disabled="disabled" id="mortgage_holder_representative_name"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_representative_name">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.mortgage_holder_representative_surname}">
                        <label for="mortgage_holder_representative_surname">Фамилия</label>
                        <input :disabled="disabled" id="mortgage_holder_representative_surname"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_representative_surname">
                    </div>
                </div>


                <div class="col-4" v-if="!disabled">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.mortgage_holder_representative_code.$error, 'is-valid': postData.mortgage_holder_representative_code && !$v.postData.mortgage_holder_representative_code.$invalid, 'disabled--item': disabled}">
                        <label for="mortgage_holder_representative_code">Личный код</label>
                        <input :disabled="disabled" id="mortgage_holder_representative_code"
                               autocomplete="off"
                               type="text"
                               v-model="postData.mortgage_holder_representative_code">
                    </div>
                </div>
            </div>

            <div class="d-block d-md-none">
                <button class="btn-small btn-v2 mr-3 w-100"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
            </div>

        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>

        <div class="mobile-footer-btn-container" v-if="!disabled">
            <button class="btn-small btn-v1 w-100" @click="saveData()">
                <span v-if="edit_page">Сохранить изменения</span>
                <span v-if="!edit_page">Сохранить</span>
            </button>
        </div>

    </div>
</template>


<script>
    import {emailRuleNoReq, requiredRule, personalNumberRuleNoReq} from '../../../services/validation';

    const touchMap = new WeakMap();

    export default {
        props: ['deal', 'disabled', 'user_role', 'user_approved', 'show_for_notary'],
        data() {
            return {
                postData: {
                    bank_name: null,
                    bank_number: null,
                    bank_code: null,
                    seller_account_number: null,
                    bank_address: null,
                    bank_email: null,

                    bank_representative_name: null,
                    bank_representative_surname: null,
                    bank_representative_personal_code: null,

                    is_pledged: 0,
                    investment_return: null,

                    mortgage_holder_name: null,
                    mortgage_holder_code: null,
                    mortgage_holder_address: null,
                    mortgage_holder_email: null,
                    mortgage_holder_account_number: null,

                    mortgage_holder_representative_name: null,
                    mortgage_holder_representative_surname: null,
                    mortgage_holder_representative_code: null,

                    filial_bank_name: null,
                    filial_bank_number: null,
                    filial_bank_code: null,
                    filial_bank_email: null,
                    filial_bank_address: null
                },

                local_bank: 1,
                is_pledged: false,

                loading: true,
                edit_page: false

            }
        },

        mounted() {
            this.init();
        },


        methods: {
            init() {

                if (this.deal && this.deal.seller_data) {
                    let data = JSON.parse(this.deal.seller_data);

                    this.postData.bank_name = data.bank_name;
                    this.postData.bank_number = data.bank_number;
                    this.postData.bank_code = data.bank_code;
                    this.postData.seller_account_number = data.seller_account_number;
                    this.postData.bank_address = data.bank_address;
                    this.postData.bank_email = data.bank_email;

                    this.postData.bank_representative_name = data.bank_representative_name;
                    this.postData.bank_representative_surname = data.bank_representative_surname;
                    this.postData.bank_representative_personal_code = data.bank_representative_personal_code;

                    this.postData.investment_return = data.investment_return;

                    this.postData.mortgage_holder_name = data.mortgage_holder_name;
                    this.postData.mortgage_holder_code = data.mortgage_holder_code;
                    this.postData.mortgage_holder_address = data.mortgage_holder_address;
                    this.postData.mortgage_holder_email = data.mortgage_holder_email;
                    this.postData.mortgage_holder_account_number = data.mortgage_holder_account_number;

                    this.postData.mortgage_holder_representative_name = data.mortgage_holder_representative_name;
                    this.postData.mortgage_holder_representative_surname = data.mortgage_holder_representative_surname;
                    this.postData.mortgage_holder_representative_code = data.mortgage_holder_representative_code;

                    this.postData.filial_bank_name = data.filial_bank_name;
                    this.postData.filial_bank_number = data.filial_bank_number;
                    this.postData.filial_bank_code = data.filial_bank_code;
                    this.postData.filial_bank_email = data.filial_bank_email;
                    this.postData.filial_bank_address = data.filial_bank_address;

                    if (data.local_bank == 1) this.local_bank = 1;
                    if (data.local_bank == 0) this.local_bank = 0;

                    if (data.is_pledged == 1) this.is_pledged = 1;
                    if (data.is_pledged == 0) this.is_pledged = 0;

                    this.edit_page = true;

                    this.loading = false;
                } else this.loading = false

                // local_bank: 1,
                //     is_pledged: 0,


            },
            saveData() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: 'Некоторые поля заполнены некорректно'
                    });
                    return;
                } else {
                    this.loading = true;

                    if (!this.postData.investment_return) this.postData.investment_return = 0;

                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    /*if local_bank = 1 - delete data with mortgage_holder*/
                    if (this.local_bank == 1) {
                        formData.delete('filial_bank_name');
                        formData.delete('filial_bank_number');
                        formData.delete('filial_bank_code');
                        formData.delete('filial_bank_email');
                        formData.delete('filial_bank_address');
                    }

                    if (this.is_pledged) formData.append('is_pledged', 1);
                    else formData.append('is_pledged', 0);

                    if (this.local_bank == 1) formData.append('local_bank', 1);
                    else formData.append('local_bank', 0);


                    let url = '/api/deal/' + this.$route.params.id + '/seller_data';
                    const options = {
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };

                    axios.post(url, formData, options)
                        .then(response => {
                            if (response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Данные успешно сохранены.',
                                })
                                this.$emit('init_data', true);
                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }

            },

            approveData() {
                this.$emit('approve_data', true);
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000))
            },
        },

        validations: {
            postData: {
                bank_address: requiredRule,
                bank_name: requiredRule,
                bank_number: requiredRule,
                bank_code: requiredRule,
                bank_representative_personal_code: personalNumberRuleNoReq,
                seller_account_number: requiredRule,

                mortgage_holder_email: emailRuleNoReq,
                mortgage_holder_representative_code: personalNumberRuleNoReq,
                bank_email: emailRuleNoReq,
                filial_bank_email: emailRuleNoReq,
            },

        }
    }
</script>
