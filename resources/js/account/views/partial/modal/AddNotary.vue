<template>

    <div v-if="data">
        <b-modal id="add-notary" ref="add-notary" centered hide-header hide-footer>
            <div class="close">
                <img src="/svg/close.svg" alt="" @click="$bvModal.hide('add-notary')">
            </div>

            <div>
                <div class="d-flex">
                    <div class="modal-image">
                        <img v-if="data.image" :src="'/storage/' + data.image" alt="">
                        <img v-else src="/img/defaults/user_default.png" alt="">
                    </div>
                    <div class="card--body">
                        <h4 class="mb-3">Нотариус {{data.name}} {{data.surname}}</h4>

                        <p class="mb-2">{{data.office_name}}</p>
                        <div class="mb-30 d-flex flex-wrap">
                            <span class="pr-1">Разговорные языки:</span>
                            <div v-if="!data.language"> Не указано</div>
                            <div v-if="data.language" class="d-flex flex-wrap">
                                <div v-for="(lang, key) in data.language" :key="key" >
                                    {{lang}}<span v-if="key !== data.language.length - 1" class="d-inline-block pr-1">, </span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row buttons-container">
                            <button class="btn-large btn-v1 mr-sm-4 mb-3 mb-sm-0" @click="inviteNotary()">Да, пригласить</button>
                            <button class="btn-large btn-v2" @click="$bvModal.hide('add-notary')">Посмотреть еще</button>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
    </div>



</template>

<script>
    export default {
        props: ['data'],
        data() {
            return {

            }
        },

        methods: {
            inviteNotary() {
                this.loading = true;
                let url = '/api/deal/' + this.$route.params.id + '/notary/' + this.data.id + '/invite';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                return axios.get(url, options)
                    .then(response => {
                        if(response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Приглашение нотариусу успешно отправлено!',
                            }).then(() => {
                                this.$router.push({path: '/account/deals/' + this.$route.params.id + '/show'});
                            })
                        }

                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>
