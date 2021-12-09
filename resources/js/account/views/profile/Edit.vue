<template>
    <div v-if="user" id="profile-edit" class="account-content">
        <div class="card--common">
            <div class="card--common__header">
                <h3 class="mb-0">Заполнение профиля</h3>
                <button class="d-none d-md-block btn-small btn-v1" @click="saveChanges()" :disabled="$v.$invalid || !phoneValid">Сохранить</button>
            </div>

            <div class="card--common__body">
                <div class="row justify-content-between custom-form">
                    <div class="col-xl-3 order-2 order-xl-1">
                        <h5 class="font-500 mb-2">Фото профиля</h5>

                        <div class="mb-20 form--item profile-image-loader">
                            <b-form-file :placeholder="profile_image ? 'Заменить изображение' : 'Загрузить изображение'"
                                         accept="image/jpeg, image/png"
                                         @change="previewThumbnail"
                                         v-model="postData.profile_image">
                                <template slot="file-name" slot-scope="{ name }">
                                    <span class="color-text-grey">Изображение добавлено</span>
                                </template>
                            </b-form-file>

                        </div>

                        <div class="img-container mb-24" v-if="profile_image && !postData.profile_image && !preview_image">
                            <img :src="'/storage/' + profile_image" alt="">
                        </div>


                        <div class="preview-img-container mb-24" v-if="preview_image">
                            <img :src="preview_image" alt="" v-if="preview_image">
                        </div>

                    </div>
                    <div class="col-xl-9 mb-4 mb-xl-0 order-1 order-xl-2">
                        <div class="pl-100">
                            <h5 class="mb-20 font-500">Основная информация</h5>

                            <div class="row mb-20">
                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item" :class="{'is-invalid': $v.postData.name.$error, 'is-valid': !$v.postData.name.$invalid}">
                                        <label for="name">Имя*</label>
                                        <input id="name"
                                               autocomplete="off"
                                               type="text"
                                               @input="delayTouch($v.postData.name)"
                                               v-model.trim="postData.name">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item" :class="{'is-invalid': $v.postData.surname.$error, 'is-valid': !$v.postData.surname.$invalid}">
                                        <label for="surname">Фамилия*</label>
                                        <input id="surname"
                                               autocomplete="off"
                                               type="text"
                                               @input="delayTouch($v.postData.surname)"
                                               v-model.trim="postData.surname">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item" :class="{'is-invalid': $v.date_of_birth.$error, 'is-valid': !$v.date_of_birth.$invalid}">
                                        <label for="date_of_birth">Дата рождения*</label>
                                        <input id="date_of_birth"
                                               autocomplete="off"
                                               type="text"
                                               placeholder="##.##.####"
                                               v-mask="'##.##.####'"
                                               @input="delayTouch($v.date_of_birth)"
                                               v-model.trim="date_of_birth">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item disabled--item">
                                        <label for="email">Email</label>
                                        <input id="email"
                                               disabled
                                               autocomplete="off"
                                               type="email"
                                               v-model="postData.email">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item" :class="{'is-invalid': $v.postData.personal_number.$error, 'is-valid': !$v.postData.personal_number.$invalid}">
                                        <label for="personal_number">Личный код*</label>
                                        <input id="personal_number"
                                               autocomplete="off"
                                               type="text"
                                               @input="delayTouch($v.postData.personal_number)"
                                               v-model.trim="postData.personal_number">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item" :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible}">
                                        <label for="phone">Телефон*</label>
                                        <vue-tel-input id="phone"
                                                       autocomplete="off"
                                                       type="text"
                                                       @input="delayTouch($v.postData.phone)"
                                                       v-model.trim="postData.phone"
                                                       :inputOptions="inputOptions"
                                                       :mode="mode"
                                                       @validate="telValidate"
                                                       @blur="blur"
                                                       :validCharactersOnly="validCharactersOnly"
                                        ></vue-tel-input>
                                    </div>
                                </div>

                            </div>

                            <h5 class="mb-20 font-500">Место жительства</h5>

                            <div class="row mb-20">
                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item"
                                         v-if="countries_options">
                                        <label for="phone">Страна</label>
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

                                <div class="col-sm-6 col-xl-4">
                                    <div class="mb-20 form--item">
                                        <label for="city">Город</label>
                                        <input id="city"
                                               autocomplete="off"
                                               type="text"
                                               v-model="postData.city">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-20 form--item">
                                        <label for="address">Точный адрес (улица, дом, квартира)</label>
                                        <input id="address"
                                               autocomplete="off"
                                               type="text"
                                               v-model="postData.address">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-20 font-500">Дополнительная информация</h5>

                            <div class="mb-20 form--item multiple">
                                <label>Знание языков</label>
                                <multiselect v-model="postData.languages"
                                             :options="languages_options"
                                             multiple
                                             :allow-empty="false"
                                             :searchable="false"
                                             deselect-label=""
                                             placeholder=""
                                             selected-label=""
                                             select-label=""
                                ></multiselect>
                            </div>

                            <div class="form--item">
                                <label for="about">Персональные предпочтения</label>
                                <input id="about"
                                       autocomplete="off"
                                       type="text"
                                       v-model="postData.about">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="mobile-footer-btn-container">
                    <button class="btn-small btn-v1 w-100" @click="saveChanges()" :disabled="$v.$invalid || !phoneValid">Сохранить</button>
                </div>

            </div>

        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>

    </div>
</template>

<script>

    import RequestsServices from '../../../services/requests';

    import {requiredRule, birthRule, personalNumberRule} from '../../../services/validation';
    const touchMap = new WeakMap();

    import {VueTelInput} from 'vue-tel-input';
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            VueTelInput,
            Multiselect
        },

        data() {
            return {
                date_of_birth: null,
                profile_image: null,
                postData: {
                    name: null,
                    surname: null,
                    email: null,
                    personal_number: null,
                    phone: null,
                    country: [],
                    city: null,
                    address: null,
                    languages: [],
                    about: null,
                    profile_image: null,
                },


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
                languages_options: [
                    'Русский', 'Английский', 'Эстонский', 'Немецкий', 'Литовский', 'Латышский', 'Польский', 'Украинский'
                ],

                loading: true,
                preview_image: null,
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        watch: {
            user() {
                this.init();
            }
        },

        created() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                if(this.user) {
                    let user = this.user;
                    this.postData.name = user.name;
                    this.postData.surname = user.surname;
                    this.date_of_birth = user.date_of_birth;
                    this.postData.email = user.email;
                    this.postData.personal_number = user.personal_number;
                    this.postData.phone = user.phone;
                    this.postData.country = user.country;
                    this.postData.country = user.country;
                    this.postData.city = user.city;
                    this.postData.address = user.address;

                    if(this.user.languages && typeof user.languages === 'string') {
                        this.postData.languages = JSON.parse(user.languages);
                    }
                    else this.postData.languages = user.languages;
                    this.postData.about = user.about;
                    this.profile_image = user.profile_image;

                    this.loading = false;
                }
                else this.loading = false
            },

            saveChanges() {
                this.$v.$touch();

                if (this.$v.$invalid || !this.phoneValid) {
                    if(!this.phoneValid) this.possible = true;
                    return;
                } else {
                    this.loading = true;

                    let formData = new FormData();

                    for (let key in this.postData)
                        if (this.postData[key]) formData.append(key, this.postData[key]);

                    if(this.postData.languages) formData.append('languages', JSON.stringify(this.postData.languages));

                    var date_of_birth = this.date_of_birth.split('.').reverse().join('-');
                    if(this.date_of_birth) formData.append('date_of_birth', date_of_birth);

                    let url = '/api/user_update';
                    const options = {
                        headers: {'Content-Type': 'multipart/form-data',  Authorization: "Bearer " + localStorage.getItem('token')}
                    };
                    axios.post(url, formData, options)

                        .then(response => {
                            if(response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Информация профиля успешно сохранена',
                                }).then(() => {
                                    this.$router.push({name: 'account'});
                                    this.$store.dispatch('fetchUser');
                                })
                            }
                        })

                        .finally(() => {
                            this.loading = false;
                        })
                }
            },

            previewThumbnail: function(event) {
                var input = event.target;

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    var vm = this;
                    reader.onload = function(e) {
                        vm.preview_image = e.target.result;
                    }
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
                name: requiredRule,
                surname: requiredRule,
                personal_number: personalNumberRule,
                phone: requiredRule
            },
            date_of_birth: birthRule
        }
    }

</script>
