<template>
    <div>
        <auth-header></auth-header>

        <div class="auth--page content">

            <div class="bg-container"></div>
            <div class="content-container d-flex flex-column justify-content-center">

                <div v-if="check_email">
                    <h2 class="mb-4">Подтверждение</h2>
                    <p class="mb-40 color-text-grey pr-5">Ваш Email успешно подтвержден. <br>
                        Для того, чтобы начать работу с сервисом войдите в личный кабинет и пройдите аутентификацию в системе.
                    </p>

                    <router-link to="/login" class="btn-large btn-v1">Войти в личный кабинет</router-link>
                </div>

                <div v-if="need_to_check_email">
                    <h2 class="mb-4">Подтверждение</h2>
                    <p class="mb-40 color-text-grey pr-5">Письмо для потдверждения адреса электронной почты отправлено на Ваш email. <br>
                        Для того, чтобы завершить процесс регистрации, вам необходимо открыть данное ссобщение и перейти по ссылке.
                    </p>
                </div>

            </div>
        </div>

    </div>

</template>



<script>
    export default {

        data () {
            return {
                check_email: false,
                need_to_check_email: false,
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
                if(this.$route.query.pin) {
                    let url = '/api/email/check';
                    let data = {
                        pin: this.$route.query.pin,
                    };
                    axios.post(url, data)
                        .then(response => {
                            if(response.status == 200) {
                                this.check_email = true;
                            }
                            else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ошибка',
                                    html: 'Произошла ошибка. Обратитесь в службу поддержки.',
                                }).then(() => {
                                    window.location.pathname = '/';
                                })
                            }
                        })
                }
                else {
                    this.need_to_check_email = true;
                }

            },

        },
    }
</script>
