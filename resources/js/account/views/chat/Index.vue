<template>
    <div id="chat">
        <div class="card--common h-auto">
            <div class="card--common__header flex-column flex-xl-row align-items-start align-items-xl-center justify-content-center justify-content-xl-between">
                <div class="d-flex align-items-center mb-4 mb-lg-2 mb-xl-0">
                    <h3 class="mb-0 mr-2">Чат для обсуждения</h3>

                    <div id="help_1" class="cursor-pointer">
                        <img src="/svg/help.svg" alt="">
                    </div>
                    <b-popover target="help_1" triggers="hover" placement="right">
                        <p class="mb-2 font-500">Чат</p>
                        <p class="mb-0 color-text-grey">
                            Информация в чате доступна всем участникам сделки. Для приватного общения вы можете создать приватный видеозвонок.
                        </p>
                    </b-popover>
                </div>


                <div class="chat__navigation">
                    <button class="btn-small mr-3" @click="setActive(2)"
                            :class="{'btn-v2': active !== 2, 'btn-v1': active == 2}">
                        Фотографии
                    </button>
                    <button class="btn-small mr-3" @click="setActive(3)"
                            :class="{'btn-v2': active !== 3, 'btn-v1': active == 3}">
                        Документы
                    </button>
<!--                    <button class="btn-small" @click="setActive(4)"
                            :class="{'btn-v2': active !== 4, 'btn-v1': active == 4}">
                        Ссылки
                    </button>-->
                </div>
            </div>

            <div class="card--common__body">

                <!--  Active - messages -->
                <div>
                    <div class="messages">

                        <div class="message__item" v-for="message in filteredMessages">
                            <div class="mr-3">
                                <div class="img-circle-container" v-if="message.user_image">
                                    <img :src="`/${message.user_image}`" alt="">
                                </div>
                                <img src="/svg/user-default-36.svg" alt="" v-else>
                            </div>
                            <div>
                                <p class="mb-1 font-500">{{ message.user_name }}</p>
                                <p class="mb-1 fs-16" v-if="message.is_image">
                                    <a :href="`/messages/${message.file_name}`" target="_blank">
                                        <img :src="`/messages/${message.file_name}`" class="message-image" alt="">
                                    </a>
                                </p>
                                <p class="mb-1 fs-16" v-else-if="message.is_file">
                                    <a :href="`/messages/${message.file_name}`" target="_blank" download>
                                        {{ message.original_file_name }}
                                    </a>
                                </p>
                                <p class="mb-1 fs-16" v-else>{{ message.content }}</p>
                                <p class="color-text-light mb-0">{{ checkData(message.created_at) }}</p>
                            </div>
                        </div>

                        <div id="scroll-item"></div>
                    </div>


                    <form @submit.prevent="send" class="send__box">
                        <div>
                            <b-form-file placeholder="" browse-text="" v-model="file" accept=".jpg, .jpеg, .png, .gif, .pdf, .docx, .doc, .xlsx, .xls, .xml"></b-form-file>
                        </div>

                        <b-form-textarea v-if="!file" placeholder="Введите сообщение" v-on:keyup.enter="send" v-model="content" rows="1" max-rows="4"></b-form-textarea>
                        <p v-else class="pl-4 pb-0">Файл
                            <button class="btn btn-link py-0" @click="file = null">Отмена</button>
                        </p>

                        <button class="send__button" type="submit">
                            <span class="d-none d-xl-inline-block">Отправить</span>
                            <img src="/svg/send.svg" alt="">
                        </button>
                    </form>
                </div>
<!--

                &lt;!&ndash;  Active - images &ndash;&gt;
                <div v-if="active == 2">
                    <div class="images">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">
                        <img src="/img/defaults/deal.jpg" alt="">

                    </div>
                </div>

                &lt;!&ndash;  Active - docs &ndash;&gt;
                <div v-if="active == 3">
                    <div class="docs">
                        <div class="row">
                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 mb-30">
                                <div class="docs__item">
                                    <img src="/svg/doc.svg" alt="" class="mr-2">
                                    <div>
                                        <p class="font-500 mb-1">Договор купли-продажи по сделке 0020.docs</p>
                                        <p class="mb-0 color-text-grey small">Размер файла 5 Мб.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                &lt;!&ndash;  Active - links &ndash;&gt;
                <div v-if="active == 4"></div>
-->

            </div>
        </div>


    </div>
</template>

<script>
import {echoDateTime} from "../../../services/functions";

export default {
    props: ['document_id'],

    data() {
        return {
            active: 1,
            messages: [],
            users: [],

            content: null,
            file: null,
        }
    },

    computed: {
        user() {
            return this.$store.getters.getUser
        },

        filteredMessages() {
            if(this.active === 1) return this.messages;
            if(this.active === 2) return this.messages.filter(message => message.is_image);
            if(this.active === 3) return this.messages.filter(message => message.is_file);

        }
    },

    methods: {
        getMessages() {
            axios.get(`/api/messages/${this.document_id}`).then(response => {
                response.data.forEach(message => {
                    if (message.is_image || message.is_file) {
                        const json = JSON.parse(message.content);
                        message.original_file_name = json.original_file_name;
                        message.file_name = json.file_name;
                    }
                    this.messages.push(message)
                })
            });
        },



        setActive(item) {
            if (this.active == item) this.active = 1;
            else this.active = item;
        },

        scrollBottom() {
            let scroll = window.pageYOffset;
            document.getElementById('scroll-item').scrollIntoView({behavior: "auto"});
            window.scrollTo(0, scroll);
        },

        send() {
            if (this.content || this.file) {
                let formData = new FormData();
                if (this.file) formData.append('file_data', this.file);
                else formData.append('content', this.content);
                axios.post(`/api/message/${this.document_id}`, formData).then((response) => {
                    if (this.file) {
                        const json = JSON.parse(response.data.content);


                        this.messages.push({
                            is_file: response.data.is_file,
                            is_image: response.data.is_image,
                            content: response.data.content,
                            user_name: this.user.name,
                            user_image: this.user.profile_image,
                            original_file_name: json.original_file_name,
                            file_name: json.file_name,
                            created_at: new Date().toUTCString(),
                        });
                    }
                    else this.messages.push({
                        content: this.content,
                        user_name: this.user.name,
                        user_image: this.user.profile_image,
                        created_at: new Date().toUTCString(),
                    });
                    this.content = null;
                    this.file = null;

                    setTimeout(this.scrollBottom, 1000);
                })
            }

        },

        checkData(date) {
            return echoDateTime(date)
        }
    },

    mounted() {
        /*this.connectToChat();*/
        this.getMessages();
        EventHandler.$on('new_message', event => {
            //console.log('got message', event)
            this.messages.push(event.data);
            this.typingUser = null
        });

        setTimeout(this.scrollBottom, 1000);
    },


}
</script>
