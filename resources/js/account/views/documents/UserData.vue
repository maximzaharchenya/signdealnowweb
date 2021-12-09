<template>
    <div class="card--common custom-form h-100-vh">
        <div class="card--common__header header-sticky">
            <h3 class="mb-0">Договорной процесс</h3>

            <div class="d-none d-md-block">
                <button class="btn-small btn-v2 mr-3"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
                <button class="btn-small btn-v1" @click="saveData()">Сохранить</button>
            </div>

        </div>

        <div class="card--common__body">


            <div v-if="contributors && contributors.length > 0" v-for="item in contributors" class="mb-40">
                <contributors-data @init_data="initDealData" :item="item" :user_role="user_role"></contributors-data>
                <hr>
            </div>


            <div v-for="(item, i) in $v.postData.$each.$iter" :key="i" class="mb-40" v-if="postData && postData.length > 0">
                <div class="mb-20 d-flex align-items-center justify-content-between">
                    <p class="font-500 mb-0">Выберите, какого участника вы хотите добавить и заполните данные:</p>
                    <div v-if="i > 0">
                        <span class="cursor-pointer color-text-primary text-underline" @click="cancelItem(i)">отменить</span>
                    </div>
                </div>


                <div class="mb-40 row">
                    <div class="col-6">

                        <button class="btn-small btn-filter"
                                @click="item.person.$model = true"
                                :class="{'btn-filter-active': item.person.$model}">
                            Физическое лицо
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn-small btn-filter"
                                @click="item.person.$model = false"
                                :class="{'btn-filter-active': !item.person.$model}">
                            Юридическое лицо
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.role.$error, 'is-valid': !item.role.$invalid}">
                            <label for="type">Роль*</label>
                            <multiselect v-model.trim="item.role.$model"
                                         :options="type_options"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         placeholder=""
                                         selected-label=""
                                         select-label=""
                                         label="title"
                                         track-by="title"
                                         id="type"
                            ></multiselect>
                        </div>
                    </div>

                    <div class="col-4" v-if="item.person.$model">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.name.$error, 'is-valid': !item.name.$invalid}">
                            <label :for="item.index.$model + '_name'">Имя*</label>
                            <input :id="item.index.$model + '_name'"
                                   v-model.trim="item.name.$model"
                                   @input="delayTouch(item.name)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4" v-if="item.person.$model">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.surname.$error, 'is-valid': !item.surname.$invalid}">
                            <label :for="item.index.$model + '_surname'">Фамилия*</label>
                            <input :id="item.index.$model + '_surname'"
                                   v-model.trim="item.surname.$model"
                                   @input="delayTouch(item.surname)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4" v-if="item.person.$model">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.date_of_birth.$error, 'is-valid': !item.date_of_birth.$invalid}">
                            <label :for="item.index.$model + '_date_of_birth'">Дата рождения*</label>
                            <input :id="item.index.$model + '_date_of_birth'"
                                   placeholder="##.##.####"
                                   v-mask="'##.##.####'"
                                   v-model.trim="item.date_of_birth.$model"
                                   @input="delayTouch(item.date_of_birth)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>


                    <div class="col-8" v-if="!item.person.$model">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.commercial_name.$error, 'is-valid': !item.commercial_name.$invalid}">
                            <label :for="item.index.$model + '_commercial_name'">Наименование коммерческого
                                товарищества*</label>
                            <input :id="item.index.$model + '_commercial_name'"
                                   v-model.trim="item.commercial_name.$model"
                                   @input="delayTouch(item.commercial_name)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4" v-if="!item.person.$model">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.commercial_code.$error, 'is-valid': !item.commercial_code.$invalid}">
                            <label :for="item.index.$model + '_commercial_code'">Код коммерческого регистра*</label>
                            <input :id="item.index.$model + '_commercial_code'"
                                   v-model.trim="item.commercial_code.$model"
                                   @input="delayTouch(item.commercial_code)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.email.$error, 'is-valid': !item.email.$invalid}">
                            <label :for="item.index.$model + '_email'">Email*</label>
                            <input :id="item.index.$model + '_email'"
                                   v-model.trim="item.email.$model"
                                   @input="delayTouch(item.email)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4" v-if="item.person.$model">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.personal_number.$error, 'is-valid': !item.personal_number.$invalid}">
                            <label :for="item.index.$model + '_personal_number'">Личный код*</label>
                            <input :id="item.index.$model + '_personal_number'"
                                   v-model.trim="item.personal_number.$model"
                                   @input="delayTouch(item.personal_number)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': !item.phone_valid.$model && item.phone_blur.$model, 'is-valid': item.phone_valid.$model && !item.phone.$invalid}">
                            <label>Телефон*</label>
                            <vue-tel-input autocomplete="off"
                                           type="text"
                                           v-model.trim="item.phone.$model"
                                           @input="phoneValid(item.phone.$model, 1, item.index.$model)"
                                           :inputOptions="inputOptions"
                                           :mode="mode"
                                           @blur="blur(1, item.index.$model)"
                                           @validate="telValidate"
                                           :validCharactersOnly="validCharactersOnly"
                            ></vue-tel-input>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item" v-if="countries_options"
                             :class="{'is-invalid': item.country.$error, 'is-valid': !item.country.$invalid}">
                            <label>Страна*</label>
                            <multiselect v-model.trim="item.country.$model"
                                         @input="delayTouch(item.country)"
                                         :options="countries_options"
                                         :allow-empty="false"
                                         :searchable="true"
                                         deselect-label=""
                                         placeholder=""
                                         selected-label=""
                                         select-label=""
                            ><span slot="noResult">Совпадений не найдено</span></multiselect>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.city.$error, 'is-valid': !item.city.$invalid}">
                            <label :for="item.index.$model + '_city'">Город*</label>
                            <input :id="item.index.$model + '_city'"
                                   v-model.trim="item.city.$model"
                                   @input="delayTouch(item.city)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': item.address.$error, 'is-valid': !item.address.$invalid}">
                            <label :for="item.index.$model + '_address'">Точный адрес (улица, дом, квартира)*</label>
                            <input :id="item.index.$model + '_address'"
                                   v-model.trim="item.address.$model"
                                   @input="delayTouch(item.address)"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>
                </div>

                <div v-if="!item.person.$model">
                    <hr>
                    <p class="mb-20 font-500">Выберите роль представителя и заполните его данные:</p>

                    <div class="mb-40 row">
                        <div class="col-6">
                            <button class="btn-small btn-filter"
                                    @click="item.representative.$model = 1"
                                    :class="{'btn-filter-active': item.representative.$model == 1}">
                                Законный представитель
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn-small btn-filter"
                                    @click="item.representative.$model = 2"
                                    :class="{'btn-filter-active': item.representative.$model == 2}">
                                Доверенное лицо
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': item.representative_name.$error, 'is-valid': item.representative_name.$model && !item.representative_name.$invalid}">
                                <label :for="item.index.$model + '_representative_name'">Имя</label>
                                <input :id="item.index.$model + '_representative_name'"
                                       v-model.trim="item.representative_name.$model"
                                       @input="delayTouch(item.representative_name)"
                                       autocomplete="off"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': item.representative_surname.$error, 'is-valid': item.representative_surname.$model && !item.representative_surname.$invalid}">
                                <label :for="item.index.$model + '_representative_surname'">Фамилия</label>
                                <input :id="item.index.$model + '_representative_surname'"
                                       v-model.trim="item.representative_surname.$model"
                                       @input="delayTouch(item.representative_surname)"
                                       autocomplete="off"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': item.representative_date_of_birth.$error, 'is-valid': item.representative_date_of_birth.$model && !item.representative_date_of_birth.$invalid}">
                                <label :for="item.index.$model + '_representative_date_of_birth'">Дата рождения</label>
                                <input :id="item.index.$model + '_representative_date_of_birth'"
                                       placeholder="##.##.####"
                                       v-mask="'##.##.####'"
                                       v-model.trim="item.representative_date_of_birth.$model"
                                       @input="delayTouch(item.representative_date_of_birth)"
                                       autocomplete="off"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': item.representative_email.$error, 'is-valid': item.representative_email.$model && !item.representative_email.$invalid}">
                                <label :for="item.index.$model + '_representative_email'">Email</label>
                                <input :id="item.index.$model + '_representative_email'"
                                       v-model.trim="item.representative_email.$model"
                                       @input="delayTouch(item.representative_email)"
                                       autocomplete="off"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': item.representative_personal_number.$error, 'is-valid': item.representative_personal_number.$model && !item.representative_personal_number.$invalid}">
                                <label :for="item.index.$model + '_representative_personal_number'">Личный код</label>
                                <input :id="item.index.$model + '_representative_personal_number'"
                                       v-model.trim="item.representative_personal_number.$model"
                                       @input="delayTouch(item.representative_personal_number)"
                                       autocomplete="off"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': item.representative_phone.$model && !item.representative_phone_valid.$model && item.representative_phone_blur.$model, 'is-valid': item.representative_phone.$model && item.representative_phone_valid.$model}">
                                <label>Телефон</label>
                                <vue-tel-input autocomplete="off"
                                               type="text"
                                               v-model.trim="item.representative_phone.$model"
                                               @input="phoneValid(item.representative_phone.$model, 2, item.index.$model)"
                                               :inputOptions="inputOptions"
                                               :mode="mode"
                                               @blur="blur(2, item.index.$model)"
                                               @validate="telValidate"
                                               :validCharactersOnly="validCharactersOnly"
                                ></vue-tel-input>
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="mb-20 form--item image-loader"
                                 :class="{'is-valid': item.representative_file.$model && !item.representative_file.$invalid}">
                                <label>Доверенность (скан PDF или asics)</label>
                                <b-form-file
                                    v-model.trim="item.representative_file.$model"
                                    @input="delayTouch(item.representative_file)"
                                    placeholder="Файл не выбран"
                                    drop-placeholder="Перетащите файл сюда"
                                ></b-form-file>

                            </div>
                        </div>

                    </div>
                </div>

                <hr>
            </div>


            <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 font-500">Новый участник</p>
                <button class="btn-small btn-v2" @click="addInputs()">Добавить участника</button>
            </div>

            <div class="d-block d-md-none pt-4">
                <button class="btn-small btn-v2 w-100"
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

        <div class="mobile-footer-btn-container">
            <button class="btn-small btn-v1 w-100" @click="saveData()">Сохранить</button>
        </div>

    </div>
</template>

<script>
    import {
        requiredRule,
        emailRule,
        birthRuleNoReq,
        emailRuleNoReq,
        noValid,
        checkbox,
        requiredIfFile,
        requiredIfPersonRule,
        birthIfPersonRule,
        requiredIfNoPersonRule,
        personalNumberRuleIfPersonRule,
        personalNumberRuleNoReq
    } from '../../../services/validation';

    const touchMap = new WeakMap();

    import Multiselect from 'vue-multiselect';
    import {VueTelInput} from 'vue-tel-input';

    import RequestsServices from '../../../services/requests';
    import {echoDate} from '../../../services/functions';

    export default {
        components: {
            Multiselect,
            VueTelInput
        },

        props: ['contributors', 'user_role', 'user_approved'],

        data() {
            return {
                active: 1,

                type: null,

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


                postData: [
                    {
                        index: 1,
                        person: true,
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

                        commercial_name: null,
                        commercial_code: null,

                        phone_valid: null,
                        phone_blur: false,

                        representative_phone_valid: true,
                        representative_phone_blur: false,

                        representative: 1,
                        representative_name: null,
                        representative_surname: null,
                        representative_date_of_birth: null,
                        representative_email: null,
                        representative_personal_number: null,
                        representative_phone: null,
                        representative_file: null,
                    },
                ],

                data_index: 2,

                countries_options: null,

                /*data for vue-tel-input*/
                dynamicPlaceholder: true,
                validCharactersOnly: true,
                enabledCountryCode: false,
                inputOptions: {
                    showDialCode: false,
                },
                mode: 'international',

                phoneValid_marriedData: '',
                phoneValid_representative: '',

                possible_marriedData: '',
                possible_representative: '',
                /**/
                phone_valid: false,
                phone_blur: '',

                loading: true
            }
        },

        created() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });
        },

        mounted() {
            this.loading = false;
        },

        methods: {
            saveData() {
                this.$v.$touch();
                this.postData.forEach(item => {
                    item.phone_blur = true;
                });

                if (this.$v.$invalid) {
                    console.log(this.$v);
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`,
                    });
                    return;
                } else {
                    this.loading = true;

                    this.postData.forEach(item => {
                        this.loading = true;

                        item.role = item.role.id;

                        if(item.date_of_birth) item.date_of_birth = item.date_of_birth.split('.').reverse().join('-');
                        if(item.representative_date_of_birth) item.representative_date_of_birth = item.representative_date_of_birth.split('.').reverse().join('-');

                        let formData = new FormData();
                        for (let key in item) {
                            if (item[key]) formData.append(key, item[key]);
                        }

                        if (item.person) formData.append('person', 1);
                        if (!item.person) formData.append('person', 0);

                        let url = '/api/deal/' + this.$route.params.id + '/contributors_data';
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
                                        //this.$router.go();
                                        this.initDealData();
                                        this.postData = [];
                                        // this.addInputs();
                                        this.$v.$reset();
                                    })
                                }
                            })
                            .finally(() => {
                                this.loading = false
                            })
                    })

                }
            },

            addInputs() {
                let obj = {
                    index: this.data_index,
                    person: true,
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

                    commercial_name: null,
                    commercial_code: null,

                    phone_valid: null,
                    phone_blur: false,

                    representative_phone_valid: true,
                    representative_phone_blur: false,

                    representative: 1,
                    representative_name: null,
                    representative_surname: null,
                    representative_date_of_birth: null,
                    representative_email: null,
                    representative_personal_number: null,
                    representative_phone: null,
                    representative_file: null,
                };
                this.postData.push(obj);
                this.data_index++;
                this.$v.$reset();
            },

            cancelItem(item) {
                let data = this.postData;
                data = data.splice(item, 1);
            },

            initDealData() {
                this.$emit('init_data', true);
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000))
            },

            phoneValid(phone, type, index) {
                if(this.postData && this.postData.length > 0) {
                    this.postData.forEach(item => {
                        if (item.index == index && type == 1) {
                            item.phone_valid = this.phone_valid;
                            item.phone_blur = this.phone_blur;
                        }

                        if (item.index == index && type == 2) {
                            if(item.representative_phone.length > 0) {
                                item.representative_phone_valid = this.phone_valid;
                                item.representative_phone_blur = true;
                            }
                            else item.representative_phone_valid = true;
                        }
                    })
                }
            },

            blur(type, index) {
                if(this.postData && this.postData.length > 0) {
                    this.postData.forEach(item => {
                        if (item.index == index && type == 1) {
                            if (item.phone_valid == false) {
                                item.phone_blur = true;
                            }
                        }

                        if (item.index == index && type == 2) {
                            if (item.representative_phone_valid == false) {
                                item.representative_phone_blur = true;
                            }
                        }
                    })
                }
            },

            approveData() {
                this.$emit('approve_data', true);
            },

            telValidate(number) {
                if(number && number.valid !== null) {
                    this.phone_valid = number.valid;
                }
            }
        },


        validations: {
                postData: {
                    $each: {
                        index: requiredRule,
                        person: requiredRule,
                        role: requiredRule,

                        name: requiredIfPersonRule,
                        surname: requiredIfPersonRule,
                        date_of_birth: birthIfPersonRule,
                        personal_number: personalNumberRuleIfPersonRule,

                        commercial_name: requiredIfNoPersonRule,
                        commercial_code: requiredIfNoPersonRule,

                        email: emailRule,
                        phone: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,

                        representative: requiredRule,
                        representative_date_of_birth: birthRuleNoReq,
                        representative_email: emailRuleNoReq,

                        representative_name: noValid,
                        representative_personal_number: personalNumberRuleNoReq,
                        representative_phone: noValid,
                        representative_surname: noValid,
                        representative_file: requiredIfFile,

                        phone_valid: checkbox,
                        phone_blur: noValid,

                        representative_phone_valid: requiredIfNoPersonRule,
                        representative_phone_blur: noValid
                    }

                }


        },
    }
</script>
