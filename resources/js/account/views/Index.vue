<template>

    <div v-if="user" id="profile">

        <div class="mobile-main-image d-block d-md-none">
            <div class="img-container">
                <img v-if="user.profile_image" :src="'/storage/' + user.profile_image" alt="">
                <img v-else src="/img/defaults/user_default.png" alt="">

                <router-link to="/account/edit" class="btn-small-edit">
                    <img src="/svg/action_edit.svg" alt="">
                </router-link>
            </div>
        </div>

        <div class="profile-information account-content">
            <div class="card--common mb-30">
                <div class="card--common__header">
                    <h3 class="mb-0">Здравствуйте<span v-if="user.name">, {{user.name}}</span>!</h3>

                    <div class="d-none d-md-block">
                        <router-link to="/account/edit" class="btn-small btn-v1">Редактировать профиль</router-link>
                    </div>
                </div>


                <div class="card--common__body">
                    <div class="row justify-content-between">
                        <div class="col-3 d-none d-md-block">
                            <div class="img-container">
                                <img v-if="user.profile_image" :src="'/storage/' + user.profile_image" alt="">
                                <img v-else src="/img/defaults/user_default.png" alt="">
                            </div>
                        </div>

                        <div class="col-md-9">
                            <h5 class="font-500 mb-20">Основная информация</h5>

                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-20">
                                    <p class="color-text-light mb-1">Имя</p>
                                    <p class="fs-16 mb-0">{{user.name}}</p>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-20">
                                    <p class="color-text-light mb-1">Фамилия</p>
                                    <p class="fs-16 mb-0">{{user.surname}}</p>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-20">
                                    <p class="color-text-light mb-1">Дата рождения</p>
                                    <p class="fs-16 mb-0">{{user.date_of_birth}}</p>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-20">
                                    <p class="color-text-light mb-1">Email</p>
                                    <p class="fs-16 mb-0">{{user.email}}</p>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-20">
                                    <p class="color-text-light mb-1">Личный код</p>
                                    <p class="fs-16 mb-0">{{user.personal_number}}</p>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-20">
                                    <p class="color-text-light mb-1">Телефон</p>
                                    <p class="fs-16 mb-0">{{user.phone}}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row no-gutters">
                <div class="col-xl-5 pr-xl-3">
                    <div class="card--common mb-30 mb-xl-0">
                        <div class="card--common__body">
                            <h5 class="mb-20 font-500">Место жительства</h5>

                            <div class="row">
                                <div class="col-md-3 col-xl-6">
                                    <div class="mb-20">
                                        <p class="color-text-light mb-1">Страна</p>
                                        <p class="fs-16 mb-0" v-if="user.country">{{user.country}}</p>
                                        <p class="fs-16 mb-0 color-text-grey" v-else>Не указано</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xl-6">
                                    <div class="mb-20">
                                        <p class="color-text-light mb-1">Город</p>
                                        <p class="fs-16 mb-0" v-if="user.city">{{user.city}}</p>
                                        <p class="fs-16 mb-0 color-text-grey" v-else>Не указано</p>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-12">
                                    <p class="color-text-light mb-1">Точный адрес</p>
                                    <p class="fs-16 mb-0" v-if="user.address">{{user.address}}</p>
                                    <p class="fs-16 mb-0 color-text-grey" v-else>Не указано</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-7 pl-xl-3">
                    <div class="card--common">
                        <div class="card--common__body">
                            <h5 class="mb-20 font-500">Дополнительная информация</h5>

                            <div class="mb-20">
                                <p class="color-text-light mb-1">Разговорные языки</p>
                                <div class="fs-16 mb-0 d-flex flex-wrap" v-if="languages">
                                    <div v-for="(item, key) in languages" :key="key" >
                                        {{item}}<span v-if="key !==  languages.length - 1" class="d-inline-block pr-1">, </span>
                                    </div>

                                </div>
                                <p class="fs-16 mb-0 color-text-grey" v-else>Не указано</p>
                            </div>

                            <div>
                                <p class="color-text-light mb-1">Персональные предпочтения</p>
                                <p class="fs-16 mb-0" v-if="user.about">{{user.about}}</p>
                                <p class="fs-16 mb-0 color-text-grey" v-else>Не указано</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="load-box" v-if="loading">
                <b-spinner></b-spinner>
            </div>
        </div>



    </div>


</template>

<script>
    export default {
        data() {
            return {
                languages: null,

                loading: true
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

        mounted() {
            this.init();
        },

        methods: {
            init() {
                let user = this.user;

                let pin = localStorage.getItem('pin');
                let pin_notary = localStorage.getItem('pin_notary');
                let pin_id = localStorage.getItem('pin_id');

                if(pin) this.$router.push({path: '/account/deal/' + pin_id + '/register'});
                if(pin_notary) this.$router.push({path: '/account/deal/' + pin_id + '/notary/register'});

                if(user.languages && typeof user.languages === 'string') {
                    this.languages = JSON.parse(user.languages);
                }

                this.loading = false;
            }
        }
    }


</script>

