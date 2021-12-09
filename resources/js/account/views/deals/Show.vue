<template>
    <div v-if="deal" id="deal-show">


        <timing-show v-if="deal.status == 6 || deal.status == 7" :deal="deal" :sign_info="deal.sign_info"></timing-show>


        <div class="deal-create-grid">
            <div>
                <div class="deal-show-card mb-30">
                    <div class="deal-image">
                        <img v-if="deal.image" :src="'/storage/' + deal.image" alt="">
                        <img v-else src="/img/defaults/deal.jpg" alt="">
                    </div>
                    <div class="card--common h-auto">
                        <div class="card--common__header small-header">
                            <h3 class="mb-0">ID
                                <span v-if="deal.id < 10">00{{deal.id}}</span>
                                <span v-else-if="deal.id < 100 && deal.id > 9">0{{deal.id}}</span>
                                <span v-else>00{{deal.id}}</span>
                            </h3>

                            <button @click="exitDeal()" class="btn-small btn-v2">Выйти из сделки</button>
                        </div>

                        <div class="card--common__body h-auto">
                            <div class="row">
                                <div class="col-sm-5 col-xl-3">
                                    <p class="mb-1 color-text-light">Тип сделки</p>
                                    <p class="mb-3">
                                        <span v-if="deal.type == 1">Продажа</span>
                                        <span v-if="deal.type == 2">Покупка</span>
                                    </p>
                                </div>
                                <div class="col-sm-7 col-xl-9">
                                    <p class="mb-1 color-text-light">Статус</p>
                                    <p class="mb-3">
                                        {{status(deal.status)}}
                                    </p>
                                </div>

                                <div class="col-sm-5 col-xl-3 mb-3 mb-xl-0">
                                    <p class="mb-1 color-text-light">Страна</p>
                                    <p class="mb-0">{{deal.country}}</p>
                                </div>
                                <div class="col-sm-7 col-xl-4 mb-3 mb-xl-0">
                                    <p class="mb-1 color-text-light">Город</p>
                                    <p class="mb-0">{{deal.city}}</p>
                                </div>

                                <div class="col-12 col-xl-5">
                                    <p class="mb-1 color-text-light">Точный адрес</p>
                                    <p class="mb-0">{{deal.address}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <deal-show-details :deal="deal" :statuses="statuses" :user_role="user_role" class="mb-30"></deal-show-details>

                <!-- CHAT -->
                <chat-index v-if="deal.status != 1" :document_id="deal.id"></chat-index>

            </div>

            <div>
                <div class="deal-image__laptop">
                    <img v-if="deal.image" :src="'/storage/' + deal.image" alt="">
                    <img v-else src="/img/defaults/deal.jpg" alt="">
                </div>

                <div class="card--common mb-30 h-auto">
                    <div class="card--common__header small-header">
                        <h5 class="mb-0 font-600">Основные участники</h5>
                    </div>

                    <div class="card--common__body">


                        <div v-for="item in deal.all_users" v-if="item.role == 1 || item.role == 2">

                            <div class="mb-24 d-flex">
                                <div class="mr-2">
                                    <div class="img-circle-container">
                                        <img v-if="item.profile_image" :src="'/storage/' + item.profile_image" alt="">
                                        <img v-else src="/svg/user-default-36.svg" alt="">
                                    </div>
                                </div>
                                <div>
                                    <p class="font-500 mb-0">{{item.name}} {{item.surname}}</p>
                                    <p class="small color-text-grey mb-0">
                                        <span v-if="item.role == 1">Продавец</span>
                                        <span v-if="item.role == 2">Покупатель</span>
                                    </p>
                                </div>
                            </div>

                            <hr>
                        </div>
                    </div>

                </div>

                <div class="card--common h-auto mb-30" v-if="deal.status != 1">
                    <div class="card--common__header small-header">
                        <h5 class="mb-0 font-600">Другие участники</h5>
                    </div>

                    <div class="card--common__body">

                        <div v-for="item in deal.other_users" v-if="item.role !== 1 && item.role !== 2" class="deal-users-card">

                            <div class="mb-24 d-flex">
                                <div class="mr-2">
                                    <div class="img-circle-container">
                                        <img v-if="item.profile_image" :src="'/storage/' + item.profile_image" alt="">
                                        <img v-else src="/svg/user-default-36.svg" alt="">
                                    </div>
                                </div>
                                <div>
                                    <p class="font-500 mb-0">{{item.name}} {{item.surname}}</p>
                                    <p class="small color-text-grey mb-0">
                                        {{role(item.role)}}
                                    </p>

                                </div>
                            </div>

                            <div class="close"
                                 @click="deleteUser(item)"
                                 v-if="(user_role == 1 || user_role == 2) && item.from == user.id && item.role !== 3">
                                <img src="/svg/close-small.svg" alt="">
                            </div>

                            <hr>
                        </div>


                        <div v-if="other_contributors_count == 0">
                            <div class="mb-24 d-flex">
                                <div class="mr-2">
                                    <div class="img-circle-container">
                                        <img src="/svg/user-default-36.svg" alt="">
                                    </div>
                                </div>
                                <div>
                                    <p class="font-500 mb-0">Имя Фамилия</p>
                                    <p class="small color-text-grey mb-0">Роль участника</p>
                                </div>
                            </div>

                            <hr>
                        </div>


                        <button class="btn-small btn-v2" v-b-modal.add-user v-if="deal.status !== 1 && (user_role == 1 || user_role == 2)">
                            Добавить участника
                        </button>

                    </div>
                </div>


                <div class="card--common h-auto mb-30 pt-4 pt-lg-0 d-none d-md-block" v-if="deal.status != 1">
                    <div class="card--common__header small-header">
                        <h5 class="mb-0 font-600">Видеозвонки</h5>
                    </div>

                    <div class="card--common__body">
                        <router-link :to="'/account/deals/' + $route.params.id + '/video'" class="color-primary text-underline">Присоединиться</router-link>
                    </div>
                </div>
            </div>

        </div>

        <add-user :id="deal.id"></add-user>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>

        <div class="mobile-footer-btn-container" v-if="deal.status != 1">
            <router-link :to="'/account/deals/' + $route.params.id + '/video'" class="btn-small btn-v1 w-100 text-center">Видеозвонок</router-link>
        </div>

    </div>
</template>

<script>
    import RequestsServices from '../../../services/requests';
    import {getStatus, getRole} from '../../../services/functions';

    export default {
        data() {
            return {
                loading: true,

                deal: null,
                users: [],
                other_contributors_count: 0,

                user_role: null,
                statuses: null
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            },
            channel() {
                return Echo.join(`room.${this.deal.id}`);
            },
        },

        mounted() {
            this.init(true);
        },

        methods: {
            init(connect_to_channel) {
                this.deal = null;
                this.loading = true;
                RequestsServices.deal(this.$route.params.id, this.user.id).then(response => {
                    this.deal = response;
                    this.loading = false;
                    this.userRole();
                    this.checkStatus();
                    if(connect_to_channel) this.connectToChat();
                });
            },

            connectToChat() {
                this.channel
                    .here(users => this.users = users)
                    .joining(user => this.users.push(user))
                    .leaving(user => this.users.splice(this.users.indexOf(user), 1))
                    .listen('MessageEvent', (event) => EventHandler.$emit('new_message', event))
                    .listen('DocumentUpdatedEvent', (event) => {
                        this.init(false);
                    })
                    .listenForWhisper('typing', (event) => {
                        if (!this.typingUser) this.typingUser = event.name;
                        if (this.typingTimer) clearTimeout(this.typingTimer)

                        this.typingTimer = setTimeout(() => {
                            this.typingUser = null
                        }, 2000)
                    })
            },

            userRole() {
                this.deal.all_users.forEach(item => {
                    if(item.id == this.user.id) this.user_role = item.role
                });
            },

            checkStatus() {
                let url = '/api/deal/' + this.$route.params.id +'/check/statuses';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.get(url, options)
                    .then(response => {
                        if (response.status == 200) {
                            if(this.deal.status == 2) {
                                let all_done = true
                                response.data.forEach(status => {
                                    if(status.approved != true || status.fullness != true) all_done = false;
                                });
                                if(all_done) location.reload();
                            }

                            this.statuses = response.data
                        }
                    })
            },

            exitDeal() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Внимание',
                    html: 'Вы уверены, что хотите выйти из сделки?',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    confirmButtonText: `Выйти`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '/api/deal/' + this.$route.params.id +'/exit';
                        const options = {
                            headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                        };

                        axios.get(url, options)
                            .then(response => {
                                if (response.status == 200) {
                                    this.$router.push({name: 'account-deals'});
                                }
                            })
                    }
                })
            },

            deleteUser(item) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Внимание',
                    html: 'Вы уверены, что хотите удалить пользователя из сделки?',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    confirmButtonText: `Удалить`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.loading = true;
                        let url = '/api/deal/' + this.$route.params.id +'/user/delete';
                        const options = {
                            headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                        };

                        axios.post(url, {'user_id': item.id}, options)
                            .then(response => {
                                if (response.status == 200) this.init(false);
                            })
                    }
                })
            },

            status(i) {
                return getStatus(i)
            },

            role(i) {
                return getRole(i)
            }
        }
    }
</script>
