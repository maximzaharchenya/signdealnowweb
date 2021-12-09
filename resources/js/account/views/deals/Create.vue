<template>

    <div class="h-100-vh account-content" id="deal-create">
        <div class="deal-create-grid custom-form h-100-vh">
            <div class="h-100">
                <div class="card--common h-100">
                    <div class="card--common__header">
                        <h3 class="mb-0">Новая сделка</h3>

                        <div>
                            <button :disabled="$v.$invalid || !phoneValid" @click="saveChanges()" class="btn-small btn-v2 d-none d-md-block">Сохранить</button>
                        </div>
                    </div>

                    <div class="card--common__body">
                        <div class="deal-create__info">
                            <div>
                                <h5 class="font-500 mb-2">Фото объекта</h5>

                                <div class="mb-20 form--item profile-image-loader">
                                    <b-form-file placeholder="Загрузить изображение" accept="image/jpeg, image/png"
                                                 @change="previewThumbnail"
                                                 v-model="postData.image">
                                        <template slot="file-name" slot-scope="{ name }">
                                            <span class="color-text-grey">Изображение добавлено</span>
                                        </template>
                                    </b-form-file>
                                </div>

                                <div class="preview-img-container__deal" v-if="preview_image">
                                    <img :src="preview_image" alt="" v-if="preview_image">
                                </div>

                            </div>
                            <div>
                                <h5 class="mb-20 font-500">Общая информация</h5>

                                <div class="row mb-20">
                                    <div class="col-xl-6">
                                        <div class="mb-20 form--item">
                                            <label>Тип сделки*</label>
                                            <multiselect v-model="type"
                                                         :options="type_options"
                                                         :allow-empty="false"
                                                         :searchable="false"
                                                         deselect-label=""
                                                         placeholder="Не выбрано"
                                                         selected-label=""
                                                         select-label=""
                                            ></multiselect>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="mb-20 form--item">
                                            <label for="surname">Кадастровый номер</label>
                                            <input id="surname"
                                                   autocomplete="off"
                                                   type="text"
                                                   v-model="postData.cadastral_number">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="mb-20 form--item"
                                             v-if="countries_options">
                                            <label for="phone">Страна*</label>
                                            <multiselect v-model="postData.country"
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

                                    <div class="col-xl-6">
                                        <div class="mb-20 form--item">
                                            <label for="city">Город*</label>
                                            <input id="city"
                                                   autocomplete="off"
                                                   type="text"
                                                   v-model="postData.city">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-20 form--item">
                                            <label for="personal_number">Точный адрес (улица, дом, квартира)*</label>
                                            <input id="personal_number"
                                                   autocomplete="off"
                                                   type="text"
                                                   v-model="postData.address">
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>


                </div>
            </div>

            <div>
                <div class="card--common">
                    <div class="card--common__header small-header">
                        <h5 class="mb-0 font-600">Основные участники</h5>
                    </div>

                    <div class="card--common__body">
                        <div class="mb-24 d-flex">
                            <div class="mr-2">
                                <div class="img-circle-container">
                                    <img v-if="user.profile_image" :src="'/storage/' + user.profile_image" alt="">
                                    <img v-else src="/svg/user-default-36.svg" alt="">
                                </div>
                            </div>
                            <div>
                                <p class="font-500 mb-0">{{user.name}} {{user.surname}}</p>
                                <p class="small color-text-grey mb-0" v-if="change_main_role">Роль участника</p>
                                <p class="small color-text-grey mb-0" v-else>
                                    <span v-if="postData.user_role == 1">Продавец</span>
                                    <span v-if="postData.user_role == 2">Покупатель</span>
                                </p>
                            </div>
                        </div>

                        <div v-if="change_main_role">
                            <div class="mb-20 form--item">
                                <label>Выберите вашу роль </label>
                                <multiselect v-model="role"
                                             :options="role_options"
                                             :allow-empty="false"
                                             :searchable="false"
                                             deselect-label=""
                                             placeholder="Не выбрано"
                                             selected-label=""
                                             select-label=""
                                             label="title"
                                             track-by="title"
                                ></multiselect>
                            </div>

                            <button class="btn-small btn-v1" @click="saveMainRole()">Сохранить</button>
                        </div>


                        <hr>
                        <div class="mb-20 d-flex">
                            <div class="mr-2">
                                <div class="img-circle-container">
                                    <img src="/svg/user-default-36.svg" alt="">
                                </div>
                            </div>
                            <div>
                                <p class="font-500 mb-0" v-if="!save_user">Имя Фамилия</p>
                                <p class="font-500 mb-0" v-else>{{postData.user_email}}</p>

                                <p class="small color-text-grey mb-0" v-if="!save_user || !postData.user_role">Роль участника</p>
                                <p class="small color-text-grey mb-0" v-else>{{additional_role}}</p>
                            </div>
                        </div>

                        <button class="btn-small btn-v2" v-if="!add_user" @click="add_user = true">Добавить участника
                        </button>

                        <div v-if="add_user && !save_user">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.postData.user_email.$error, 'is-valid': !$v.postData.user_email.$invalid}">
                                <label for="user_email">Email</label>
                                <input id="user_email"
                                       autocomplete="off"
                                       type="email"
                                       @input="delayTouch($v.postData.user_email)"
                                       v-model.trim="postData.user_email">
                            </div>
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible}">
                                <label for="phone">Телефон*</label>
                                <vue-tel-input id="phone"
                                               autocomplete="off"
                                               type="text"
                                               @input="delayTouch($v.postData.user_phone)"
                                               v-model.trim="postData.user_phone"
                                               @validate="telValidate"
                                               @blur="blur"
                                               :validCharactersOnly="validCharactersOnly"
                                               :inputOptions="inputOptions"
                                               :mode="mode"
                                ></vue-tel-input>
                            </div>
                            <button class="btn-small btn-v1" @click="saveAdditionalRole()">Добавить участника</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="mobile-footer-btn-container">
            <button :disabled="$v.$invalid || !phoneValid" @click="saveChanges()" class="btn-small btn-v2 w-100">Сохранить</button>
        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>
    </div>


</template>

<script>
    import { emailRule, requiredRule } from '../../../services/validation';
    const touchMap = new WeakMap();

    import RequestsServices from '../../../services/requests';

    import Multiselect from 'vue-multiselect';
    import {VueTelInput} from 'vue-tel-input';

    export default {
        components: {
            Multiselect,
            VueTelInput
        },
        data() {
            return {
                loading: false,

                type: null,
                role: null,
                additional_role: null,

                postData: {
                    type: null,
                    country: null,
                    city: null,
                    address: null,
                    image: null,
                    cadastral_number: null,
                    user_phone: null,
                    user_email: null,
                    user_type: null,

                    user_role: null
                },

                countries_options: null,
                type_options: [
                    'Покупка-продажа', 'Бронирование'
                ],
                role_options: [
                    {id: 1, title: 'Продавец'},
                    {id: 2, title: 'Покупатель'},
                ],

                change_main_role: true,
                add_user: false,
                save_user: false,

                dynamicPlaceholder: true,
                validCharactersOnly: true,
                enabledCountryCode: true,
                inputOptions: {
                    showDialCode: true,
                },
                mode: 'international',
                phoneValid: null,
                possible: null,

                preview_image: null,

            }
        },
        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        mounted() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });

            const external_deal = localStorage.getItem('external_deal');
            if(external_deal) this.setDataFromExternalDeal(external_deal)

        },

        watch: {
            'postData.user_role'() {
                if (this.role.id === 1) {
                    this.additional_role = 'Покупатель';
                    this.postData.user_type = 2;
                }
                if (this.role.id === 2) {
                    this.additional_role = 'Продавец';
                    this.postData.user_type = 1;
                }
            }
        },

        methods: {

            setDataFromExternalDeal(external_deal) {
                const data = JSON.parse(external_deal);
                this.type = 'Покупка-продажа';
                this.role = {id: 2, title: 'Покупатель'};
                this.saveMainRole();

                this.additional_role = 'Продавец';
                if(data.seller_email && data.seller_phone) {
                    this.postData.user_email = data.seller_email;
                    this.postData.user_phone = data.seller_phone;
                    this.save_user = true;
                    this.add_user = true;

                }

                if(data.address) this.postData.address = data.address;
                if(data.cadastral_number) this.postData.cadastral_number = data.cadastral_number;
            },

            saveChanges() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    return;
                } else {
                    this.loading = true;

                    if (this.type === 'Покупка-продажа') this.postData.type = 1;
                    if (this.type === 'Бронирование') this.postData.type = 2;

                    let formData = new FormData();

                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    let url = '/api/deal/store';
                    const options = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            Authorization: "Bearer " + localStorage.getItem('token')
                        }
                    };
                    axios.post(url, formData, options)

                        .then(response => {
                            if (response.status == 200) {

                                const external_deal = localStorage.getItem('external_deal');
                                if(external_deal) localStorage.removeItem('external_deal');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Новая сделка успешно сохранена',
                                }).then(() => {
                                    this.$router.push({name: 'account-deals'});
                                })
                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }

            },

            saveMainRole() {
                if (this.role) {
                    this.postData.user_role = this.role.id;
                    this.change_main_role = false;
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Внимание',
                        html: 'Выберите вашу роль в выпадающем меню',
                    })
                }
            },

            saveAdditionalRole() {
                this.$v.postData.user_email.$touch();
                this.$v.postData.user_phone.$touch();

                if (this.$v.postData.user_email.$invalid || !this.phoneValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Внимание',
                        html: 'Введите email и телефон второго участника сделки',
                    });
                    return;
                } else {
                    this.save_user = true;
                }
            },

            previewThumbnail: function(event) {
                var input = event.target;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var vm = this;
                    reader.onload = function(e) {
                        vm.preview_image = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
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
            postData: {
                user_email: emailRule,
                user_phone: requiredRule,
                country: requiredRule,
                address: requiredRule,
                user_role: requiredRule
            },
            type: requiredRule,
        }
    }

</script>

