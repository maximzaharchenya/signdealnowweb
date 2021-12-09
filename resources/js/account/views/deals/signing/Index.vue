<template>
    <div v-if="deal" id="signing-page">

        <div class="header--page position-relative">

            <sign-deal-modal :deal_id="deal.id"></sign-deal-modal>

            <div class="load-box" v-if="loading">
                <b-spinner></b-spinner>
            </div>

            <div class="d-flex">
                <router-link :to="'/account/deals/' + deal.id + '/show'" class="link-back">
                    <img src="/svg/arrow-left.svg" alt="">
                    <h3 class="font-500 mb-0">
                        ID
                        <span v-if="deal.id < 10">00{{ deal.id }}</span>
                        <span v-else-if="deal.id < 100 && deal.id > 9">0{{ deal.id }}</span>
                        <span v-else>00{{ deal.id }}</span>
                    </h3>
                </router-link>

                <div class="video-box">
                    <a target="_blank" :href="`/storage/documents/${deal.document_file}`" class="d-flex" v-if="deal.document_file">
                        <img src="/svg/doc_v2.svg" alt="" class="mr-2">
                        <div>
                            <p class="font-500 mb-0">Договор по сделке <span class="d-none d-md-inline">ID00{{ deal.id }}</span></p>
                            <p class="small mb-0 color-text-grey">Готов к скачиванию</p>
                        </div>
                    </a>
                    <div class="d-flex" v-else>
                        <img src="/svg/doc_v2.svg" alt="" class="mr-2">
                        <div>
                            <p class="font-500 mb-0">Договор не загружен</p>
                            <p class="small mb-0 color-text-grey">Размер файла не должен превышать 5 Мб.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-none d-sm-flex">

                <b-form-file
                    v-if="user && user.type == 3"
                    placeholder="Загрузить договор"
                    v-model="document_file"
                    browse-text=""
                    @input="uploadDocumentFile"
                    v-bind:class="{'file-v1': !deal.document_file, 'file-v2': deal.document_file}"
                    class="mr-3">
                </b-form-file>

                <button class="btn-small btn-v1" v-if="deal.document_file && is_sign === false" v-b-modal.sign-modal>Подписать</button>
                <button class="btn-small btn-v2" v-else-if="deal.document_file">Документ подписан</button>
            </div>

        </div>

<!--        <div v-if="!localEnvironment">-->
            <div>
            <div class="deal-show-card mb-30">
                <div id="meet" :style="`width: ${video_width}px`">
                    <b-embed
                        allow="camera; microphone; display-capture"
                        type="iframe"
                        :src="`https://jitsi.signdealnow.eu/deal_${deal.id}`"
                    ></b-embed>
                </div>
            </div>
        </div>

        <div class="d-block d-sm-none header--page mobile-buttons">

            <b-form-file
                    v-if="user && user.type == 3"
                    placeholder="Загрузить договор"
                    v-model="document_file"
                    browse-text=""
                    @input="uploadDocumentFile"
                    v-bind:class="{'file-v1': !deal.document_file, 'file-v2': deal.document_file}"
                    class="mb-2 w-100">
            </b-form-file>

            <button class="btn-small btn-v1 d-block w-100 mb-3" v-if="deal.document_file && is_sign === false" v-b-modal.sign-modal>Подписать</button>
            <button class="btn-small btn-v2 d-block w-100 mb-3" v-else-if="deal.document_file">Документ подписан</button>
        </div>
    </div>
</template>

<script>
import SignDeal from '../../../../account/views/partial/modal/SignDeal'

export default {

    components: {
        'sign-deal-modal': SignDeal
    },

    data() {
        return {
            localEnvironment: window.localEnvironment,
            loading: true,
            deal: null,

            show_sign_dialog: false,

            document_file: null,

            is_sign: null,
        }
    },

    computed: {
        user() {
            return this.$store.getters.getUser;
        },
        video_width() {
            if(window.innerWidth < 992) return window.innerWidth;
            else return window.innerWidth - 234;
        },
        channel() {
            return Echo.join(`room.${this.deal.id}`);
        },
    },

    mounted() {
        this.getDeal(this.$route.params.id, true);
        EventHandler.$on('signing-success', () => this.checkIfUserSignDocument())
    },

    methods: {
        getDeal(id, connect_to_channel) {
            axios.get('/api/deal/' + id)
                .then(response => {
                    if (response.status == 200) {
                        let deal = response.data;
                        /*deal.country = JSON.parse(deal.country);*/
                        this.deal = deal;
                        this.checkIfUserSignDocument();
                        if(connect_to_channel) this.connectToChannel();
                    }
                })
                .finally(() => {
                    this.loading = false;
                })
        },

        connectToChannel() {
            this.channel
                .here(users => this.users = users)
                .joining(user => this.users.push(user))
                .leaving(user => this.users.splice(this.users.indexOf(user), 1))
                .listen('DocumentUpdatedEvent', (event) => {
                    this.getDeal(this.deal.id, false);
                })
                .listenForWhisper('typing', (event) => {
                    if (!this.typingUser) this.typingUser = event.name;
                    if (this.typingTimer) clearTimeout(this.typingTimer)

                    this.typingTimer = setTimeout(() => {
                        this.typingUser = null
                    }, 2000)
                })
        },

        checkIfUserSignDocument()
        {
            axios.get(`/api/deal/${this.deal.id}/check_signing_status`).then(response => {
                this.is_sign = response.data.is_signed == 1;
            })
        },

        uploadDocumentFile() {
            if (this.document_file) {
                this.loading = true;
                let formData = new FormData();
                formData.append('document', this.document_file);
                axios.post(`/api/deal/${this.deal.id}/upload_document`, formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    this.getDeal(this.deal.id, false);
                })
            }
        }
    }
}
</script>

<style>
#meet {
    width: 100%;
}
</style>
