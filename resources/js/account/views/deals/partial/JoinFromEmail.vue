<template>

    <div v-if="description">
        <div id="register_deal_user">
            <div class="card--register--deal--user">
                <div class="image">
                    <img src="/img/defaults/deal.jpg" alt="">
                </div>
                <div class="card--body">
                    <h4 class="mb-40" v-if="user">
                        {{user.name}} {{user.surname}},
                        вас пригласили в сделку
                        <span v-if="description.id < 10">00{{description.id}}.</span>
                        <span v-else-if="description.id < 100 && description.id > 9">0{{description.id}}.</span>
                        <span v-else>00{{description.id}}.</span>

                    </h4>

                    <div class="mb-40">
                        <div class="row">
                            <div class="col-6 color-text-grey">Тип сделки</div>
                            <div class="col-6">{{description.type}}</div>
                        </div>
                        <hr class="mt-2 mb-2">

                        <div class="row">
                            <div class="col-6 color-text-grey">Страна</div>
                            <div class="col-6">{{description.country}}</div>
                        </div>
                        <hr class="mt-2 mb-2">

                        <div class="row">
                            <div class="col-6 color-text-grey">Город</div>
                            <div class="col-6">{{description.city}}</div>
                        </div>
                        <hr class="mt-2 mb-2">

                        <div class="row">
                            <div class="col-6 color-text-grey">Адрес</div>
                            <div class="col-6">{{description.address}}</div>
                        </div>
                        <hr class="mt-2 mb-0">
                    </div>

                    <div class="buttons">
                        <button class="btn-large btn-v1 mr-4" @click="registerDealUser()">Принять приглашение</button>
                        <button class="btn-large btn-v2" @click="cancelRegisterDealUser()">Отклонить</button>
                    </div>
                </div>


            </div>

        </div>
    </div>

</template>


<script>
    export default {
        data() {
            return {
                description: null,
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

        methods: {
            init() {
                let url = '/api/deal/' + this.$route.params.id + '/description';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.get(url, options)
                    .then(response => {
                        if (response.status == 200) {
                            let description = response.data;
                            if (description.type == 1) description.type = 'Покупка-продажа';
                            if (description.type == 2) description.type = 'Бронирование';
                            this.description = description;
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            registerDealUser() {
                let pin = localStorage.getItem('pin');
                let url = '/api/deal/register';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.post(url, {pin: pin}, options)
                    .then(response => {
                        if (response.status == 200) {
                            localStorage.removeItem('pin');
                            localStorage.removeItem('pin_id');
                            this.$router.push({name: 'account-deals'})
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            cancelRegisterDealUser() {
                localStorage.removeItem('pin');
                localStorage.removeItem('pin_id');
                this.$router.push({name: 'account'})
            }
        }
    }
</script>
