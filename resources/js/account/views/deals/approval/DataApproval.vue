<template>
    <div class="account-content" id="data_approval">
        <div class="row">
            <div class="col-xl-3">
                <div class="card--common">
                    <div class="card--common__header">
                        <router-link :to="'/account/deals/' + $route.params.id + '/show'" class="color-text-dark">
                            <h3 class="mb-0 d-flex align-items-center">
                                <img src="/svg/arrow-left.svg" alt="">
                                ID
                                <span v-if="$route.params.id < 10" class="pl-1"> 00{{$route.params.id}}</span>
                                <span v-if="$route.params.id < 100 && $route.params.id > 9 " class="pl-1">0{{$route.params.id}}</span>
                                <span v-if="$route.params.id > 99" class="pl-1"> {{$route.params.id}}</span>

                            </h3>
                        </router-link>
                    </div>


                    <div class="card--common__body" v-if="deal">
                        <!-- ITEMS FOR PARTICIPANTS-->
                        <div class="time__approve__show custom-form" v-if="not_notary">
                            <div class="mb-20 form--item disabled--item">
                                <label  class="color-text-light">Дата подписи</label>
                                <input v-model="postDate.date"
                                       autocomplete="off"
                                       disabled
                                       type="text">
                            </div>

                            <div class="mb-20 form--item disabled--item">
                                <label class="color-text-light">Время подписи</label>
                                <input v-model="postDate.time"
                                       autocomplete="off"
                                       disabled
                                       type="text">
                            </div>
                        </div>

                        <!-- ITEMS FOR NOTARIES-->
                        <ul class="sidebar__filter" v-if="user_role == 3 || user_role == 8">
                            <li v-if="deal.status == 5" :class="{'active': active == 1}"
                                @click="active = 1">
                                Дата и время подписания
                            </li>
                            <li :class="{'active': active == 2}"
                                @click="active = 2">
                                Нотариальные сборы
                            </li>

                            <button :class="collapse_1 ? 'active' : 'collapsed'"
                                    :aria-expanded="collapse_1 ? 'true' : 'false'"
                                    aria-controls="collapse_1"
                                    @click="collapse_1 = !collapse_1, active_category = 2"
                                    class="collapse-button">
                                <span>Договорная информация</span>
                                <img src="/svg/select-btn.svg" alt="">
                            </button>
                            <b-collapse id="collapse_1" v-model="collapse_1">
                                <div class="collapse-card">
                                    <p @click="active = '3_1'" :class="{'color-text-primary': active == '3_1'}">Нотариус</p>
                                    <p @click="active = '3_2'" :class="{'color-text-primary': active == '3_2'}">Продавец</p>

                                    <p class="mb-1 color-text-light cursor-default" v-if="deal.clients.length > 1">Покупатели</p>
                                    <div v-if="deal.clients.length > 1" class="mb-3">
                                        <p v-for="item in deal.clients"
                                           @click="active = '3_3_' + item.id"
                                           class="pl-3 mb-1">
                                            <span :class="{'color-text-primary': active == '3_3_' + item.id}">{{item.name}} {{item.surname}}</span>
                                        </p>
                                    </div>

                                    <p v-if="deal.clients.length == 1"
                                       :class="{'color-text-primary': active == '3_3_' + item.id}"
                                       v-for="item in deal.clients"
                                       @click="active = '3_3_' + item.id">
                                        Покупатель
                                    </p>

                                    <p @click="active = '3_4'" :class="{'color-text-primary': active == '3_4'}">Другие участники</p>
                                    <p @click="active = '3_5'" :class="{'color-text-primary': active == '3_5'}">Объект недвижимости</p>
                                    <p @click="active = '3_6'" :class="{'color-text-primary': active == '3_6'}">Юридические данные продавца</p>


                                    <p class="mb-1 color-text-light cursor-default" v-if="deal.clients.length > 1">Юридические данные покупателей</p>
                                    <div v-if="deal.clients.length > 1" class="mb-3">
                                        <p v-for="item in deal.clients"
                                           @click="active = '3_7_' + item.id"
                                           class="pl-3 mb-1">
                                            <span :class="{'color-text-primary': active == '3_7_' + item.id}">{{item.name}} {{item.surname}}</span>
                                        </p>
                                    </div>

                                    <p v-if="deal.clients.length == 1"
                                       v-for="item in deal.clients"
                                       :class="{'color-text-primary': active == '3_7_' + item.id}"
                                       @click="active = '3_7_' + item.id">
                                        Юридические данные покупателя
                                    </p>

                                    <p @click="active = '3_8'" :class="{'color-text-primary': active == '3_8'}">Дополнительно</p>

                                </div>
                            </b-collapse>

                        </ul>
                    </div>


                </div>
            </div>

            <div class="col-xl-9">
                <div class="card--common" v-if="deal">
                    <div class="card--common__header d-block d-md-flex">
                        <h3 class="mb-3 mb-md-0">
                            <span v-if="user_role == 3 || user_role == 8">Нотариальный процесс</span>
                            <span v-if="not_notary">Согласование даты и времени</span>
                        </h3>

                        <div v-if="not_notary && user_sign_approve == 0" class="d-md-flex">
                            <button class="btn-small btn-v1 mr-3  d-none d-md-block" @click="signApprove(1)">
                                <span class="nowrap">Согласен со временем</span>
                            </button>
                            <button class="btn-small btn-v1 w-100 mb-2 d-md-none d-block" @click="signApprove(1)">
                                <span class="nowrap">Согласен со временем</span>
                            </button>

                            <button class="btn-small btn-v2 d-none d-md-block" @click="signApprove(2)">
                                <span class="nowrap">Нет, не согласен</span>
                            </button>
                            <button class="btn-small btn-v2 w-100 d-md-none d-block" @click="signApprove(2)">
                                <span class="nowrap">Нет, не согласен</span>
                            </button>
                        </div>

                        <div v-if="active == 2">
                            <button class="btn-small btn-v1 d-none d-md-block" @click="saveFees()">Сохранить</button>
                            <button class="btn-small btn-v1 d-block d-md-none w-100" @click="saveFees()">Сохранить</button>
                        </div>

                        <div v-if="(user_role == 3 || user_role == 8) && active !== 1 && active !== 2">
                            <button @click="downloadDoc" class="btn-small btn-v1 d-none d-sm-block">Скачать информацию</button>
                            <button @click="downloadDoc" class="btn-small btn-v1 d-block d-sm-none w-100">Скачать информацию</button>
                        </div>
                    </div>



                    <!--  ACTIVE - 1 -->
                    <div class="card--common__body" v-if="active == 1">

                        <div v-if="user_role == 3 || user_role == 8" class="mb-40">
                            <h5 class="mb-3">Выбор даты и времени</h5>

                            <div class="row custom-form align-items-center">
                                <div class="col-6 col-sm-4">
                                    <div class="mb-20 form--item">
                                        <label for="date__approve" class="color-text-light">Дата подписи</label>
                                        <input id="date__approve"
                                               placeholder="##.##.####"
                                               v-mask="'##.##.####'"
                                               autocomplete="off"
                                               v-model="postDate.date"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve" class="color-text-light">Время подписи</label>
                                        <input id="time__approve"
                                               placeholder="##:##"
                                               v-mask="'##:##'"
                                               autocomplete="off"
                                               v-model="postDate.time"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <button class="btn-small btn-v1 d-none d-sm-block" @click="setDateOfSigning()">Согласовать</button>
                                    <button class="btn-small btn-v1 w-100 d-block d-sm-none" @click="setDateOfSigning()">Согласовать</button>
                                </div>
                            </div>
                        </div>

                        <h5 class="mb-3">Подтверждение даты и времени</h5>
                        <p class="color-text-grey mb-40">
                            Каждый участник сделки должен согласиться с предложенным вариантом и тем самым финально подтвердить дату и время подписания текущей версии договора.
                            <span v-if="user_role == 3 || user_role == 8">Вы можете предложить новую дату подписание при необходимости даже после согласования.</span>
                            <span v-else>Здесь вы можете посмотреть согласие других участников на предложенное время и дату.</span>
                        </p>

                        <div class="deals-table time__approve--table" v-if="deal">
                            <div class="deals-table__header">
                                <div>ID</div>
                                <div>Участник</div>
                                <div>Роль</div>
                                <div>Согласие со временем</div>
                            </div>
                            <div class="deals-table__item"
                                 v-if="item.role !== 3 && item.role !== 8"
                                 v-for="(item, key) in deal.all_users" :key="key">
                                <div class="d-none d-md-block">{{key+1}}</div>
                                <div class="d-md-flex align-items-center">
                                    <div class="img-circle-container mr-3 d-none d-md-block">
                                        <img v-if="item.profile_image" :src="'/storage/' + item.profile_image" alt="">
                                        <img v-else src="/svg/user-default-36.svg" alt="">
                                    </div>
                                    <span class="mb-2 mb-md-0">{{item.name}} {{item.surname}}</span>
                                    <div class="d-block d-md-none small color-text-grey">{{role(item.role)}}</div>
                                </div>
                                <div class="d-none d-md-block">{{role(item.role)}}</div>
                                <div>
                                    <span v-if="item.sign_approved == 0" class="d-flex align-items-center">
                                        <img src="/svg/info-wait.svg" alt="" class="mr-2">
                                        Нет ответа
                                    </span>
                                    <span v-if="item.sign_approved == 1" class="d-flex align-items-center">
                                        <img src="/svg/info-yes.svg" alt="" class="mr-2">
                                        Да, согласен
                                    </span>
                                    <span v-if="item.sign_approved == 2" class="d-flex align-items-center">
                                        <img src="/svg/info-no.svg" alt="" class="mr-2">
                                        Нет, не согласен
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  ACTIVE - 2 -->
                    <div class="card--common__body" v-if="active == 2">
                        <div class="custom-form row align-items-end">
                            <div class="col-sm-6" v-for="item in postFees">
                                <div class="mb-20 form--item">
                                    <label :for="item.id">
                                        {{item.title}}
                                    </label>
                                    <input :id="item.id"
                                           v-model="item.value"
                                           autocomplete="off"
                                           type="text">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <h5 class="mb-2">Дополнительный сбор</h5>
                            <button class="btn-small btn-v2 mb-2" @click="addFeesField()">
                                <span class="nowrap">Добавить сбор</span>
                            </button>
                        </div>
                    </div>


                    <div class="documents__form">
                        <!--  ACTIVE - 3_1 -->
                        <div class="card--common__body" v-if="active == '3_1'">
                            <h5 class="mb-20">Основная информация</h5>
                            <div class="row custom-form mb-20">
                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Имя</label>
                                        <input id="time__approve"
                                               v-model="notaryData.name"
                                               autocomplete="off"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Фамилия</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.surname"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Имя Фамилия ассистента нотариуса</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.name_surname_assistant"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Номер служебной деятельности</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.service_activity_number"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Год служебной деятельности</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.year_of_service"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Имя Фамилия помощника судьи</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.name_surname_assistant_judge"
                                               type="text">
                                    </div>
                                </div>

                            </div>

                            <h5 class="mb-20">Данные о нотариальном бюро</h5>
                            <div class="row custom-form mb-20">
                                <div class="col-12">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Нотариальное бюро</label>
                                        <input id="time__approve"
                                               v-model="notaryData.notary_office"
                                               autocomplete="off"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Регион нотариального бюро</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.region_notary_office"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Город</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.city_notary_office"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item">
                                        <label for="time__approve">Адрес (улица, дом)</label>
                                        <input id="time__approve"
                                               autocomplete="off"
                                               v-model="notaryData.address_notary_office"
                                               type="text">
                                    </div>
                                </div>

                            </div>

                            <div class="text-right">
                                <button class="btn-small btn-v2" @click="saveNotaryData()">Сохранить</button>
                            </div>
                        </div>

                        <!--  ACTIVE - 3_2 -->
                        <div class="card--common__body" v-if="active == '3_2'">
                            <seller-data :role="deal.seller.role"
                                         :user_role="user_role"
                                         :user_id="deal.seller.id"
                                         :data="deal.additional_seller_data"
                                         :married_data="deal.married_data"
                                         :show_for_notary="true"
                                         :disabled="true">
                            </seller-data>
                        </div>

                        <!--  ACTIVE - 3_3 -->
                        <div class="card--common__body" v-for="item in deal.clients" v-if="active == '3_3_' + item.id">
                            <client-data :user_role="user_role"
                                         :role="item.role"
                                         :user_id="item.id"
                                         :data="deal.additional_client_data"
                                         :deal="deal"
                                         :show_for_notary="true"
                                         :married_data="deal.married_data"
                                         :disabled="true">
                            </client-data>
                        </div>

                        <!--  ACTIVE - 3_4 -->
                        <div class="card--common__body" v-if="active == '3_4'">
                            <div class="custom-form">
                                <div v-if="deal.contributors && deal.contributors.length > 0" v-for="item in deal.contributors" class="mb-40">
                                    <contributors-data :user_role="user_role" :item="item"></contributors-data>
                                </div>

                                <div v-if="deal.contributors && deal.contributors.length < 1">
                                    <p>Данные участника сделки не заполнены.</p>
                                </div>
                            </div>
                        </div>

                        <!--  ACTIVE - 3_5 -->
                        <div class="card--common__body" v-if="active == '3_5'">
                            <property-data :deal="deal"
                                           :user_role="user_role"
                                           :show_for_notary="true"
                                           :property="true"
                                           :disabled_item="true">
                            </property-data>
                        </div>

                        <!--  ACTIVE - 3_6 -->
                        <div class="card--common__body" v-if="active == '3_6'">
                            <seller-legal-data :deal="deal"
                                               :user_role="user_role"
                                               :show_for_notary="true"
                                               :disabled="true">
                            </seller-legal-data>
                        </div>

                        <!--  ACTIVE - 3_7 -->
                        <div class="card--common__body" v-for="item in deal.clients" v-if="active == '3_7_' + item.id">
                            <client-legal-data :user_role="user_role"
                                               :user_id="item.id"
                                               :deal="deal"
                                               :show_for_notary="true"
                                               :disabled="true">
                            </client-legal-data>
                        </div>

                        <!--  ACTIVE - 3_8 -->
                        <div class="card--common__body pt-0" v-if="active == '3_8'">
                            <note-data :user_role="user_role"
                                       :show_for_notary="true">
                            </note-data>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {getRole} from '../../../../services/functions';
    import RequestsServices from '../../../../services/requests';
    import fileDownload from 'js-file-download';

    export default {
        data() {
            return {
                loading: true,

                deal: null,
                user_role: null,
                user_sign_approve: null,
                not_notary: false,

                postDate: {
                    date: null,
                    time: null,
                },

                postFees: [
                    {id: 1, title: 'Сбор за составление договора', value: ''},
                    {id: 2, title: 'Сбор за снятие ипотеки со стороны банка застройщика', value: ''},
                    {id: 3, title: 'Сбор за составление договора с наложением ипотеки', value: ''},
                    {id: 4, title: 'Общая стоимость нотариальных сборов', value: ''},
                    {id: 5, title: 'Налог НДС', value: ''},
                    {id: 6, title: 'Общая стоимость нотариальных сборов с НДС', value: ''},
                    {id: 7, title: 'Государственная пошлина за наложение ипотеки на объект', value: ''},
                    {id: 8, title: 'Пошлина за внесение собственника в крепостную книгу', value: ''},
                    {id: 9, title: 'Пошлина за частичное удаление ипотеки', value: ''},
                ],

                active: null,
                collapse_1: false,

                notaryData: {
                    name: null,
                    surname: null,
                    name_surname_assistant: null,
                    service_activity_number: null,
                    year_of_service: null,
                    name_surname_assistant_judge: null,
                    notary_office: null,
                    region_notary_office: null,
                    city_notary_office: null,
                    address_notary_office: null,
                }
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        mounted() {
            this.init();
        },

        watch: {
            active() {
                if(this.active == 1 || this.active == 2) this.collapse_1 = false;
            }
        },

        methods: {
            init() {
                RequestsServices.deal(this.$route.params.id, this.user.id).then(response => {
                    this.deal = response;
                    this.loading = false;
                    this.userRole();

                    if(this.deal.sign_info) {
                        this.postDate.date = this.deal.sign_info.date;
                        this.postDate.time = this.deal.sign_info.time;
                    }

                    if(this.deal.notary_fees) {
                        this.deal.notary_fees.forEach(item => {
                            let i = JSON.parse(item);
                            this.postFees.forEach(data => {
                                if(data.id == i.id) data.value = i.value;
                            });
                            if(i.id > 9) this.postFees.push(i)
                        });
                    }

                    if(this.deal.status == 5) this.active = 1;
                    if(this.deal.status == 6) this.active = 2;

                    if(deal.notary_data) {
                        if (deal.notary_data.name) this.notaryData.name = deal.notary_data.name;
                        if (deal.notary_data.surname) this.notaryData.surname = deal.notary_data.surname;
                        if (deal.notary_data.name_surname_assistant) this.notaryData.name_surname_assistant = deal.notary_data.name_surname_assistant;
                        if (deal.notary_data.service_activity_number) this.notaryData.service_activity_number = deal.notary_data.service_activity_number;
                        if (deal.notary_data.year_of_service) this.notaryData.year_of_service = deal.notary_data.year_of_service;
                        if (deal.notary_data.name_surname_assistant_judge) this.notaryData.name_surname_assistant_judge = deal.notary_data.name_surname_assistant_judge;
                        if (deal.notary_data.notary_office) this.notaryData.notary_office = deal.notary_data.notary_office;
                        if (deal.notary_data.region_notary_office) this.notaryData.region_notary_office = deal.notary_data.region_notary_office;
                        if (deal.notary_data.city_notary_office) this.notaryData.city_notary_office = deal.notary_data.city_notary_office;
                        if (deal.notary_data.address_notary_office) this.notaryData.address_notary_office = deal.notary_data.address_notary_office;
                    }
                });
            },

            userRole() {
                this.deal.all_users.forEach(item => {
                    if(item.id == this.user.id) {
                        if(item.role !== 3 && item.role !== 8) this.not_notary = true;
                        this.user_role = item.role;
                        this.user_sign_approve = item.sign_approved;
                    }
                });
            },

            setDateOfSigning() {
                let formData = new FormData();

                for (let key in this.postDate)
                    if (this.postDate[key]) formData.append(key, this.postDate[key]);

                let url = '/api/deal/' + this.$route.params.id + '/sign_info';
                const options = {
                    params: {
                        date: this.postDate.date,
                        time: this.postDate.time,
                    },
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.get(url, options)
                    .then(response => {
                        if(response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Дата и время сделки успешно назначены!',
                            }).then(() => {
                                this.init();
                            })
                        }
                    })

                    .finally(() => {
                        this.loading = false;
                    })
            },

            addFeesField() {
                Swal.fire({
                    input: 'text',
                    title: 'Заполните',
                    html: 'Какой сбор Вы хотите добавить?',
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        let count = this.postFees.length + 1;
                        let field = {
                            additional: true,
                            id: count,
                            title: result.value,
                            value: ''
                        };
                        this.postFees.push(field);
                    }
                })
            },

            saveFees() {
                let data = [];
                let value = false;
                this.postFees.forEach(item => {
                    if(item.value) {
                        data.push(item);
                        value = true;
                    }
                });

                if(!value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: 'Вы не внесли данные',
                    });

                    return;
                }

                if(value) {
                    let url = '/api/deal/' + this.$route.params.id + '/notary_fees';

                    const options = {
                        params: data,
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };

                    axios.get(url, options)
                        .then(response => {
                            if(response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Данные успешно сохранены!',
                                })
                            }
                        })

                        .finally(() => {
                            this.loading = false;
                        })


                }
            },

            signApprove(item) {
                let url;
                if(item == 1) url = '/api/deal/' + this.$route.params.id + '/sign_approve';
                if(item == 2) url = '/api/deal/' + this.$route.params.id + '/sign_disagree';

                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.get(url, options)
                    .then(response => {
                        if(response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Данные успешно сохранены!',
                            }).then(() => {
                                this.$router.push({path: '/account/deals/' + this.$route.params.id + '/show'});
                            })
                        }
                    })

                    .finally(() => {
                        this.loading = false;
                    })

            },

            saveNotaryData() {
                let url = '/api/deal/' + this.$route.params.id + '/notary_data';

                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                let formData = new FormData();
                for (let key in this.notaryData) {
                    if (this.notaryData[key]) formData.append(key, this.notaryData[key]);
                }

                axios.post(url, formData,  options)
                    .then(response => {
                        if(response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Данные успешно сохранены!',
                            })
                        }
                    })

                    .finally(() => {
                        this.loading = false;
                    })
            },

            downloadDoc() {
                let url = '/api/deal/' + this.$route.params.id + '/documents/generate';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };


                axios({url: url, options, method: 'GET', responseType: 'blob'})
                    .then(response => {
                        fileDownload(response.data, 'info.pdf')
                    });
            },

            role(i) {
                return getRole(i)
            }
        }
    }
</script>
