<template>

    <div>
        <div class="header--account">
            <div class="d-none d-lg-block">
                <nav>
                    <ul>
                        <li>
                            <router-link to="/account/instructions" class="color-text-dark">Инструкции</router-link>
                        </li>
                        <li>
                            <router-link to="/account/support" class="color-text-dark">Помощь</router-link>
                        </li>
                    </ul>
                </nav>
            </div>

            <div v-if="user" class="d-none d-lg-block">
                <div class="d-flex">
                    <div class="mr-2">
                        <div class="img-circle-container">
                            <img v-if="user.profile_image" :src="'/' + user.profile_image" alt="">
                            <img v-else src="/svg/user-default-36.svg" alt="">
                        </div>
                    </div>
                    <div>
                        <p class="font-500 mb-0" v-if="user.name">{{user.name}} {{user.surname}}</p>
                        <p class="font-500 mb-0" v-if="!user.name">Новый пользователь</p>

                        <p class="small color-text-grey mb-0">Сейчас в сети</p>
                    </div>
                </div>
            </div>

            <!--  MOBILE NAVIGATION-->
            <div class="d-block d-lg-none">
                <router-link to="/account">
                    <img src="/svg/logo_dark.svg" alt="">
                </router-link>
            </div>

            <div class="d-block d-lg-none" @click="mobile_sidebar = true">
                <img src="/svg/menu-mobile.svg" alt="">
            </div>
        </div>

        <!-- MOBILE SIDEBAR-->
        <transition name="slide-right">
            <div class="sidebar--mobile" v-if="mobile_sidebar">
                <div class="mobile-navigation">
                    <div class="d-flex align-items-center justify-content-between mb-40">
                        <h5 class="mb-0 font-500">Меню</h5>
                        <div @click="mobile_sidebar = false">
                            <img src="/svg/close-menu.svg" alt="">
                        </div>
                    </div>

                    <nav>
                        <div @click="sideBarNav('/account')">Профиль</div>
                        <div @click="sideBarNav('/account/deals')">Сделки</div>
                        <div>
                            <router-link to="/account/instructions">Инструкции</router-link>
                        </div>
                        <div>
                            <router-link to="/account/support">Помощь</router-link>
                        </div>
                    </nav>

                    <div>
                        <div class="d-inline-block">
                            <lang-select></lang-select>
                        </div>

                        <hr>

                        <div class="mb-20">
                            <a class="font-500" href="tel:+375292325475">+375 29 232-54-75</a>
                        </div>

                        <button class="btn-large btn-v2 w-100" @click="logout()">
                            <span>Выход</span>
                        </button>

                    </div>
                </div>
                <div class="overlay" @click="mobile_sidebar = false"></div>
            </div>
        </transition>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                mobile_sidebar: false
            }
        },

        watch: {
            $route() {
                this.mobile_sidebar = false;
            },
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        methods: {
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
                    this.$router.push({path: item});
                }
            }
        }
    }
</script>
