<template>
    <div :class="{'card--common': !show_for_notary}" class="h-100-vh">
        <div class="card--common__header header-sticky" v-if="!show_for_notary">
            <h3 class="mb-0">Договорной процесс</h3>

            <div>
                <button class="btn-small btn-v2 mr-3 d-none d-md-inline-block"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
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
            <user-common-data @edit_page="editPage" @init_data="initDealData" :data="data" :check_mortgage="true" :user_id="user_id" :role="role" :married_data="married_data"  :disabled_item="disabled" :url="url" ref="userCommonData"></user-common-data>

            <div class="d-block d-md-none">
                <button class="btn-small btn-v2 text-center w-100"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
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
        props: ['data', 'married_data', 'disabled', 'role', 'user_id', 'user_approved', 'user_role', 'show_for_notary'],

        data() {
            return {
                url: '/api/deal/' + this.$route.params.id + '/additional_seller_data',
                edit_page: false
            }
        },

        methods: {
            saveData() {
                this.$refs.userCommonData.saveData();
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
