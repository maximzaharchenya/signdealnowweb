<template>
    <div v-if="user" id="account--app">

        <account-sidebar></account-sidebar>
        <account-header></account-header>

        <!--Content-->
        <transition name="page" v-if="!loading">
            <router-view></router-view>
        </transition>

        <div class="load-box over--page" v-if="loading">
            <b-spinner></b-spinner>
        </div>

    </div>


</template>

<script>
    export default {

        data () {
            return {
                loading: true
            }
        },
        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        watch: {
            user() {
                this.init();
            }
        },

        mounted() {
            this.init();
        },


        methods: {
            init() {
                if(this.user) {
                    let user = this.user;

                    if(user.email_check != 1)  {
                        window.location.pathname = "/email/check";
                        return
                    }

                    // if(!user.authentication)  {
                    //     window.location.pathname = "/authentication";
                    //     return
                    // }
                    if(!user.name && this.$route.path !==  '/account/edit')  {
                        this.$router.push({path: '/account/edit'});
                        this.loading = false;
                        return
                    }
                    if(!user.name && this.$route.path ==  '/account/edit') this.loading = false;

                    //if(user.authentication && user.name) this.loading = false;
                    if(user.name) this.loading = false;
                }
            },
        }

    }
</script>
