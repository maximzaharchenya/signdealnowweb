<template>
    <div v-if="item">

        <div class="d-flex justify-content-between align-items-center mb-20">
            <p class="font-500 mb-0" v-if="disabled">Данные участника сделки:</p>
            <p class="font-500 mb-0" v-if="!disabled">Редактирование данных участника:</p>

            <div class="d-flex" v-if="user_role == 1 || user_role == 2">
                <div v-if="disabled" @click="disabled = false" class="cursor-pointer">
                    <img src="/svg/action_edit.svg" alt="">
                </div>
                <div v-if="!disabled" class="cursor-pointer" @click="saveItem()"><img src="/svg/action_save.svg" alt="">
                </div>

                <div @click="deleteItem(item)" class="cursor-pointer"><img src="/svg/action_delete.svg" alt=""></div>
            </div>
        </div>


        <div class="mb-40 row" v-if="!disabled">
            <div class="col-6">

                <button class="btn-small btn-filter"
                        @click="person = true"
                        :class="{'btn-filter-active': person}">
                    Физическое лицо
                </button>
            </div>
            <div class="col-6">
                <button class="btn-small btn-filter"
                        @click="person = false"
                        :class="{'btn-filter-active': !person}">
                    Юридическое лицо
                </button>
            </div>
        </div>

        <div class="mb-40 row" v-if="disabled">
            <div class="col-6">
                <button class="btn-small btn-filter btn-filter-active no-effects">
                    <span v-if="person">Физическое лицо</span>
                    <span v-if="!person">Юридическое лицо</span>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.role.$error, 'is-valid': !$v.postData.role.$invalid, 'disabled--item': disabled}">
                    <label>Роль*</label>
                    <multiselect v-model.trim="postData.role"
                                 :options="type_options"
                                 :allow-empty="false"
                                 :searchable="false"
                                 deselect-label=""
                                 placeholder=""
                                 selected-label=""
                                 select-label=""
                                 label="title"
                                 track-by="title"
                                 :id="'type' + item.id" id="type"
                                 :disabled="disabled"
                    ></multiselect>
                </div>
            </div>

            <div class="col-4" v-if="person">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.name.$error, 'is-valid': !$v.postData.name.$invalid, 'disabled--item': disabled}">
                    <label :for="'name' + item.id">Имя*</label>
                    <input :id="'name' + item.id"
                           v-model.trim="postData.name"
                           @input="delayTouch($v.postData.name)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-4" v-if="person">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.surname.$error, 'is-valid': !$v.postData.surname.$invalid, 'disabled--item': disabled}">
                    <label :for="'surname' + item.id">Фамилия*</label>
                    <input :id="'surname' + item.id"
                           v-model.trim="postData.surname"
                           @input="delayTouch($v.postData.surname)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-4" v-if="person">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.date_of_birth.$error, 'is-valid': !$v.date_of_birth.$invalid, 'disabled--item': disabled}">
                    <label :for="'date_of_birth' + item.id">Дата рождения*</label>
                    <input :id="'date_of_birth' + item.id"
                           placeholder="##.##.####"
                           v-mask="'##.##.####'"
                           v-model.trim="date_of_birth"
                           @input="delayTouch($v.date_of_birth)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-8" v-if="!person">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.commercial_name.$error, 'is-valid': !$v.postData.commercial_name.$invalid, 'disabled--item': disabled}">
                    <label :for="'commercial_name' + item.id">Наименование коммерческого товарищества*</label>
                    <input :id="'commercial_name' + item.id"
                           v-model.trim="postData.commercial_name"
                           @input="delayTouch($v.postData.commercial_name)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-4" v-if="!person">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.commercial_code.$error, 'is-valid': !$v.postData.commercial_code.$invalid, 'disabled--item': disabled}">
                    <label :for="'commercial_code' + item.id">Код коммерческого регистра*</label>
                    <input :id="'commercial_code' + item.id"
                           v-model.trim="postData.commercial_code"
                           @input="delayTouch($v.postData.commercial_code)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.email.$error, 'is-valid': !$v.postData.email.$invalid, 'disabled--item': disabled}">
                    <label :for="'email' + item.id">Email*</label>
                    <input :id="'email' + item.id"
                           v-model.trim="postData.email"
                           @input="delayTouch($v.postData.email)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-4" v-if="person">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.personal_number.$error, 'is-valid': !$v.postData.personal_number.$invalid, 'disabled--item': disabled}">
                    <label :for="'personal_number' + item.id">Личный код*</label>
                    <input :id="'personal_number' + item.id"
                           v-model.trim="postData.personal_number"
                           @input="delayTouch($v.postData.personal_number)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>

            <div class="col-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible, 'disabled--item': disabled}">
                    <label :for="'phone' + item.id">Телефон*</label>
                    <vue-tel-input :id="'phone' + item.id"
                                   autocomplete="off"
                                   type="text"
                                   v-model.trim="postData.phone"
                                   @input="delayTouch($v.postData.phone)"
                                   :inputOptions="inputOptions"
                                   :mode="mode"
                                   @validate="telValidate"
                                   @blur="blur"
                                   :disabled="disabled"
                                   :validCharactersOnly="validCharactersOnly"
                    ></vue-tel-input>
                </div>
            </div>

            <div class="col-4">
                <div class="mb-20 form--item"
                     v-if="countries_options"
                     :class="{'is-invalid': $v.postData.country.$error, 'is-valid': !$v.postData.country.$invalid, 'disabled--item': disabled}">
                    <label>Страна*</label>
                    <multiselect v-model="postData.country"
                                 :options="countries_options"
                                 :allow-empty="false"
                                 :searchable="true"
                                 deselect-label=""
                                 placeholder=""
                                 selected-label=""
                                 select-label=""
                                 :disabled="disabled"
                    ><span slot="noResult">Совпадений не найдено</span></multiselect>
                </div>
            </div>

            <div class="col-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.city.$error, 'is-valid': !$v.postData.city.$invalid, 'disabled--item': disabled}">
                    <label>Город*</label>
                    <input v-model.trim="postData.city"
                           @input="delayTouch($v.postData.city)"
                           :disabled="disabled"
                           autocomplete="off"
                           type="text">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.address.$error, 'is-valid': !$v.postData.address.$invalid, 'disabled--item': disabled}">
                    <label :for="'address' + item.id">Точный адрес (улица, дом, квартира)*</label>
                    <input :id="'address' + item.id"
                           v-model.trim="postData.address"
                           @input="delayTouch($v.postData.address)"
                           autocomplete="off"
                           :disabled="disabled"
                           type="text">
                </div>
            </div>
        </div>

        <div v-if="!person">
            <hr>
            <p class="mb-20 font-500">Представитель и его данные:</p>

            <div class="mb-40 row" v-if="!disabled">
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="postData.representative = 1"
                            :class="{'btn-filter-active': postData.representative == 1}">
                        Законный представитель
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="postData.representative = 2"
                            :class="{'btn-filter-active': postData.representative == 2}">
                        Доверенное лицо
                    </button>
                </div>
            </div>

            <div class="mb-40 row" v-if="disabled">
                <div class="col-6">
                    <button class="btn-small btn-filter btn-filter-active no-effects">
                        <span v-if="postData.representative == 1">Законный представитель</span>
                        <span v-if="postData.representative == 2">Доверенное лицо</span>
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-valid': postData.representative_name, 'disabled--item': disabled}">
                        <label :for="'representative_name' + item.id">Имя</label>
                        <input :id="'representative_name' + item.id"
                               v-model="postData.representative_name"
                               autocomplete="off"
                               :disabled="disabled"
                               type="text">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-valid': postData.representative_surname, 'disabled--item': disabled}">
                        <label :for="'representative_surname' + item.id">Фамилия</label>
                        <input :id="'representative_surname' + item.id"
                               v-model="postData.representative_surname"
                               autocomplete="off"
                               :disabled="disabled"
                               type="text">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-valid': representative_date_of_birth, 'disabled--item': disabled}">
                        <label :for="'representative_date_of_birth' + item.id">Дата рождения</label>
                        <input :id="'representative_date_of_birth' + item.id"
                               placeholder="##.##.####"
                               v-mask="'##.##.####'"
                               :disabled="disabled"
                               v-model="representative_date_of_birth"
                               autocomplete="off"
                               type="text">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-valid': postData.representative_email, 'disabled--item': disabled}">
                        <label :for="'representative_email' + item.id">Email</label>
                        <input :id="'representative_email' + item.id"
                               :disabled="disabled"
                               v-model="postData.representative_email"
                               autocomplete="off"
                               type="text">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-valid': postData.representative_personal_number, 'disabled--item': disabled}">
                        <label :for="'representative_personal_number' + item.id">Личный код</label>
                        <input :id="'representative_personal_number' + item.id"
                               :disabled="disabled"
                               v-model="postData.representative_personal_number"
                               autocomplete="off"
                               type="text">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': phoneValid_representative && possible_representative, 'is-valid': phoneValid_representative && !possible_representative, 'disabled--item': disabled}">
                        <label>Телефон</label>
                        <vue-tel-input autocomplete="off"
                                       type="text"
                                       v-model="postData.representative_phone"
                                       :inputOptions="inputOptions"
                                       :mode="mode"
                                       @validate="telValidate_representative"
                                       @blur="blur_representative"
                                       :disabled="disabled"
                                       :validCharactersOnly="validCharactersOnly"
                        ></vue-tel-input>
                    </div>
                </div>

                <div class="col-4" v-if="!disabled">
                    <div class="mb-20 form--item image-loader">
                        <label :for="'representative_power_of_attorney' + item.id">Доверенность (скан PDF или asics)</label>
                        <b-form-file
                            :id="'representative_power_of_attorney' + item.id"
                            v-model="postData.representative_file"
                            placeholder="Файл не выбран"
                            drop-placeholder="Перетащите файл сюда"
                        ></b-form-file>

                    </div>
                </div>

                <div class="col-4" v-if="disabled">
                    <div class="color-text-grey">
                        Доверенность (скан PDF или asics):
                        <span v-if="postData.representative_file">загружено</span>
                        <span v-if="!postData.representative_file">не загружено</span>
                    </div>
                </div>


            </div>
        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>

    </div>
</template>

<script>
    import {
        requiredRule,
        emailRule,
        birthRule,
        birthRuleNoReq,
        emailRuleNoReq,
        noValid
    } from '../../../../services/validation';

    const touchMap = new WeakMap();

    import {VueTelInput} from 'vue-tel-input';
    import Multiselect from 'vue-multiselect';

    import RequestsServices from '../../../../services/requests';
    import {echoDate} from '../../../../services/functions';

    export default {
        components: {
            Multiselect,
            VueTelInput
        },

        props: ['item', 'user_role'],
        data() {
            return {
                disabled: true,
                postData: {
                    person: null,
                    role: null,
                    name: null,
                    surname: null,
                    email: null,
                    date_of_birth: null,
                    personal_number: null,
                    phone: null,
                    country: null,
                    city: null,
                    address: null,

                    commercial_code: null,
                    commercial_name: null,

                    representative: 1,
                    representative_name: null,
                    representative_surname: null,
                    representative_date_of_birth: null,
                    representative_email: null,
                    representative_personal_number: null,
                    representative_phone: null,
                    representative_file: null,
                },
                person: true,
                date_of_birth: null,
                representative_date_of_birth: null,

                type_options: [
                    {id: 2, title: 'Покупатель'},
                    // {id: 2, title: 'Продавец'},
                    {id: 4, title: 'Юрист-консультант'},
                    {id: 5, title: 'Переводчик'},
                    {id: 6, title: 'Супруг/Супруга покупателя'},
                    {id: 7, title: 'Cупруг/Супруга продавца'},
                    {id: 8, title: 'Ассистент нотариуса'},
                    {id: 9, title: 'Представитель банка продавца'},
                    {id: 10, title: 'Представитель банка покупателя'},
                    {id: 11, title: 'Совладелец'},
                    {id: 12, title: 'Представитель Юр.Лица'}
                ],
                countries_options: null,

                /*data for vue-tel-input*/
                dynamicPlaceholder: true,
                validCharactersOnly: true,
                enabledCountryCode: false,
                inputOptions: {
                    showDialCode: false,
                },
                mode: 'international',

                phoneValid: '',
                phoneValid_representative: true,

                possible: '',
                possible_representative: '',
                /**/
                loading: true,
            }
        },

        created() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });
        },

        watch: {
            item() {
                this.init();
            }
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                if (this.item) {
                    this.loading = true;

                    if(this.item.person == 1) this.person = true;
                    if(this.item.person == 0) this.person = false;

                    if (this.item.role == 2) this.postData.role = {id: 2, title: 'Покупатель'};
                    if (this.item.role == 4) this.postData.role = {id: 4, title: 'Юрист-консультант'};
                    if (this.item.role == 5) this.postData.role = {id: 5, title: 'Переводчик'};
                    if (this.item.role == 6) this.postData.role = {id: 6, title: 'Супруг/Супруга покупателя'};
                    if (this.item.role == 7) this.postData.role = {id: 7, title: 'Cупруг/Супруга продавца'};
                    if (this.item.role == 8) this.postData.role = {id: 8, title: 'Ассистент нотариуса'};
                    if (this.item.role == 9) this.postData.role = {id: 9, title: 'Представитель банка продавца'};
                    if (this.item.role == 10) this.postData.role = {id: 10, title: 'Представитель банка покупателя'};
                    if (this.item.role == 11) this.postData.role = {id: 11, title: 'Совладелец'};
                    if (this.item.role == 12) this.postData.role = {id: 12, title: 'Представитель Юр.Лица'};


                    this.postData.name = this.item.name;
                    this.postData.surname = this.item.surname;
                    this.postData.email = this.item.email;
                    this.date_of_birth =  this.checkDate(this.item.date_of_birth);
                    this.postData.personal_number = this.item.personal_number;
                    this.postData.phone = this.item.phone;
                    this.postData.country = this.item.country;
                    this.postData.city = this.item.city;
                    this.postData.address = this.item.address;

                    this.postData.commercial_code = this.item.commercial_code;
                    this.postData.commercial_name = this.item.commercial_name;


                    this.postData.representative = this.item.representative;
                    this.postData.representative_name = this.item.representative_name;
                    this.postData.representative_surname = this.item.representative_surname;
                    if(this.item.representative_date_of_birth) this.representative_date_of_birth = this.checkDate(this.item.representative_date_of_birth);
                    this.postData.representative_email = this.item.representative_email;
                    this.postData.representative_personal_number = this.item.representative_personal_number;
                    this.postData.representative_phone = this.item.representative_phone;
                    this.postData.representative_file = this.item.representative_file;

                    this.loading = false;

                }
            },

            saveItem() {
                this.$v.$touch();

                let valid = false;

                if (this.person) {
                    if (this.$v.$invalid || !this.phoneValid) {
                        if (!this.phoneValid) this.possible = true;
                        Swal.fire({
                            icon: 'error',
                            title: 'Внимание',
                            html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`,
                        });
                        return;
                    } else {
                        valid = true;
                    }
                }

                if (!this.person) {
                    if (this.$v.$invalid || !this.phoneValid || (this.postData.representative_phone && !this.phoneValid_representative)) {
                        if (!this.phoneValid) this.possible = true;
                        if (!this.phoneValid_representative) this.possible_representative = true;
                        Swal.fire({
                            icon: 'error',
                            title: 'Внимание',
                            html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`,
                        });
                        return;
                    } else {
                        valid = true;
                    }
                }

                if (valid) {
                    this.loading = true;

                    this.postData.role = this.postData.role.id;

                    if(this.date_of_birth) this.postData.date_of_birth = this.date_of_birth.split('.').reverse().join('-');
                    if(this.representative_date_of_birth) this.postData.representative_date_of_birth = this.representative_date_of_birth.split('.').reverse().join('-');

                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    if(this.person) formData.append('person', 1);
                    else formData.append('person', 0);


                    let url = '/api/deal/' + this.$route.params.id + '/contributors_data/' + this.item.id;
                    const options = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            Authorization: "Bearer " + localStorage.getItem('token')
                        }
                    };

                    axios.post(url, formData, options)
                        .then(response => {
                            if (response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Информация успешно сохранена'
                                }).then(() => {
                                    this.disabled = true;
                                    this.$emit('init_data', true);
                                })
                            }
                        })
                        .finally(() => {
                            this.loading = false
                        })
                }

            },

            deleteItem(item) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Внимание',
                    html: 'Вы уверены, что хотите удалить участника?',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    confirmButtonText: `Удалить`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '/api/deal/' + this.$route.params.id + '/contributors_data/' + item.id + '/delete';
                        const options = {
                            headers: {Authorization: "Bearer " + localStorage.getItem('token')},
                            params: {
                                contributor_id: item.id
                            }
                        };

                        axios.get(url, options)
                            .then(response => {
                                if (response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Готово',
                                        html: 'Информация об участнике удалена.'
                                    }).then(() => {
                                        this.$emit('init_data', true);
                                    })
                                }
                            })
                            .finally(() => {
                                this.loading = false
                            })
                    }
                })


            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000));
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

            telValidate_representative(number, isValid, country) {
                this.phoneValid_representative = number.valid;
                this.possible_representative = number.possible;
            },
            blur_representative() {
                if (this.phoneValid_representative == false) {
                    this.possible_representative = true;
                }
            },
            checkDate(date) {
                return echoDate(date);
            }
        },

        validations() {
            if (this.person) {
                return {
                    postData: {
                        role: requiredRule,
                        name: requiredRule,
                        surname: requiredRule,
                        email: emailRule,
                        personal_number: requiredRule,
                        phone: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,

                        commercial_code: noValid,
                        commercial_name: noValid,

                        representative: requiredRule,
                        representative_email: emailRuleNoReq,
                    },
                    date_of_birth: birthRule,
                    representative_date_of_birth: birthRuleNoReq,
                }
            }

            if (!this.person) {
                return {
                    postData: {
                        role: requiredRule,
                        email: emailRule,
                        phone: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,

                        commercial_code: requiredRule,
                        commercial_name: requiredRule,

                        name: noValid,
                        surname: noValid,
                        personal_number: noValid,

                        representative: requiredRule,
                        representative_email: emailRuleNoReq,
                    },
                    date_of_birth: birthRuleNoReq,
                    representative_date_of_birth: birthRuleNoReq,

                }
            }
        }
    }
</script>
