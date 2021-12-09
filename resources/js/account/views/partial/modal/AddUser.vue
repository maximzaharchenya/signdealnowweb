<template>
    <b-modal id="add-user" ref="add-user" centered hide-header hide-footer>
        <div class="close">
            <img src="/svg/close.svg" alt="" @click="$bvModal.hide('add-user')">
        </div>

        <h3 class="mb-30">Добавление участника</h3>

        <div class="row custom-form">
            <div class="col-sm-6 col-lg-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.name.$error, 'is-valid': !$v.postData.name.$invalid}">
                    <label for="name">Имя*</label>
                    <input id="name"
                           autocomplete="off"
                           type="text"
                           @input="delayTouch($v.postData.name)"
                           v-model.trim="postData.name">
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.surname.$error, 'is-valid': !$v.postData.surname.$invalid}">
                    <label for="surname">Фамилия*</label>
                    <input id="surname"
                           autocomplete="off"
                           type="text"
                           @input="delayTouch($v.postData.surname)"
                           v-model.trim="postData.surname">
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.type.$error, 'is-valid': !$v.type.$invalid}">
                    <label for="type">Роль*</label>
                    <multiselect v-model="type"
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

            <div class="col-sm-6 col-lg-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': $v.postData.email.$error, 'is-valid': !$v.postData.email.$invalid}">
                    <label for="email">Email*</label>
                    <input id="email"
                           autocomplete="off"
                           type="text"
                           @input="delayTouch($v.postData.email)"
                           v-model.trim="postData.email">
                </div>
            </div>

            <div class="col-sm-6 col-lg-4">
                <div class="mb-20 form--item"
                     :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible}">
                    <label for="phone">Телефон*</label>
                    <vue-tel-input id="phone"
                                   autocomplete="off"
                                   type="text"
                                   @input="delayTouch($v.postData.phone)"
                                   v-model.trim="postData.phone"
                                   @validate="telValidate"
                                   @blur="blur"
                                   :validCharactersOnly="validCharactersOnly"
                                   :inputOptions="inputOptions"
                                   :mode="mode"
                    ></vue-tel-input>
                </div>
            </div>
        </div>

        <hr class="mb-3">

        <div class="row mb-40">
            <div class="col-sm-6 mb-1 mb-sm-0">
                <div class="checkbox">
                    <input type="checkbox" id="present"
                           v-model="present">
                    <label for="present" class="fs-16">Присутствует на нотариальной сделке</label>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="checkbox">
                    <input type="checkbox" id="signs"
                           v-model="signs">
                    <label for="signs" class="fs-16">Ставит подпись</label>
                </div>
            </div>
        </div>

        <button class="btn-large btn-v1" @click="addUser()">Добавить</button>
    </b-modal>
</template>

<script>
    import { requiredRule, emailRule } from '../../../../services/validation';
    const touchMap = new WeakMap();

    import Multiselect from 'vue-multiselect';
    import {VueTelInput} from 'vue-tel-input';

    export default {
        components: {
            Multiselect,
            VueTelInput
        },

        props: ['id'],

        data () {
            return {
                postData: {
                    name: null,
                    surname: null,
                    type: null,
                    email: null,

                },

                type: null,
                signs: 0,
                present: 0,

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
            signs() {
                if(this.signs) this.present = true
            },
            present() {
                if(!this.present) this.signs = false
            }
        },

        methods: {
            addUser() {
                this.$v.$touch();

                if (this.$v.$invalid || !this.phoneValid) {
                    if(!this.phoneValid) this.possible = true;
                    return;
                } else {
                    this.loading = true;

                    this.postData.type = this.type.id;

                    if(this.signs) this.postData.signs = 1;
                    else this.postData.signs = 0;

                    if(this.present) this.postData.present = 1;
                    else this.postData.present = 0;

                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData.hasOwnProperty(key) && key)
                            formData.append(key, this.postData[key]);
                    }

                    let url = '/api/deal/' + this.id + '/user_data';
                    const options = {
                        headers: {
                            Authorization: "Bearer " + localStorage.getItem('token')
                        }
                    };

                    axios.post(url, formData, options)
                        .then(response => {
                            if(response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Новый участник успешно добавлен'
                                }).then(() => {
                                    this.$router.go();
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
                email: emailRule,
                phone: requiredRule,
            },
            type: requiredRule,

        }
    }
</script>

