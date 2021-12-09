<template>

    <div v-if="deal" class="account-content" id="deal-create">
        <div class="row">
            <div class="col-xl-3">
                <div class="card--common">
                    <div class="card--common__header">
                        <router-link :to="'/account/deals/' + $route.params.id + '/show'" class="color-text-dark">
                            <h3 class="mb-0 d-flex align-items-center">
                                <img src="/svg/arrow-left.svg" alt="">
                                Сделка
                                <span v-if="$route.params.id < 10" class="pl-1"> 00{{$route.params.id}}</span>
                                <span v-if="$route.params.id < 100 && $route.params.id > 9 " class="pl-1">0{{$route.params.id}}</span>
                                <span v-if="$route.params.id > 99" class="pl-1"> {{$route.params.id}}</span>

                            </h3>
                        </router-link>
                    </div>

                    <div class="card--common__body pt-2">
                        <ul class="sidebar__filter">

                            <li :class="{'active': active == 1}"
                                @click="setActive('1')">
                                Продавец
                            </li>

                            <button :class="collapse_1 ? 'active' : 'collapsed'"
                                    :aria-expanded="collapse_1 ? 'true' : 'false'"
                                    aria-controls="collapse_1"
                                    @click="collapse_1 = !collapse_1, active_category = 2"
                                    class="collapse-button">
                                <span>Покупатели</span>
                                <img src="/svg/select-btn.svg" alt="">
                            </button>
                            <b-collapse id="collapse_1" v-model="collapse_1">
                                <div class="collapse-card">
                                    <p v-for="item in deal.clients"
                                       v-if="item.role == 2"
                                       @click="setActive('2_' + item.id)"
                                       :class="{'color-text-primary': active == '2_' + item.id}">
                                        {{item.name}} {{item.surname}}
                                    </p>
                                </div>
                            </b-collapse>



                            <li :class="{'active': active == 3}"
                                @click="setActive('3')">
                                Другие участники
                            </li>

                            <li :class="{'active': active == 4}"
                                @click="setActive('4')">
                                Объект недвижимости
                            </li>

                            <li :class="{'active': active == 5}"
                                @click="setActive('5')">
                                Юридические данные продавца
                            </li>


                            <button :class="collapse_2 ? 'active' : 'collapsed'"
                                    :aria-expanded="collapse_2 ? 'true' : 'false'"
                                    aria-controls="collapse_2"
                                    @click="collapse_2 = !collapse_2, active_category = 6"
                                    class="collapse-button">
                                <span>Юридические данные покупателей</span>
                                <img src="/svg/select-btn.svg" alt="">
                            </button>
                            <b-collapse id="collapse_2" v-model="collapse_2">
                                <div class="collapse-card">
                                    <p v-for="item in deal.clients"
                                       v-if="item.role == 2"
                                       @click="setActive('6_' + item.id)"
                                       :class="{'color-text-primary': active == '6_' + item.id}">
                                        {{item.name}} {{item.surname}}
                                    </p>
                                </div>
                            </b-collapse>

                            <li :class="{'active': active == 7}"
                                @click="active = 7, active_category = 0">
                                Дополнительная информация
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-9 documents__form">
                <div>

                    <!--  ПРОДАВЕЦ -->
                    <div  v-if="active == 1">
                        <seller-data @init_data="init"
                                     @approve_data="approveData"
                                     :role="user_role"
                                     :user_role="user_role"
                                     :user_id="deal.seller.id"
                                     :data="deal.additional_seller_data"
                                     :married_data="deal.married_data"
                                     :user_approved="user_approved"
                                     v-if="deal.seller.id == user.id || (deal.seller.id == user_from && user_role == 12)">

                        </seller-data>
                        <seller-data @approve_data="approveData"
                                     :role="deal.seller.role"
                                     :user_role="user_role"
                                     :user_id="deal.seller.id"
                                     :data="deal.additional_seller_data"
                                     :married_data="deal.married_data"
                                     :user_approved="user_approved"
                                     v-else
                                     :disabled="true">
                        </seller-data>
                    </div>


                    <!--  ПОКУПАТЕЛИ -->
                    <div v-for="item in deal.clients">
                        <div v-if="active == '2_' + item.id">
                            <client-data @approve_data="approveData"
                                         @init_data="init"
                                         :role="user_role"
                                         :user_role="user_role"
                                         :user_id="item.id"
                                         :user_approved="user_approved"
                                         :data="deal.additional_client_data"
                                         :deal="deal"
                                         :married_data="deal.married_data"
                                         v-if="item.id == user.id || (item.id == user_from && user_role == 12)">
                            </client-data>
                            <client-data @approve_data="approveData"
                                         :user_role="user_role"
                                         :role="item.role"
                                         :user_id="item.id"
                                         :user_approved="user_approved"
                                         :data="deal.additional_client_data"
                                         :deal="deal"
                                         :married_data="deal.married_data"
                                         v-else
                                         :disabled="true">
                            </client-data>
                        </div>
                    </div>


                    <div v-if="active == 3">
                        <user-data @init_data="init"
                                   @approve_data="approveData"
                                   :user_role="user_role"
                                   :user_approved="user_approved"
                                   :contributors="deal.contributors"
                                   v-if="user_role == 1 || user_role == 2">
                        </user-data>
                        <div v-else class="card--common custom-form">
                            <div class="card--common__header header-sticky">
                                <h3 class="mb-0">Договорной процесс</h3>

                                <button class="btn-small btn-v2 mr-3"
                                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                                        @click="approveData()"
                                        :disabled="user_approved == 1">
                                    <span v-if="user_approved == 1">Изменения одобрены</span>
                                    <span v-else>Одобрить изменения</span>
                                </button>
                            </div>
                            <div class="card--common__body">
                                <div v-if="deal.contributors && deal.contributors.length > 0" v-for="item in deal.contributors" class="mb-40">
                                    <contributors-data :user_role="user_role" :item="item"></contributors-data>
                                </div>

                                <div v-if="deal.contributors && deal.contributors.length < 1">
                                   <p>Данные участника сделки не заполнены.</p>
                                </div>
                            </div>


                        </div>

                    </div>

                    <div v-if="active == 4">
                        <property-data @init_data="init"
                                       @approve_data="approveData"
                                       :deal="deal"
                                       :property="true"
                                       :user_role="user_role"
                                       :user_approved="user_approved"
                                       v-if="user_role == 1">
                        </property-data>
                        <property-data @approve_data="approveData"
                                       :deal="deal"
                                       :user_role="user_role"
                                       :property="true"
                                       v-else
                                       :user_approved="user_approved"
                                       :disabled_item="true">
                        </property-data>
                    </div>

                    <div v-if="active == 5">
                        <seller-legal-data @init_data="init"
                                           @approve_data="approveData"
                                           :user_role="user_role"
                                           :user_approved="user_approved"
                                           :deal="deal"
                                           v-if="user_role == 1 || user_role == 9">
                        </seller-legal-data>
                        <seller-legal-data @approve_data="approveData"
                                           :deal="deal"
                                           :user_role="user_role"
                                           :user_approved="user_approved"
                                           :disabled="true" v-else>
                        </seller-legal-data>
                    </div>


                    <div v-for="item in deal.clients">
                        <div v-if="active == '6_' + item.id">
                            <client-legal-data @approve_data="approveData"
                                               :user_role="user_role"
                                               :user_approved="user_approved"
                                               :user_id="item.id"
                                               v-if="item.id == user.id || (item.id == user_from && user_role == 10)">
                            </client-legal-data>
                            <client-legal-data @approve_data="approveData"
                                               :user_role="user_role"
                                               :user_id="item.id"
                                               :user_approved="user_approved"
                                               :deal="deal"
                                               :disabled="true"
                                               v-else>
                            </client-legal-data>
                        </div>
                    </div>


                    <div v-if="active == 7">
                        <note-data :user_role="user_role"
                                   :user_approved="user_approved">
                        </note-data>
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
    import RequestsServices from '../../../services/requests';

    export default {
        data() {
            return {
                active: 1,
                deal: null,

                users: [],
                seller: null,
                clients: [],

                all_users: [],

                user_role: null,
                user_from: null,
                user_approved: null,

                collapse_1: false,
                collapse_2: false,

                loading: true
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        watch: {
          active() {
              if(this.active_category !== 2) this.collapse_1 = false;
              if(this.active_category == 2) this.collapse_1 = true;

              if(this.active_category !== 6) this.collapse_2 = false;
          }
        },

        mounted() {
            this.init();
        },


        methods: {
            init() {
                if(this.deal && this.deal.contributors) this.deal.contributors = [];
                RequestsServices.deal(this.$route.params.id, this.user.id).then(response => {
                    this.deal = response;
                    this.userRole()
                });

                if(this.$route.query.active) {
                    this.active = this.$route.query.active;
                }
            },

            userRole() {
                this.deal.users.forEach(item => {
                    //устанавливаем активную вкладку по умолчанию для покупателя
                    if (item.id == this.user.id && (item.pivot.user_role == 2 && !this.$route.query.active)) {
                        this.active = item.pivot.user_role + '_' + item.id;
                        this.active_category = 2;
                    }

                    if(item.id == this.user.id) {
                        this.user_role = item.pivot.user_role;
                        this.user_approved = item.pivot.approved;
                    }

                    this.deal.all_users.forEach(user => {
                        if(user.id == this.user.id) this.user_from = user.from;
                    })

                });

                this.loading = false;
            },

            approveData() {
                this.loading = true;
                let url = '/api/deal/' + this.$route.params.id + '/approve';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.get(url, options)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Готово',
                            html: 'Вы одобрили изменения в договоре',
                        }).then(() => {
                            this.init();
                        })
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            setActive(i) {
                if(this.active !== i) {
                    this.active = i;
                    if(i == 1 || i == 3 || i == 4 || i == 5) this.active_category = 0;

                    this.$router.push({ query: { active: i } })
                }

            }

        }


    }
</script>
