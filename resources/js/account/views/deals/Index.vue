<template>

    <div id="deals--page" class="h-100-vh account-content">
        <div class="card--common">
            <div class="card--common__header mb-0">
                <div v-if="deals && deals.length < 1 && !filter_data">
                    <h3 class="mb-0">Список сделок пуст</h3>
                </div>

                <div v-if="deals && deals.length > 0 || filter_data" class="deals__filter custom-form">
                    <h3 class="mb-0">Все сделки</h3>

                    <div class="form--item d-none d-lg-block" v-if="roleInDeal_options">
                        <multiselect v-model="roleInDeal"
                                     :options="roleInDeal_options"
                                     :allow-empty="false"
                                     :searchable="false"
                                     deselect-label=""
                                     placeholder="Обязанность в сделке"
                                     selected-label=""
                                     select-label=""
                                     label="name"
                                     track-by="name"
                        ></multiselect>
                    </div>

                    <div class="form--item d-none d-lg-block" v-if="dealState_options">
                        <multiselect v-model="dealState"
                                     :options="dealState_options"
                                     :allow-empty="false"
                                     :searchable="false"
                                     deselect-label=""
                                     placeholder="Статус сделки"
                                     selected-label=""
                                     select-label=""
                                     label="name"
                                     track-by="name"
                        ></multiselect>
                    </div>

                    <button class="btn-small btn-v2"
                            @click="reset()"
                            v-if="resetButton">
                        Сбросить
                    </button>

                    <button class="btn-small btn-v2 d-block d-lg-none"
                            @click="resetButton = true"
                            v-if="!resetButton">
                        Фильтр
                    </button>
                </div>

                <div class="d-none d-xl-block">
                    <router-link to="/account/deals/create" class="btn-small btn-v1">Создать сделку</router-link>
                </div>
            </div>

            <div class="card--common__body pt-0 d-flex flex-column justify-content-between">

                <!-- FILTER MOBILE -->
                <div class="d-block d-lg-none mb-40" v-if="resetButton">
                    <div class="row">
                        <div class="col-sm-6 mb-3 form--item" v-if="roleInDeal_options">
                            <multiselect v-model="roleInDeal"
                                         :options="roleInDeal_options"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         placeholder="Обязанность в сделке"
                                         selected-label=""
                                         select-label=""
                                         label="name"
                                         track-by="name"
                            ></multiselect>
                        </div>
                        <div class="col-sm-6 mb-3 form--item" v-if="dealState_options">
                            <multiselect v-model="dealState"
                                         :options="dealState_options"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         placeholder="Статус сделки"
                                         selected-label=""
                                         select-label=""
                                         label="name"
                                         track-by="name"
                            ></multiselect>
                        </div>

                        <div class="col-sm-6 mb-3 form--item d-block d-md-none">
                            <multiselect v-model="sortByAddress"
                                         :options="sortBy__mobile"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         placeholder="Сортировать по адресу"
                                         selected-label=""
                                         select-label=""
                                         label="title"
                                         track-by="title"
                            ></multiselect>
                        </div>
                        <div class="col-sm-6 form--item d-block d-md-none">
                            <multiselect v-model="sortByDate"
                                         :options="sortByDate__mobile"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         placeholder="Сортировать по дате"
                                         selected-label=""
                                         select-label=""
                                         label="title"
                                         track-by="title"
                            ></multiselect>
                        </div>
                    </div>
                </div>

                <!--  DESCTOP ITEMS -->
                <div class="deals-table d-none d-md-block" v-if="deals && deals.length > 0 || filter_data">

                    <!--  HEADER -->
                    <div class="deals-table__header">
                        <div>ID сделки</div>

                        <div>
                            <div @click="active_sort_1 = true, active_sort_2 = false, sort_1 = !sort_1"
                                 class="d-inline-block cursor-pointer">
                                Адрес
                                <span class="sort-icon"
                                      :class="{'active': active_sort_1, 'sort-bottom': active_sort_1 && !sort_1}">
                                <img src="/svg/sort.svg" alt="">
                            </span>
                            </div>
                        </div>

                        <div>
                            <div @click="active_sort_2 = true, active_sort_1 = false, sort_2 = !sort_2"
                                 class="d-inline-block cursor-pointer">
                                Дата
                                <span class="sort-icon"
                                      :class="{'active': active_sort_2, 'sort-bottom': active_sort_2 && !sort_2}">
                                <img src="/svg/sort.svg" alt="">
                            </span>
                            </div>
                        </div>

                        <div>Статус</div>
                        <div>Фото объекта</div>
                    </div>


                    <!--  BODY -- NO RESULT  -->
                    <div v-if="deals && deals.length < 1">
                        <p class="small color-text-light pt-5 text-center">Не найдено результатов подходящих под
                            заданные
                            параметры</p>
                    </div>

                    <!--  BODY -->
                    <router-link :to="'/account/deals/' + item.id + '/show'"
                                 class="deals-table__item"
                                 v-for="(item, key) in deals"
                                 :key="key">
                        <div>
                            <span v-if="item.id < 10">00{{item.id}}</span>
                            <span v-else-if="item.id < 100 && item.id > 9">0{{item.id}}</span>
                            <span v-else>00{{item.id}}</span>
                        </div>
                        <div>{{item.address}}, {{item.city}}, {{item.country}}</div>
                        <div>{{dateFormate(item.created_at)}}</div>
                        <div> {{status(item.status)}}</div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="img-container">
                                <img v-if="item.image" :src="'/' + item.image" alt="">
                                <img v-else src="/img/defaults/deal.jpg" alt="">
                            </div>
                            <img src="/svg/arrow-right.svg" alt="">
                        </div>

                    </router-link>

                </div>


                <!--  MOBILE ITEMS -->
                <div v-if="deals && deals.length > 0" class="d-md-none d-block">
                    <div class="row">
                        <div class="col-sm-6 mb-4"
                             v-for="(item, key) in deals"
                             :key="key">
                            <router-link :to="'/account/deals/' + item.id + '/show'"
                                         class="deal__card">
                                <div class="deal__card--header">
                                    <img v-if="item.image" :src="'/' + item.image" alt="">
                                    <img v-else src="/img/defaults/deal.jpg" alt="">

                                    <div class="status"> {{status(item.status)}}</div>
                                </div>

                                <div class="deal__card--body">
                                    <div class="d-flex mb-2 justify-content-between">
                                        <div class="font-500">
                                            <span v-if="item.id < 10">00{{item.id}}</span>
                                            <span v-else-if="item.id < 100 && item.id > 9">0{{item.id}}</span>
                                            <span v-else>00{{item.id}}</span>
                                        </div>

                                        <div>{{dateFormate(item.created_at)}}</div>
                                    </div>
                                    <div>
                                        <span class="color-text-light">Адрес:</span>
                                        <span>{{item.address}}, {{item.city}}, {{item.country}}</span>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </div>

                </div>


                <div class="d-none d-md-block d-xl-none pt-4">
                    <router-link to="/account/deals/create" class="btn-small btn-v1">Создать сделку</router-link>
                </div>

                <div class="mobile-footer-btn-container">
                    <router-link to="/account/deals/create" class="btn-small btn-v1 w-100 text-center">Создать сделку</router-link>
                </div>
            </div>


        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>
    </div>


</template>

<script>
    import {echoDateTime, getStatus} from '../../../services/functions';
    import RequestsServices from "../../../services/requests";
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            Multiselect,
        },

        data() {
            return {
                loading: true,
                deals: null,

                filter_data: null,

                roleInDeal: null,
                dealState: null,
                sortBy: null,

                roleInDeal_options: null,
                dealState_options: null,

                sortBy_options: [
                    '1', '2', '3', '4'
                ],

                active_sort_1: false,
                sort_1: false,
                active_sort_2: false,
                sort_2: false,

                resetButton: false,

                all_statuses: null,

                sortByAddress: null,
                sortByDate: null,

                sortBy__mobile: [
                    { id: 1, title: 'По убыванию'},
                    { id: 2, title: 'По возрастанию'},
                ],
                sortByDate__mobile: [
                    { id: 1, title: 'От старых к новым'},
                    { id: 2, title: 'От новых к старым'},
                ]
            }
        },

        created() {
            RequestsServices.statuses().then(response => {
                this.dealState_options = response
            });
            RequestsServices.roles().then(response => {
                this.roleInDeal_options = response
            })
        },

        mounted() {
            this.init();
        },

        watch: {
            roleInDeal() {
                this.setPostData();
            },
            dealState() {
                this.setPostData();
            },
            active_sort_1() {
                if(!this.sortByAddress) this.setPostData();
            },
            sort_1() {
                this.setPostData();
            },
            active_sort_2() {
                if(!this.sortByDate) this.setPostData();
            },
            sort_2() {
                this.setPostData();
            },
            sortByAddress() {
                this.active_sort_1 = true;
                this.active_sort_2 = false;
                if(this.sortByAddress.id == 1) this.sort_1 = true;
                if(this.sortByAddress.id == 2) this.sort_1 = false;
                this.sortByDate = null
            },
            sortByDate() {
                this.active_sort_1 = false;
                this.active_sort_2 = true;
                if(this.sortByDate.id == 1) this.sort_2 = true;
                if(this.sortByDate.id == 2) this.sort_2 = false;
                this.sortByAddress = null
            }
        },

        methods: {
            init() {
                this.deals = null;
                let url = '/api/deal/index';
                const options = {
                    params: this.filter_data,
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')},
                };

                axios.get(url, options)

                    .then(response => {
                        if (response.status == 200) {
                            this.deals = response.data;
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            setPostData() {
                this.loading = true;
                let postData = {};

                if (this.roleInDeal) {
                    postData.roleInDeal = this.roleInDeal.value;
                    this.resetButton = true;
                }
                if (this.dealState) {
                    postData.dealState = this.dealState.value;
                    this.resetButton = true;
                }

                if (this.active_sort_1 && this.sort_1) {
                    postData.sortBy = 1;
                    this.resetButton = true;
                }
                if (this.active_sort_1 && !this.sort_1) {
                    postData.sortBy = 2;
                    this.resetButton = true;
                }
                if (this.active_sort_2 && this.sort_2) {
                    postData.sortBy = 3;
                    this.resetButton = true;
                }
                if (this.active_sort_2 && !this.sort_2) {
                    postData.sortBy = 4;
                    this.resetButton = true;
                }

                this.filter_data = postData;
                this.init();
            },

            reset() {
                this.roleInDeal = null;
                this.dealState = null;
                this.sortBy = null;
                this.resetButton = false;

                this.active_sort_1 = false;
                this.sort_1 = false;
                this.active_sort_2 = false;
                this.sort_2 = false;

                this.sortByAddress = null;
                this.sortByDate = null;

                this.init();
            },

            dateFormate(date) {
                return echoDateTime(date)
            },

            status(i) {
                return getStatus(i)
            }
        }
    }

</script>

