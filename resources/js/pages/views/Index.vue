<template>

    <div id="main--page" class="scroll-container" v-if="!loading">

        <header id="header-app" class="auth--header navigation-app">
            <a href="/" class="logo--box pl-0">
                <img src="/svg/logo.svg" alt="">
            </a>

            <div class="sidebar-navigation right-part" v-if="show_menu">
                <div class="d-flex d-xl-none align-items-center justify-content-between mb-24">
                    <p class="mb-0 font-500">Меню</p>
                    <div @click="closeMenu()">
                        <img src="/svg/close-menu.svg" alt="">
                    </div>
                </div>
                <nav>
                    <ul>
                        <li><a href="javascript:void(0);" @click="scrollToTarget('about')" class="link-item">О сервисе</a></li>
                        <li><a href="javascript:void(0);" @click="scrollToTarget('how-use')" class="link-item">Как пользоваться</a></li>
                        <li><a href="javascript:void(0);" @click="scrollToTarget('partners')" class="link-item">Партнёры</a></li>
                        <li><a href="javascript:void(0);" @click="scrollToTarget('functions')" class="link-item">Функции</a></li>
                        <li><a href="javascript:void(0);" @click="scrollToTarget('contacts')" class="link-item">Контакты</a></li>

                        <li><a href="/support" class="link-item d-block d-xl-none font-500 text-primary text-underline">Есть вопрос?</a></li>
                    </ul>
                </nav>

                <div class="d-xl-flex align-items-center">
                    <lang-select></lang-select>
                    <a href="tel:+375292325475"
                       class="phone font-500 link-item d-inline-block pr-xl-5 pl-xl-5 mb-4 mb-xl-0">
                        +375 29 232-54-75
                    </a>
                    <a href="/account" v-if="user" class="btn-small btn-v2">Личный кабинет</a>
                    <a href="/login" v-if="!user" class="btn-small btn-v2">Войти в систему</a>
                </div>
            </div>

            <div class="overlay" @click="closeMenu()" v-if="show_overlay"></div>


            <div class="d-block d-xl-none" @click="showMenu()">
                <img src="/svg/menu-mobile-white.svg" alt="">
            </div>


        </header>

        <div>
            <section id="main_banner" >
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="mb-20">Сервис дигитализации покупки и продажи недвижимости</h1>
                            <h5 class="mb-40 font-400">
                                Cовременное решение, позволяющее покупать и продавать недвижимость <br>
                                через Интернет, отслеживая весь процесс в личном кабинете.
                            </h5>
                            <div>
                                <a href="/register" class="btn-large btn-v1 mr-2 mr-sm-4">Хочу продать</a>
                                <a href="/register" class="btn-large btn-v2">Хочу купить</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="partner-container">
                    <div class="links">
                        <a :href="item.link"
                           :class="{'active': active_link == item.id}"
                           v-for="item in partner_links">
                            <img :src="'/svg/logo/' + item.id + item.link" alt="">
                        </a>
                    </div>

                </div>
            </section>

            <section class="pt-160 pb-160" id="about">
                <div class="container-small" >
                    <div class="row mb-72">
                        <div class="col-xl-9">
                            <h2 class="as-h1 pr-xl-5">
                                Чем полезен наш сервис купли-продажи недвижимости онлайн?
                            </h2>

                        </div>
                    </div>

                    <div class="row no-gutters justify-content-end">
                        <div class="col-xl-10">
                            <div class="grid--cols">
                                <div class="d-md-flex mb-40">
                                    <div class="d-md-none d-block mb-3">
                                        <img src="/svg/icons_for_main_page/about_1.svg" alt="" class="about_icon">
                                    </div>
                                    <div class="mr-2">
                                        <h3 class="mb-20">Удобство</h3>
                                        <p class="mb-0 color-text-grey">
                                            Отличное решение для заключения сделки с недвижимостью и
                                            оформления документов в безопасной онлайн-среде из любой точки мира
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/about_1.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-flex mb-40">
                                    <div class="mr-2">
                                        <div class="d-md-none d-block mb-3">
                                            <img src="/svg/icons_for_main_page/about_2.svg" alt="" class="about_icon">
                                        </div>
                                        <h3 class="mb-20">Драйв</h3>
                                        <p class="mb-0 color-text-grey">
                                            Наиболее быстрое и удобное решение в интересах наших клиентов, будь то
                                            продавцы
                                            или покупатели квартир, крупных промышленных или бизнес-объектов
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/about_2.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-flex mb-40">
                                    <div class="mr-2">
                                        <div class="d-md-none d-block mb-3">
                                            <img src="/svg/icons_for_main_page/about_3.svg" alt="" class="about_icon">
                                        </div>
                                        <h3 class="mb-20">Закон</h3>
                                        <p class="mb-0 color-text-grey">
                                            Сервис облегчает процесс подготовки документации в соответствии с
                                            требованиями
                                            закона
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/about_3.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="mr-2">
                                        <div class="d-md-none d-block mb-3">
                                            <img src="/svg/icons_for_main_page/about_4.svg" alt="" class="about_icon">
                                        </div>
                                        <h3 class="mb-20">Доверие</h3>
                                        <p class="mb-0 color-text-grey">
                                            Технологическое совершенство сервиса вызывает доверие и облегчает обмен
                                            информацией между сторонами сделки
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/about_4.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-160 pb-160 bg-light" id="how-use">
                <div class="container">
                    <h2 class="mb-60">
                        <div class="row justify-content-end">
                            <div class="col-12">Следуй пошаговой <br> системе, создавай сделку</div>
                            <div class="col-lg-10">
                                и согласуй весь процесс <br> в личном кабинете
                            </div>
                        </div>
                    </h2>

                    <div class="row">
                        <div class="col-lg-2">
                            <ul class="steps_nav">
                                <li @click="active_step = 1" :class="{'active': active_step == 1}"><h5>Шаг 1</h5></li>
                                <li @click="active_step = 2" :class="{'active': active_step == 2}"><h5>Шаг 2</h5></li>
                                <li @click="active_step = 3" :class="{'active': active_step == 3}"><h5>Шаг 3</h5></li>
                                <li @click="active_step = 4" :class="{'active': active_step == 4}"><h5>Шаг 4</h5></li>
                                <li @click="active_step = 5" :class="{'active': active_step == 5}"><h5>Шаг 5</h5></li>
                            </ul>
                        </div>

                        <div class="col-lg-10">
                            <div v-for="item in steps" v-if="active_step == item.id">
                                <h4 class="mb-12">{{item.title}}</h4>
                                <h5 class="mb-40 color-text-grey text-desc font-400">
                                    {{item.desc}}
                                </h5>

                                <div>
                                    <img :src="'/img/pages/step_' + item.id + '.png'" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <section class="pt-160 pb-160" id="partners">
                <div class="container">
                    <div class="info-container">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-lg-8 col-xl-6">
                                <h2 class="as-h1 mb-24">
                                    Выбирай объект недвижимости на сайтах наших партнеров
                                </h2>
                                <h5 class="color-text-grey mb-60 font-400">
                                    Зайдите на сайт, выберите понравившуюся вам недвижимость и нажмите на кнопку создания
                                    сделки.
                                    Сервис оформит сделку за вас, подтянув данные об объекте на страницу сделки, и вы
                                    сможете
                                    продолжить работу по ней в личном кабинете.
                                </h5>
                            </div>
                        </div>
                    </div>


                    <div class="row position-relative carousel-row">
                        <div class="col-lg-2">
                            <!--                            <div class="d-flex">-->
                            <!--                                <div class="mr-3 btn-slider" @click="prevSlide">-->
                            <!--                                    <img src="/svg/slider-left.svg" alt="">-->
                            <!--                                </div>-->
                            <!--                                <div class="btn-slider" @click="nextSlide">-->
                            <!--                                    <img src="/svg/slider-right.svg" alt="">-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <div class="col-lg-10 position-static">
                            <carousel
                                      :responsive="{0:{items:2,nav:false,loop:true,dots:false,margin:4,center:true},
                                      600:{items:3,nav:false,loop:true,dots:false,margin:4,center:true},
                                      767:{items:4,nav:false,loop:true,dots:false,margin:4,center:true},
                                      991:{items:4,nav:true,loop:true,dots:false,margin:4},
                                      1200:{items:5,nav:true,loop:true,dots:false,margin:4}}">

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                                <a href="#">
                                    <img src="/img/partners/test.png" alt="">
                                </a>

                            </carousel>
                        </div>
                    </div>

                </div>
            </section>

            <section class="pt-160 pb-160 bg-light" id="functions">
                <div class="container-small">
                    <div class="row">
                        <div class="col-lg-8">
                            <h2 class="as-h1 mb-60">
                                Выступай в роли покупателя, или продавца и получай выгоду
                            </h2>
                        </div>
                    </div>

                    <div class="row no-gutters justify-content-end">
                        <div class="col-xl-10">
                            <div class="grid--cols">
                                <div class="d-md-flex mb-40">
                                    <div class="d-block d-md-none mb-3">
                                        <img src="/svg/icons_for_main_page/func_1.svg" alt="" class="functions_icon">
                                    </div>
                                    <div class="mr-md-2">
                                        <h3 class="mb-20">Экономия время и денег</h3>
                                        <p class="mb-0 color-text-grey">
                                            Сэкономь время и сократи сопутствующие расходы, если объект сделки находится
                                            далеко.
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/func_1.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-md-flex mb-40">
                                    <div class="d-block d-md-none mb-3">
                                        <img src="/svg/icons_for_main_page/func_2.svg" alt="" class="functions_icon">
                                    </div>
                                    <div class="mr-md-2">
                                        <h3 class="mb-20">Push-уведомления</h3>
                                        <p class="mb-0 color-text-grey">
                                            Получай уведомления об изменениях, связанных с объектом.
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/func_2.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-md-flex mb-40">
                                    <div class="d-block d-md-none mb-3">
                                        <img src="/svg/icons_for_main_page/func_3.svg" alt="" class="functions_icon">
                                    </div>
                                    <div class="mr-md-2">
                                        <h3 class="mb-20">Защита личных данных</h3>
                                        <p class="mb-0 color-text-grey">
                                            Защита личных данных в соответствии с требованиями законодательства.
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/func_3.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-md-flex mb-40">
                                    <div class="d-block d-md-none mb-3">
                                        <img src="/svg/icons_for_main_page/func_4.svg" alt="" class="functions_icon">
                                    </div>
                                    <div class="mr-md-2">
                                        <h3 class="mb-20">Личный кабинет</h3>
                                        <p class="mb-0 color-text-grey">
                                            Храни документы, переписку и договоренности в одном месте.
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/func_4.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-md-flex mb-40">
                                    <div class="d-block d-md-none mb-3">
                                        <img src="/svg/icons_for_main_page/func_5.svg" alt="" class="functions_icon">
                                    </div>
                                    <div class="mr-md-2">
                                        <h3 class="mb-20">Онлайн встречи и room-туры</h3>
                                        <p class="mb-0 color-text-grey">
                                            Ознакомься с желаемым объектом недвижимости при помощи онлайн встреч и
                                            room-туров.
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/func_5.svg" alt="">
                                    </div>
                                </div>

                                <div class="d-md-flex">
                                    <div class="d-block d-md-none mb-3">
                                        <img src="/svg/icons_for_main_page/func_6.svg" alt="" class="functions_icon">
                                    </div>
                                    <div class="mr-md-2">
                                        <h3 class="mb-20">Vip-пакеты</h3>
                                        <p class="mb-0 color-text-grey">
                                            VIP-предложения для корпоративных клиентов с дополнительными функциями и
                                            льготными ценами.
                                        </p>
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="/svg/icons_for_main_page/func_6.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-160 bg-primary" id="mobile-app" >
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-5 col-xl-4 d-flex align-items-end order-2 order-md-1">
                            <b-carousel
                                ref="mobileAppSlider"
                                id="mobileAppSlider"
                                :interval="0"
                                v-model="mobileAppSlider"
                            >
                                <b-carousel-slide img-src="/img/pages/mobile_1.jpg"></b-carousel-slide>
                                <b-carousel-slide img-src="/img/pages/mobile_2.jpg"></b-carousel-slide>
                            </b-carousel>
                        </div>
                        <div class="col-md-7 pb-160 order-1 order-md-2">
                            <h2 class="as-h1 font-400 mb-40">
                                Мобильное приложение <span class="font-500">SignDealNow</span> – будьте всегда в
                                курсе происходящего
                            </h2>
                            <h5 class="font-400 mb-12">
                                <span class="font-500">Наша миссия</span> – модернизировать и ускорить процесс купли-продажи недвижимости с
                                помощью современного, комплексного и удобного ИТ-решения.
                            </h5>
                            <h5 class="font-400 mb-60">
                                Для этого мы разработали не только веб-версию вашего сервиса, но и мобильное
                                приложение для более удобного отслеживания всего процесса.
                            </h5>

                            <div class="d-flex">
                                <div class="mr-3 cursor-pointer" @click="prevSlide()"><img src="/svg/slider-left-bg.svg" alt=""></div>
                                <div class="cursor-pointer" @click="nextSlide()"><img src="/svg/slider-right-bg.svg" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-160 pb-160" id="contacts" >
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5">
                            <h2 class="as-h1 mb-40">
                                Задавай вопрос или авторизируйся и начни пользоваться
                            </h2>
                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <support-form></support-form>
                        </div>

                        <div class="col-lg-4 col-xl-3">
                            <div class="mb-20">
                                <p class="mb-1 font-500">Телефон</p>
                                <a class="color-text-dark" href="tel:+3726686000">+372 668-60-00</a>
                            </div>

                            <div class="mb-20">
                                <p class="mb-1 font-500">Адрес электронной почты</p>
                                <a class="color-text-dark" href="mailto:alg@alg.ee">alg@alg.ee</a>
                            </div>

                            <div class="mb-20">
                                <p class="mb-1 font-500">Место нахождения</p>
                                <p class="mb-0">Pirita tee 20/2, Tallinn</p>
                            </div>

                            <div class="mb-20">
                                <p class="mb-1 font-500">Юридическая информация</p>
                                <p class="mb-0">
                                    Ultrices ultrices rhoncus elit ornare elementum, risus amet vehicula.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer id="footer-app" class="navigation-app">
                <a href="/" class="logo-box">
                    <img src="/svg/logo_dark.svg" alt="">
                </a>

                <div class="right-part">
                    <nav>
                        <p class="fs-14 d-block d-xl-none font-500 mb-16">Меню</p>
                        <ul>
                            <li><a href="#about" class="link-item">О сервисе</a></li>
                            <li><a href="#how-use" class="link-item">Как пользоваться</a></li>
                            <li><a href="#partners" class="link-item">Партнёры</a></li>
                            <li><a href="#functions" class="link-item">Функции</a></li>
                            <li><a href="#contacts" class="link-item">Контакты</a></li>
                        </ul>
                    </nav>

                    <div class="d-sm-flex align-items-center">
                        <div class="mb-4 mb-sm-0 mr-sm-5 mr-xl-0">
                            <p class="fs-14 d-block d-xl-none font-500 mb-16">Телефон</p>
                            <a href="tel:+375292325475"
                               class="font-500 color-text-primary d-inline-block">
                                +375 29 232-54-75
                            </a>
                        </div>

                        <div class="d-block d-xl-none">
                            <p class="fs-14 font-500 mb-16">Электронная почта</p>
                            <a href="mailto:alg@alg.ee"
                               class="font-500 color-text-primary d-inline-block">
                                alg@alg.ee
                            </a>
                        </div>

                    </div>
                </div>

            </footer>
        </div>
    </div>
</template>

<script>
    import LocomotiveScroll from "locomotive-scroll";

    import { BCarousel, BCarouselSlide } from 'bootstrap-vue';
    import carousel from 'vue-owl-carousel';

    export default {
        components: {carousel, BCarousel, BCarouselSlide},
        data() {
            return {
                timer: null,
                active_link: 0,
                active_step: 1,

                loading: true,
                mobileAppSlider: 0,

                partner_links: [
                    {id: 1, link: '.svg'},
                    {id: 2, link: '.svg'},
                    {id: 3, link: '.png'},
                    {id: 4, link: '.svg'},
                    {id: 5, link: '.svg'},
                ],

                steps: [
                    {
                        id: 1,
                        title: 'Авторизация на сервисе',
                        desc: 'Для создания сделки купли-продажи или бронирования недвижимости необходимо пройти авторизацию и аутентификацию личности.',
                    },
                    {
                        id: 2,
                        title: 'Заполнение профиля',
                        desc: 'Заполните информацию о профиле и загрузите фото в личном кабинете.',
                    },
                    {
                        id: 3,
                        title: 'Создание сделки',
                        desc: 'Вы можете приступить к созданию сделки: выберите тип сделки, введите данные об объекте сделки, загрузите фото объекта и выберите свою роль. Далее пригласите вторую сторону, указав, контактные данные, сервис автоматически уведомит вас и второго участника о приглашении и начале следующего этапа сделки.',
                    },
                    {
                        id: 4,
                        title: 'Договорной процесс',
                        desc: 'На этапе формирования договора пригласите дополнительных участников, выберите их роли и внимательно заполните поля, необходимые для формирования договора. Вы можете согласовать юридические нюансы со всеми участниками в чате или с помощью групповой видеоконференции.\n' +
                            'Если необходимо внести данные, которые не предусмотрены в полях - воспользуйтесь вкладкой “дополнительная информация”',
                    },
                    {
                        id: 5,
                        title: 'Нотариальный процесс и подписание договора',
                        desc: 'После сохранения и одобрения внесенной информации всеми участниками в сделку может вступить нотариус. Функция пригласить нотариуса - становиться активной. Далее будет назначено время подписания договора.',
                    }
                ],

                windowWidth: null,
                show_menu: true,
                show_overlay: false,

            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        mounted() {
            //document.body.style.overflow = 'hidden';
            //setTimeout(() => this.init(), 1000);

            this.loading = false;
            this.partnerLinksAnimate();
            if (this.timer) clearTimeout(this.timer);
            this.timer = setInterval(this.partnerLinksAnimate, 5000);

            this.windowWidth = window.innerWidth;
            if (this.windowWidth < 1200) {
                this.show_menu = false;
                this.show_overlay = false;
            } else {
                this.show_menu = true;
                this.show_overlay = false;
            }
            window.addEventListener('resize', this.handleWindowResize);
        },

        methods: {
            init() {
                // const _self = this;
                // this.$nextTick(function () {
                //     _self.scrollAnimation();
                // });
            },
            /*in order to smooth scroll - now it delete */
            scrollAnimation() {
                const locoScroll = new LocomotiveScroll({
                    el: document.querySelector(".scroll-container"),
                    smooth: true,
                    getSpeed: true,
                    getDirection: true,
                });

                locoScroll.on('scroll', (arg) => {
                    if (arg.delta.y > 120) {
                        $("#header-app").addClass('scroll');
                    } else {
                        $("#header-app").removeClass('scroll');
                    }
                });

            },
            scrollToTarget(item) {
                document.getElementById(item).scrollIntoView({behavior: "smooth"});

                // const locoScroll = new LocomotiveScroll();
                // let target = document.querySelector('#' + item);
                // locoScroll.scrollTo(target);
            },
            /*in order to smooth scroll - now it delete */



            partnerLinksAnimate() {
                this.active_link++;
                if (this.active_link == 6) this.active_link = 1;
            },

            prevSlide() {
                this.$refs.mobileAppSlider.prev()
            },
            nextSlide() {
                this.$refs.mobileAppSlider.next()
            },

            handleWindowResize() {
                this.windowWidth = window.innerWidth;
                if (this.windowWidth < 1200) {
                    this.show_menu = false;
                    this.show_overlay = false;
                } else {
                    this.show_menu = true;
                    this.show_overlay = false;
                }
            },

            showMenu() {
                this.show_menu = true;
                this.show_overlay = true;
                document.querySelector('body').style.overflowY = 'hidden';

            },

            closeMenu() {
                this.show_menu = false;
                this.show_overlay = false;
                document.querySelector('body').style.overflowY = 'visible';
            }
        }


    }
</script>
