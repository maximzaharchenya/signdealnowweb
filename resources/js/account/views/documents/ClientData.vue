<template>
    <div :class="{'card--common': !show_for_notary}" class="h-100-vh">
        <div class="card--common__header header-sticky" v-if="!show_for_notary">
            <h3 class="mb-0">Договорной процесс</h3>

            <div>
                <button class="btn-small btn-v2 mr-3 d-none d-md-inline-block"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        @click="approveData()"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
                <button class="btn-small btn-v1 d-none d-md-inline-block" @click="saveData()" v-if="!disabled">
                    <span v-if="edit_page">Сохранить изменения</span>
                    <span v-if="!edit_page">Сохранить</span>
                </button>
            </div>

        </div>

        <div :class="{'card--common__body': !show_for_notary}">

            <user-common-data :role="role"
                              :data="data"
                              :url="url_client"
                              :user_id="user_id"
                              :married_data="married_data"
                              :disabled_item="disabled"
                              ref="userCommonData"
                              @user_data_validation="userDataValidation"
                              @init_data="initDealData"
                              @edit_page="editPage"
                              :check_mortgage="mortgage_data_valid">

            </user-common-data>


            <div v-if="data_mortgage && data_mortgage.length > 0">
                <div v-for="item in data_mortgage">
                    <mortgage-show-data @init_data="initDealData" :data="item" :user_id="user_id" v-if="item.user_id == user_id"></mortgage-show-data>
                </div>

            </div>

            <div v-if="mortgage_property" class="custom-form">
                <mortgage-common-data :url="url_mortgage"
                                      :disabled_item="disabled"
                                      :user_id="user_id"
                                      @mortgage_validation="mortgageValidation"
                                      ref="propertyCommonData"
                                      @init_data="initDealData"
                                      :check_user_data="user_data_valid">
                </mortgage-common-data>
            </div>

            <div v-if="!mortgage_property && user_id == user.id" class="mb-20">
                <hr>

                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <p class="mb-2 font-500">Залоговая недвижимость</p>

                    <button class="btn-small btn-v2 mb-2" @click="mortgage_property = true, mortgage_data_valid = false">
                        <span class="nowrap">Добавить залог</span>
                    </button>
                </div>
            </div>

            <div class="d-block d-md-none">
                <button class="btn-small btn-v2 w-100"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        @click="approveData()"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
            </div>

        </div>

        <div class="mobile-footer-btn-container" v-if="!disabled">
            <button class="btn-small btn-v1 w-100" @click="saveData()">
                <span v-if="edit_page">Сохранить изменения</span>
                <span v-if="!edit_page">Сохранить</span>
            </button>
        </div>
    </div>

</template>


<script>

    export default {
        props: ['data', 'deal', 'married_data', 'disabled', 'role', 'user_id', 'user_role', 'user_approved', 'show_for_notary'],

        data() {
            return {
                active: 1,
                data_mortgage: null,
                url_client: '/api/deal/' + this.$route.params.id + '/additional_client_data',
                url_mortgage: '/api/deal/' + this.$route.params.id + '/mortgage',

                mortgage_property: false,

                user_data_valid: false,
                mortgage_data_valid: true,

                edit_page: false
            }
        },

        watch: {
            data() {
                this.init();
            }
        },

        mounted() {
            this.init();
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },


        methods: {
            init() {
                if(this.deal.mortgages) {
                    this.data_mortgage = this.deal.mortgages;
                }
            },

            saveData() {
                this.$refs.userCommonData.saveData();
                if(this.mortgage_property) this.$refs.propertyCommonData.saveData();
            },

            mortgageValidation(received_data) {
                this.mortgage_data_valid = received_data
            },
            userDataValidation(received_data) {
                this.user_data_valid = received_data
            },

            initDealData() {
                this.$emit('init_data', true);
            },

            approveData() {
                this.$emit('approve_data', true);
            },
            editPage(event) {
                this.edit_page = event
            }
        }
    }
</script>
