<template>
    <div :class="{'auth--wrap': auth_page, 'common--page': common_page}">

        <!--Content-->
        <transition name="page">
            <router-view></router-view>
        </transition>

    </div>
</template>

<script>
    export default {
        props: ['external_deal'],

        data() {
            return {
                auth_page: false,
                common_page: false,
            }
        },

        watch: {
            $route() {
                this.checkRoute();
            }
        },

        mounted() {
            if(this.external_deal) localStorage.setItem('external_deal', JSON.stringify(this.external_deal));
            this.checkRoute();
        },

        methods: {
            checkRoute() {
                if(this.$route.name === 'register' || this.$route.name === 'login' || this.$route.name === 'reset' || this.$route.name === 'support' || this.$route.name === 'authentication') {
                    this.auth_page = true;
                    this.common_page = false;
                }
                else {
                    this.auth_page = false;
                    this.common_page = true;
                }
            }
        }
    }
</script>
