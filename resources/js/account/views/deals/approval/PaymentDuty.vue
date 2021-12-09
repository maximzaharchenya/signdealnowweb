<template>
    <div class="card--common h-100-vh account-content" v-if="fees" id="fees__user">
        <div class="card--common__header">
            <router-link :to="'/account/deals/' + $route.params.id + '/show'" class="color-text-dark">
                <h3 class="mb-0 d-flex align-items-center">
                    <img src="/svg/arrow-left.svg" alt="">
                    <span>Оплата услуг, пошлины</span>
                </h3>
            </router-link>

            <div class="d-none d-md-block">
                <button class="btn-small btn-v2 mr-3" @click="approveData()" v-if="!fees_approved">Одобрить изменения</button>
                <button class="btn-small btn-v2 mr-3" disabled v-if="fees_approved">Изменения одобрены</button>

                <button class="btn-small btn-v1" @click="feesData()">Сохранить</button>
            </div>
        </div>

        <div class="card--common__body">

            <div class="row custom-form">
                <div class="col-xl-6 mb-20" v-for="item in fees">
                    <div class="row no-gutters align-items-end">
                        <div class="col-7">
                            <div class="form--item disabled--item">
                                <label :for="item.id">
                                    {{item.title}}
                                </label>
                                <input :id="item.id"
                                       disabled
                                       v-model="item.value"
                                       autocomplete="off"
                                       type="text">
                            </div>
                        </div>
                        <div class="col-5">
                            <multiselect v-model="item.payment"
                                         :options="payment_options"
                                         placeholder="Не выбрано"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         selected-label=""
                                         select-label="">
                            </multiselect>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-block d-md-none">
                <button class="btn-small btn-v2 w-100" @click="approveData()" v-if="!fees_approved">Одобрить изменения</button>
                <button class="btn-small btn-v2 w-100" disabled v-if="fees_approved">Изменения одобрены</button>
            </div>
        </div>

        <div class="mobile-footer-btn-container">
            <button class="btn-small btn-v1 w-100" @click="feesData()">Сохранить</button>
        </div>

    </div>
</template>

<script>
    import RequestsServices from '../../../../services/requests';
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Multiselect
        },
        data() {
            return {
                fees: [],
                payment_options: [
                    'Оплата продавцом', 'Оплата покупателем', 'Оплата 50 на 50'
                ],
                fees_approved: null
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
                RequestsServices.deal(this.$route.params.id, this.user.id).then(response => {
                    let deal = response;

                    if(deal.fees) {
                        let fees = response.fees;
                        fees.forEach(item => {
                            item = JSON.parse(item);
                            this.fees.push(item)
                        });
                    }

                    else {
                        let fees = response.notary_fees;
                        fees.forEach(item => {
                            item = JSON.parse(item);
                            item.payment = null;
                            this.fees.push(item)
                        });
                    }

                    if(deal.users) {
                        deal.users.forEach(item => {
                            if(item.pivot.user_id == this.user.id) this.fees_approved = item.pivot.fees_approved
                        })
                    }

                    this.loading = false;
                });
            },

            feesData() {
                let value = true;
                this.fees.forEach(item => {
                    if(!item.payment) {
                        value = false;
                    }
                });

                if(!value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: 'Вы не внесли все данные',
                    });

                    return;
                }

                if(value) {
                    let url = '/api/deal/' + this.$route.params.id + '/fees';

                    const options = {
                        params: this.fees,
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

                }
            },

            approveData() {
                let url = '/api/deal/' + this.$route.params.id + '/fees_approve';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };
                axios.get(url, options)
                    .then(response => {
                        if(response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Вы одобрили изменения',
                            }).then(() => {
                                this.$router.push({path: '/account/deals/' + this.$route.params.id + '/show'});
                            })
                        }
                    })

                    .finally(() => {
                        this.loading = false;
                    })

            }
        }
    }
</script>
