<template>
    <div v-if="deal">
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
</template>

<script>
export default {
    data() {
        return {
            loading: true,
            deal: null
        }
    },

    computed: {
        user() {
            return this.$store.getters.getUser;
        },
        video_width() {
            if(window.innerWidth < 992) return window.innerWidth;
            else return window.innerWidth - 234;
        }
    },

    mounted() {
        this.init();
    },

    methods: {
        init() {
            let url = '/api/deal/' + this.$route.params.id;
            const options = {
                headers: {Authorization: "Bearer " + localStorage.getItem('token')}
            };

            axios.get(url, options)
                .then(response => {
                    if (response.status == 200) {
                        let deal = response.data;
                        this.deal = deal;
                    }
                })
                .finally(() => {
                    this.loading = false;
                })
        }
    }
}
</script>

<style>
#meet {
    width: 100%;
}
</style>
