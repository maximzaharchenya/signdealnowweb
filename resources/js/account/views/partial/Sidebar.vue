<template>
    <div class="sidebar--left">
        <div class="logo--box text-center">
            <router-link to="/account" v-if="user.name">
                <img src="/svg/logo_dark.svg" alt="Сервис дигитализации  покупки и продажи недвижимости" class="img-fluid">
            </router-link>
            <router-link to="/account/edit" v-else>
                <img src="/svg/logo_dark.svg" alt="Сервис дигитализации  покупки и продажи недвижимости" class="img-fluid">
            </router-link>
        </div>

        <nav>
            <ul>
                <li v-for="item in navigation" :class="{'active': active == item.id}">
                    <div @click="sideBarNav(item)" class="sidebar-item">
                        <img :src="'/svg/' + item.icon + '.svg'" alt="">
                        {{item.title}}
                    </div>
                </li>
            </ul>
        </nav>

        <div class="logout-button" @click="logout">
            <img src="/svg/logout.svg" alt="">
            <span>Выход</span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                navigation: [
                    {
                        id: 1,
                        title: 'Профиль',
                        link: '/account',
                        icon: 'nav_1',
                    },
                    {
                        id: 2,
                        title: 'Сделки',
                        link: '/account/deals',
                        icon: 'nav_2',
                    },
                    // {
                    //     id: 3,
                    //     title: 'Инструкции',
                    //     link: '/account/instructions',
                    //     icon: 'nav_3',
                    // },
                    // {
                    //     id: 4,
                    //     title: 'Помощь',
                    //     link: '/account/help',
                    //     icon: 'nav_4',
                    // }
                ],

                active: null
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        watch: {
            $route() {
                this.checkActive();
            },
        },

        created() {
            this.checkActive();
        },

        methods: {
            checkActive() {
                if (this.$route.name === 'account' || this.$route.name === 'account-edit') this.active = 1;
                if (this.$route.path.includes('account/deals')) this.active = 2;
                if (this.$route.name === 'instructions') this.active = 3;
                if (this.$route.name === 'help') this.active = 4;
            },

            logout() {
                localStorage.removeItem('token');
                localStorage.removeItem('expiration');
                window.location.href = '/';
            },
            sideBarNav(item) {
                if(!this.user.name) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Внимание!',
                        html: 'Для того, чтобы пользоваться сервисом, Вам необходимо заполнить личную информацию',
                    })
                }

                if(this.user.name) {
                    this.$router.push({path: item.link});
                }
            }
        }
    }
</script>
