<template>
    <div id="timing">

        <div class="card--common">
            <div class="d-none d-md-flex align-items-center">
                <p class="mb-0">
                    До подписания осталось:
                </p>

                <div class="count">
                    <span>{{(time.d)?(time.d)+' д.':'00 д.'}}</span>
                    <span>{{(time.h)?(time.h)+' ч.':'00 ч.'}}</span>
                    <span>{{(time.m > 9)?time.m +' мин.':'0'+time.m + ' мин.'}}</span>
                    <span>{{(time.s > 9)?time.s +' сек.':'0'+time.s + ' сек.'}}</span>
                </div>
            </div>


            <div class="d-none d-md-block">
                <button class="btn-v2 btn-small" disabled v-if="deal.status == 6">
                    <span class="d-none d-xl-block">Присоединиться к подписанию</span>
                    <span class="d-block d-xl-none">Присоединиться</span>
                </button>
                <router-link :to="'/account/deals/' + $route.params.id + '/signing'" class="btn-v2 btn-small" v-if="deal.status == 7">
                    <span class="d-none d-xl-block">Присоединиться к подписанию</span>
                    <span class="d-block d-xl-none">Присоединиться</span>
                </router-link>
            </div>


            <div class="d-block d-md-none">
                <p class="mb-3">
                    До подписания осталось:
                </p>

                <div class="d-sm-flex align-items-end justify-content-between">
                    <div class="count pl-0 mb-3 mb-sm-0">
                        <span>{{(time.d)?(time.d)+' д.':'00 д.'}}</span>
                        <span>{{(time.h)?(time.h)+' ч.':'00 ч.'}}</span>
                        <span>{{(time.m > 9)?time.m +' мин.':'0'+time.m + ' мин.'}}</span>
                        <span>{{(time.s > 9)?time.s +' сек.':'0'+time.s + ' сек.'}}</span>
                    </div>

                    <div>
                        <router-link :to="'/account/deals/' + $route.params.id + '/signing'" class="color-primary text-underline" v-if="deal.status == 7">
                            <span>Присоединиться</span>
                        </router-link>
                    </div>
                </div>

            </div>
        </div>


    </div>
</template>


<script>

    export default {
        props: ['sign_info', 'deal'],
        data() {
            return {
                time: {},
                timeOn: false,

                timer: null
            }
        },

        mounted() {
            this.getDate();
            setInterval(this.ping, 100);
        },
        watch: {
            timer() {
                if(this.timer <= 0) this.endTimer();
            }
        },

        methods: {
            getDate() {
                if(this.sign_info) {
                    let set_date = this.sign_info.date.split('.').reverse().join('-') + ' ' + this.sign_info.time;

                    let date_1 = new Date(set_date).getTime();
                    let date_2 = Date.now();

                    this.timer = date_1 - date_2;

                    if(this.timer > 0) {
                        let days = Math.floor(this.timer / (1000 * 60 * 60 * 24) % 30),
                            hours = Math.floor((this.timer / (1000 * 60 * 60)) % 24),
                            minutes = Math.floor((this.timer / (1000 * 60)) % 60),
                            seconds = Math.floor((this.timer / 1000) % 60);

                        this.time = {d: days, h: hours, m: minutes, s: seconds, ms: 0};
                        this.timeOn = true;
                    }
                }
            },

            endTimer() {
                this.time = {d: 0, h: 0, m: 0, s: 0, ms: 0};
                this.timeOn = false;

                if(this.deal.status == 6) {
                    let url = '/api/deal/' + this.$route.params.id + '/sign';
                    const options = {
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };
                    axios.get(url, options)
                        .then(response => {
                            this.$router.go();
                        })
                }
            },

            ping() {
                if (this.timeOn) {
                    if (++this.time.ms > 9) {
                        this.time.ms = 0;
                        this.time.s--;
                    }
                    if (this.time.s < 0) {
                        this.time.s = 59;
                        this.time.m--;
                    }
                    if (this.time.m < 0) {
                        this.time.m = 59;
                        this.time.h--;
                    }
                    if (this.time.h < 0) {
                        this.time.m = 23;
                        this.time.d--;
                    }
                    if (this.time.d === 0 && this.time.h === 0 && this.time.m === 0 && this.time.s === 0) {
                        this.timeOn = false;
                    }
                }

                if(!this.timeOn) {
                    if(this.timer > 0) this.endTimer();
                }
            },
        },

    }
</script>
