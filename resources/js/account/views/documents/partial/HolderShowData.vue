<template>
    <div>
        <div class="mb-40">
            <hr>

            <div>
                <div class="d-flex align-items-center justify-content-between mb-20">
                    <p class="mb-0 font-500" v-if="!disabled_item">Выберите банк залогодержателя
                        <span class="font-400" v-if="mortgages_id.length < 1">(залоговая недвижимость - {{postData.mortgage_type}}, {{postData.mortgage_address}}) </span>
                        и введите
                        его данные:</p>
                    <p class="mb-0 font-500" v-if="disabled_item">Банк залогодержателя
                        <span class="font-400" v-if="mortgages_id.length < 1">(залоговая недвижимость - {{postData.mortgage_type}}, {{postData.mortgage_address}}) </span>
                        и его данные:</p>

                    <div class="d-flex" v-if="user_id == user.id">
                        <div v-if="disabled_item" @click="disabled_item = false" class="cursor-pointer">
                            <img src="/svg/action_edit.svg" alt="">
                        </div>
                        <div v-if="!disabled_item" class="cursor-pointer" @click="saveItem()">
                            <img src="/svg/action_save.svg" alt="">
                        </div>

                        <div @click="deleteItem()" class="cursor-pointer"><img src="/svg/action_delete.svg" alt=""></div>
                    </div>
                </div>


                <div class="mb-40 row" v-if="!disabled_item">
                    <div class="col-6">
                        <button class="btn-small btn-filter"
                                @click="postData.mortgage_holder_local_bank = 1"
                                :class="{'btn-filter-active': postData.mortgage_holder_local_bank == 1}">
                            Местный банк
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn-small btn-filter"
                                @click="postData.mortgage_holder_local_bank = 0"
                                :class="{'btn-filter-active': postData.mortgage_holder_local_bank == 0}">
                            Зарубежный банк
                        </button>
                    </div>
                </div>

                <div class="mb-40" v-if="disabled_item">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn-small btn-filter btn-filter-active no-effects">
                                <span v-if="postData.mortgage_holder_local_bank == 1">Местный банк</span>
                                <span v-if="postData.mortgage_holder_local_bank == 0">Зарубежный банк</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.mortgage_holder_name.$error, 'is-valid': !$v.postData.mortgage_holder_name.$invalid}">
                            <label :for="'mortgage_holder_name' + data.id">Имя банка*</label>
                            <input :id="'mortgage_holder_name' + data.id"
                                   :disabled="disabled_item"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_name"
                                   @input="delayTouch($v.postData.mortgage_holder_name)">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.mortgage_holder_number.$error, 'is-valid': !$v.postData.mortgage_holder_number.$invalid}">
                            <label :for="'mortgage_holder_number' + data.id">Номер банка*</label>
                            <input :id="'mortgage_holder_number' + data.id"
                                   :disabled="disabled_item"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_number"
                                   @input="delayTouch($v.postData.mortgage_holder_number)">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.mortgage_holder_code.$error, 'is-valid': postData.mortgage_holder_code && !$v.postData.mortgage_holder_code.$invalid}">
                            <label :for="'mortgage_holder_code' + data.id">Регистрационный код
                                филиала</label>
                            <input :id="'mortgage_holder_code' + data.id"
                                   :disabled="disabled_item"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_code"
                                   @input="delayTouch($v.postData.mortgage_holder_code)">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.mortgage_holder_email.$error, 'is-valid': postData.mortgage_holder_email && !$v.postData.mortgage_holder_email.$invalid}">
                            <label :for="'mortgage_holder_email' + data.id">Email банка</label>
                            <input :id="'mortgage_holder_email' + data.id" :disabled="disabled_item"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_email"
                                   @input="delayTouch($v.postData.mortgage_holder_email)">
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.mortgage_holder_address.$error, 'is-valid': !$v.postData.mortgage_holder_address.$invalid}">
                            <label :for="'mortgage_holder_address' + data.id">Адрес банка*</label>
                            <input :id="'mortgage_holder_address' + data.id"
                                   :disabled="disabled_item"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_address"
                                   @input="delayTouch($v.postData.mortgage_holder_address)">
                        </div>
                    </div>

                    <div class="col-4">

                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.additional_collateral_cost.$error, 'is-valid': postData.additional_collateral_cost && !$v.postData.additional_collateral_cost.$invalid}">
                            <label :for="'additional_collateral_cost' + data.id">Стоимость
                                дополнительного залога</label>
                            <input :id="'additional_collateral_cost' + data.id"
                                   :disabled="disabled_item"
                                   id="additional_collateral_cost"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.additional_collateral_cost"
                                   @input="delayTouch($v.postData.additional_collateral_cost)">
                        </div>
                    </div>
                </div>


                <div v-if="postData.mortgage_holder_local_bank == 0" class="mb-40">
                    <hr>

                    <p class="mb-20 font-500" v-if="!disabled_item">
                        Заполните данные о местном филиале зарубежного банка залогодержателя:</p>
                    <p class="mb-20 font-500" v-if="disabled_item">
                        Данные о местном филиале зарубежного банка залогодержателя:</p>

                    <div class="row">
                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'disabled--item': disabled_item, 'is-valid': postData.mortgage_holder_representative_bank_name && !$v.postData.mortgage_holder_representative_bank_name.$invalid}">
                                <label :for="'mortgage_holder_representative_bank_name' + data.id">Имя банка</label>
                                <input :id="'mortgage_holder_representative_bank_name' + data.id"
                                       :disabled="disabled_item"
                                       autocomplete="off"
                                       type="text"
                                       v-model.trim="postData.mortgage_holder_representative_bank_name"
                                       @input="delayTouch($v.postData.mortgage_holder_representative_bank_name)">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'disabled--item': disabled_item, 'is-valid': postData.mortgage_holder_representative_bank_number && !$v.postData.mortgage_holder_representative_bank_number.$invalid}">
                                <label :for="'mortgage_holder_representative_bank_number' + data.id">Номер банка</label>
                                <input :id="'mortgage_holder_representative_bank_number' + data.id"
                                       :disabled="disabled_item"
                                       autocomplete="off"
                                       type="text"
                                       v-model.trim="postData.mortgage_holder_representative_bank_number"
                                       @input="delayTouch($v.postData.mortgage_holder_representative_bank_number)">
                            </div>
                        </div>

                        <div class="col-4"></div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.mortgage_holder_representative_bank_email.$error, 'is-valid': postData.mortgage_holder_representative_bank_email && !$v.postData.mortgage_holder_representative_bank_email.$invalid}">
                                <label :for="'mortgage_holder_representative_bank_email' + data.id">Email банка</label>
                                <input :id="'mortgage_holder_representative_bank_email' + data.id"
                                       :disabled="disabled_item"
                                       autocomplete="off"
                                       type="text"
                                       v-model.trim="postData.mortgage_holder_representative_bank_email"
                                       @input="delayTouch($v.postData.mortgage_holder_representative_bank_email)">
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="mb-20 form--item"
                                 :class="{'disabled--item': disabled_item, 'is-valid': postData.mortgage_holder_representative_bank_address && !$v.postData.mortgage_holder_representative_bank_address.$invalid}">
                                <label :for="'mortgage_holder_representative_bank_address' + data.id">Адрес банка</label>
                                <input :id="'mortgage_holder_representative_bank_address' + data.id"
                                       :disabled="disabled_item"
                                       autocomplete="off"
                                       type="text"
                                       v-model.trim="postData.mortgage_holder_representative_bank_address"
                                       @input="delayTouch($v.postData.mortgage_holder_representative_bank_address)">
                            </div>
                        </div>

                    </div>
                </div>

                <p class="mb-20 font-500" v-if="!disabled_item">
                    <span v-if="postData.mortgage_holder_local_bank == 1">Заполните данные о представителе местного банка залогодержателя:</span>
                    <span v-if="postData.mortgage_holder_local_bank == 0">Заполните данные о представителе местного филиала зарубежного банка залогодержателя:</span>
                </p>
                <p class="mb-20 font-500" v-if="disabled_item">
                    Данные о представителе местного банка залогодержателя:
                </p>

                <div class="row">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-valid': postData.mortgage_holder_representative_name && !$v.postData.mortgage_holder_representative_name.$invalid}">
                            <label :for="'mortgage_holder_representative_name' + data.id">Имя</label>
                            <input :disabled="disabled_item"
                                   :id="'mortgage_holder_representative_name' + data.id"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_representative_name"
                                   @input="delayTouch($v.postData.mortgage_holder_representative_name)">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-valid': postData.mortgage_holder_representative_surname && !$v.postData.mortgage_holder_representative_surname.$invalid}">
                            <label :for="'mortgage_holder_representative_surname' + data.id">Фамилия</label>
                            <input :disabled="disabled_item"
                                   :id="'mortgage_holder_representative_surname' + data.id"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_representative_surname"
                                   @input="delayTouch($v.postData.mortgage_holder_representative_surname)">
                        </div>
                    </div>

                    <div class="col-4" v-if="user_id == user.id">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled_item, 'is-valid': postData.mortgage_holder_representative_code && !$v.postData.mortgage_holder_representative_code.$invalid}">
                            <label :for="'mortgage_holder_representative_code' + data.id">
                                Личный код</label>
                            <input :disabled="disabled_item"
                                   :id="'mortgage_holder_representative_code' + data.id"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.mortgage_holder_representative_code"
                                   @input="delayTouch($v.postData.mortgage_holder_representative_code)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import {emailRuleNoReq, requiredRule, onlyNumRuleNoReq, noValid} from '../../../../services/validation';

    const touchMap = new WeakMap();

    import RequestsServices from '../../../../services/requests';

    export default {
        props: ['data', 'user_id', 'mortgages_id'],
        data() {
            return {

                postData: {
                    mortgage_holder_local_bank: null,
                    mortgage_holder_name: null,
                    mortgage_holder_number: null,
                    mortgage_holder_code: null,
                    mortgage_holder_email: null,
                    mortgage_holder_address: null,
                    additional_collateral_cost: null,

                    mortgage_holder_representative_name: null,
                    mortgage_holder_representative_surname: null,
                    mortgage_holder_representative_code: null,
                    mortgage_holder_representative_bank_name: null,
                    mortgage_holder_representative_bank_number: null,
                    mortgage_holder_representative_bank_email: null,
                    mortgage_holder_representative_bank_address: null,

                    mortgage_id: null,
                    mortgage_address: null,
                    mortgage_type: null,
                },

                disabled_item: true

            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        watch: {
            data() {
                this.init();
            }
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                if(this.data) {
                    let data = this.data;

                    this.postData.mortgage_holder_local_bank = data.mortgage_holder_local_bank;
                    this.postData.mortgage_holder_name = data.mortgage_holder_name;
                    this.postData.mortgage_holder_number = data.mortgage_holder_number;
                    this.postData.mortgage_holder_code = data.mortgage_holder_code;
                    this.postData.mortgage_holder_email = data.mortgage_holder_email;
                    this.postData.mortgage_holder_address = data.mortgage_holder_address;
                    this.postData.additional_collateral_cost = data.additional_collateral_cost;

                    this.postData.mortgage_holder_representative_name = data.mortgage_holder_representative_name;
                    this.postData.mortgage_holder_representative_surname = data.mortgage_holder_representative_surname;
                    this.postData.mortgage_holder_representative_code = data.mortgage_holder_representative_code;
                    this.postData.mortgage_holder_representative_bank_name = data.mortgage_holder_representative_bank_name;
                    this.postData.mortgage_holder_representative_bank_number = data.mortgage_holder_representative_bank_number;
                    this.postData.mortgage_holder_representative_bank_email = data.mortgage_holder_representative_bank_email;
                    this.postData.mortgage_holder_representative_bank_address = data.mortgage_holder_representative_bank_address;

                    this.postData.mortgage_id = data.mortgage_id;
                    this.postData.mortgage_address = data.mortgage_address;
                    this.postData.mortgage_type = data.mortgage_type;
                }

            },

            saveItem() {
                if(this.mortgages_id && this.mortgages_id.length > 0) {
                    this.mortgages_id.forEach(item => {
                        this.postSaveData(item.id)
                    })
                }

                else this.postSaveData(this.postData.mortgage_id)
            },

            postSaveData(mortgage_id) {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`
                    });
                    return;
                }

                else {
                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    let url = '/api/deal/' + this.$route.params.id + '/mortgage/' + mortgage_id + '/holder_data';
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
                                this.disabled_item = true;
                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }
            },

            deleteItem() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Внимание',
                    html: 'Вы уверены, что хотите удалить запись?',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    confirmButtonText: `Удалить`,
                }).then((result) => {
                        if (result.isConfirmed) {
                            if(this.mortgages_id && this.mortgages_id.length > 0) {
                                this.mortgages_id.forEach(item => {
                                    this.postDeleteData(item.id)
                                })
                            }
                            else this.postDeleteData(this.postData.mortgage_id)
                        }})
            },

            postDeleteData(mortgage_id) {
                let url = '/api/deal/' + this.$route.params.id + '/mortgage/' + mortgage_id + '/holder_data/delete';

                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')},
                };

                axios.get(url, options)
                    .then(response => {
                        if (response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Информация о залогодержателе удалена.'
                            }).then(() => {
                                this.$emit('init_data', true);
                            })
                        }
                    })
                    .finally(() => {
                        this.loading = false
                    })

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
                mortgage_holder_local_bank: requiredRule,
                mortgage_holder_name: requiredRule,
                mortgage_holder_number: requiredRule,
                mortgage_holder_address: requiredRule,

                mortgage_holder_code: onlyNumRuleNoReq,
                mortgage_holder_email: emailRuleNoReq,

                additional_collateral_cost: onlyNumRuleNoReq,

                mortgage_holder_representative_name: noValid,
                mortgage_holder_representative_surname: noValid,
                mortgage_holder_representative_code: noValid,
                mortgage_holder_representative_bank_name: noValid,
                mortgage_holder_representative_bank_number: noValid,
                mortgage_holder_representative_bank_email: emailRuleNoReq,
                mortgage_holder_representative_bank_address: noValid,
            },
        }

    }
</script>
