<template>
    <div id="notaries--page" class="h-100-vh account-content">
        <div class="card--common">
            <div class="card--common__header mb-0">
                <router-link :to="'/account/deals/' + $route.params.id + '/show'">
                    <h3 class="mb-4 mb-lg-0 d-flex align-items-center color-text-dark">
                        <img src="/svg/arrow-left.svg" alt="">
                        Выбор и приглашение нотариуса
                    </h3>
                </router-link>
            </div>



                <div class="card--common__body pt-0">

                    <!--  DESCTOP ITEMS -->
                    <div class="d-none d-md-block">
                        <div class="deals-table">
                            <div class="deals-table__header">
                                <div>Нотариус</div>
                                <div>Нотариальная контора</div>
                                <div>Сделок в работе</div>
                                <div>Закрытыx сделок</div>
                                <div>Язык</div>
                            </div>

                            <div class="deals-table__item" v-for="item in notaries"
                                 v-b-modal.add-notary
                                 @click="notary = item">
                                <div class="d-flex align-items-center">
                                    <div class="img-circle-container mr-3">
                                        <img v-if="item.image" :src="'/' + item.image" alt="">
                                        <img v-else src="/img/defaults/user_default.png" alt="">
                                    </div>
                                    <span> {{item.name}} {{item.surname}}</span>
                                </div>
                                <div>{{item.office_name}}</div>
                                <div>{{item.deals_in_progress}}</div>
                                <div>{{item.closed_deals}}</div>
                                <div v-if="item.language" class="d-flex flex-wrap">
                                    <div v-for="(lang, key) in item.language" :key="key" >
                                        {{lang}}<span v-if="key !== item.language.length - 1" class="d-inline-block pr-1">, </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--  MOBILE ITEMS -->
                    <div v-if="notaries && notaries.length > 0" class="d-md-none d-block">
                        <div class="row">
                            <div class="col-sm-6 mb-4"
                                 v-for="(item, key) in notaries"
                                 :key="key">
                                <div v-b-modal.add-notary
                                     @click="notary = item"
                                     class="notary__card">
                                    <div class="notary__card--header">
                                        <div>
                                            <div class="font-500">
                                                {{item.name}} {{item.surname}}
                                            </div>
                                            <p class="mb-0 color-text-grey">Нотариус</p>
                                        </div>
                                        <img v-if="item.image" :src="'/' + item.image" alt="">
                                        <img v-else src="/img/defaults/user_default.png" alt="">
                                    </div>

                                    <div class="notary__card--body">
                                        <div class="item">
                                            <span>{{item.office_name}}</span>
                                        </div>

                                        <div class="item">
                                            <span class="color-text-light">Сделок в работе:</span>
                                            <span v-if="item.deals_in_progress">{{item.deals_in_progress}}</span>
                                            <span v-else>-</span>
                                        </div>

                                        <div class="item">
                                            <span class="color-text-light">Закрытых сделок:</span>
                                            <span v-if="item.closed_deals">{{item.closed_deals}}</span>
                                            <span v-else>-</span>
                                        </div>

                                        <div class="item">
                                            <span class="color-text-light pr-1">Язык:</span>
                                            <div v-if="item.language" class="d-flex flex-wrap">
                                                <div v-for="(lang, key) in item.language" :key="key" >
                                                    {{lang}}<span v-if="key !== item.language.length - 1" class="d-inline-block pr-1">, </span>
                                                </div>
                                            </div>
                                            <div v-else>-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>





        </div>

        <add-notary :data="notary"></add-notary>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notaries: [],
                notary: null
            }
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                this.loading = true;
                let url = '/api/notary';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                return axios.get(url, options)
                    .then(response => {
                        let notaries = response.data.notaries;
                        notaries.forEach(item => {
                            if(item.language && typeof item.language === 'string') {
                                let lang = item.language;
                                item.language = JSON.parse(lang);
                            }
                            this.notaries.push(item)
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>
