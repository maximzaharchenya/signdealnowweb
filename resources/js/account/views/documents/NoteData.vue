<template>
    <div class="custom-form" id="note_data" :class="{'card--common': !show_for_notary}">

        <div class="card--common__header header-sticky"  v-if="!show_for_notary">
            <h3 class="mb-0">Договорной процесс</h3>

            <div class="d-none d-md-block">
                <button class="btn-small btn-v2 mr-3"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        @click="approveData()"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
                <button class="btn-small btn-v1" @click="addNote()">Добавить заметку</button>
            </div>

        </div>

        <div class="pt-0" :class="{'card--common__body': !show_for_notary}">

            <!--  DESCTOP ITEMS -->
            <div class="deals-table d-none d-md-block">
                <!--  HEADER -->
                <div class="deals-table__header">
                    <div>Автор</div>
                    <div>Дата</div>
                    <div>Текст заметки</div>
                </div>

                <!--  BODY -->
                <div class="deals-table__item"
                     v-if="notes && notes.length > 0"
                     v-for="(item, key) in notes"
                     :key="key">


                    <div>
                        <div class="d-flex">
                            <div class="mr-2">
                                <div class="img-circle-container">
                                    <img v-if="item.user.profile_image" :src="'/storage/' + item.user.profile_image" alt="">
                                    <img v-else src="/svg/user-default-36.svg" alt="">
                                </div>
                            </div>
                            <div>
                                <p class="font-500 mb-0">{{item.user.name}} {{item.user.surname}}</p>
                                <p class="small color-text-grey mb-0">
                                    <span v-if="item.user.role == 1">Продавец</span>
                                    <span v-if="item.user.role == 2">Покупатель</span>
                                    <span v-if="item.user.role == 4">Юрист-консультант</span>
                                    <span v-if="item.user.role == 5">Переводчик</span>
                                    <span v-if="item.user.role == 6">Супруг/Супруга покупателя</span>
                                    <span v-if="item.user.role == 7">Cупруг/Супруга продавца</span>
                                    <span v-if="item.user.role == 8">Ассистент нотариуса</span>
                                    <span v-if="item.user.role == 9">Представитель банка продавца</span>
                                    <span v-if="item.user.role == 10">Представитель банка покупателя</span>
                                    <span v-if="item.user.role == 11">Совладелец</span>
                                    <span v-if="item.user.role == 12">Представитель Юр.Лица</span>
                                </p>

                            </div>
                        </div>
                    </div>


                    <div>{{checkDate(item.created_at)}}</div>
                    <div class="d-flex justify-content-between align-items-start">
                        <span>{{item.note}}</span>

                        <div :id="'target_' + key" class="cursor-pointer" v-if="item.user_id == user.id">
                            <img src="/svg/table_menu.svg" alt="">
                        </div>
                        <b-popover :target="'target_' + key" triggers="hover" placement="left">
                            <div class="mb-2 popover-item" @click="editNote(item)">Редактировать</div>
                            <div class="popover-item" @click="deleteNote(item.id)">Удалить</div>
                        </b-popover>
                    </div>


                </div>

                <div v-if="notes && notes.length < 1" class="pt-4">
                    Дополнительной информации нет.
                </div>
            </div>

            <!--  MOBILE ITEMS -->
            <div class="d-block d-md-none">
                <div class="row pt-4"  v-if="notes && notes.length > 0">
                    <div class="col-sm-6 mb-4"
                         v-for="(item, key) in notes"
                         :key="key">

                        <div class="deal__card">
                            <div class="deal__card--header">
                                <img v-if="item.user.profile_image" :src="'/storage/' + item.user.profile_image" alt="">
                                <img v-else src="/img/defaults/user_default.png" alt="" class="w-auto">

                                <div class="status d-flex" v-if="item.user_id == user.id">
                                    <div @click="editNote(item)">
                                        <img src="/svg/action_edit.svg" alt="">
                                    </div>
                                    <div @click="deleteNote(item.id)">
                                        <img src="/svg/action_delete.svg" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="deal__card--body">
                                <div class="small color-text-grey mb-2">{{checkDate(item.created_at)}}</div>

                                <p class="font-500 mb-0">{{item.user.name}} {{item.user.surname}}</p>
                                <p class="color-text-grey mb-2">
                                    <span v-if="item.user.role == 1">Продавец</span>
                                    <span v-if="item.user.role == 2">Покупатель</span>
                                    <span v-if="item.user.role == 4">Юрист-консультант</span>
                                    <span v-if="item.user.role == 5">Переводчик</span>
                                    <span v-if="item.user.role == 6">Супруг/Супруга покупателя</span>
                                    <span v-if="item.user.role == 7">Cупруг/Супруга продавца</span>
                                    <span v-if="item.user.role == 8">Ассистент нотариуса</span>
                                    <span v-if="item.user.role == 9">Представитель банка продавца</span>
                                    <span v-if="item.user.role == 10">Представитель банка покупателя</span>
                                    <span v-if="item.user.role == 11">Совладелец</span>
                                    <span v-if="item.user.role == 12">Представитель Юр.Лица</span>
                                </p>

                                <p class="mb-0">{{item.note}}</p>
                            </div>
                        </div>

                    </div>

                    <div v-if="notes && notes.length < 1" class="pt-4 col-12">
                        Дополнительной информации нет.
                    </div>
                </div>
            </div>

            <div class="d-block d-md-none">
                <button class="btn-small btn-v2 w-100"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        @click="approveData()"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
            </div>

        </div>



        <!-- MODAL -->
        <b-modal id="add-note" ref="add-note" centered hide-header hide-footer>
            <div class="close">
                <img src="/svg/close.svg" alt="" @click="$bvModal.hide('add-note')">
            </div>

            <h3 class="mb-30">Добавление заметки</h3>

            <div class="custom-form">
                <div class="mb-40 form--item">
                    <label for="country">Текст заметки*</label>
                    <textarea id="country"
                              autocomplete="off"
                              type="text"
                              v-model="note"></textarea>
                </div>
            </div>

            <button @click="saveNote()" :disabled="!note" class="btn-large btn-v1">
                Сохранить
            </button>

        </b-modal>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>

        <div class="mobile-footer-btn-container">
            <button class="btn-small btn-v1 w-100" @click="addNote()">Добавить заметку</button>
        </div>
    </div>
</template>


<script>
    import { echoDate } from '../../../services/functions';
    import RequestsServices from '../../../services/requests';

    export default {
        props: ['user_role', 'user_approved', 'show_for_notary'],
        data() {
            return {
                note: null,
                notes: null,

                edit_note: false,
                url: null,

                deal: null,
                loading: true
            }
        },

        mounted() {
            this.getDeal();
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        methods: {
            getDeal() {
                RequestsServices.deal(this.$route.params.id, this.user.id).then(response => {
                    this.deal = response;
                    this.init();
                });
            },
            init() {
                this.loading = true;

                if(this.deal && this.deal.notes) {
                   this.notes = this.deal.notes;
                   this.notes.forEach(item => {
                       this.deal.all_users.forEach(user => {
                           if(item.user_id == user.id) item.user = user;
                       })

                   })
                }
                this.loading = false
            },
            addNote() {
                this.note = null;
                this.url = '/api/deal/' + this.$route.params.id + '/note_data';
                this.$refs['add-note'].show();
                this.edit_note = false;

            },

            editNote(item) {
                this.$refs['add-note'].show();
                this.note = item.note;
                this.edit_note = true;

                this.url = '/api/deal/' + this.$route.params.id + '/note_data/' + item.id;
            },

            saveNote() {
                if(this.note) {
                    const options = {
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };

                    this.loading = true;

                    axios.post(this.url, {note: this.note}, options)
                        .then(response => {
                            if (response.status == 200) {
                                let html;
                                if(this.edit_note) html = 'Информация успешно обновлена.';
                                else html = 'Вы добавили новую заметку.';
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: html,
                                }).then(() => {
                                    this.getDeal();
                                    this.$refs['add-note'].hide();
                                    this.note = null;
                                })
                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })

                }

            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    html: 'Введите корректно текст заметки',
                })
            }
            },

            deleteNote(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Внимание',
                    html: 'Вы уверены, что хотите удалить запись?',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    confirmButtonText: `Удалить`,
                }).then((result) => {
                    if(result.isConfirmed) {
                        let url = '/api/deal/' + this.$route.params.id + '/note_data/' + id + '/delete';
                        const options = {
                            headers: {Authorization: "Bearer " + localStorage.getItem('token')},
                            params: {
                                note_id: id
                            }
                        };

                        this.loading = true;

                        axios.get(url, options)
                            .then(response => {
                                if (response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Готово',
                                        html: 'Заметка удалена',
                                    }).then(() => {
                                        this.notes = null;
                                        this.getDeal();
                                    })
                                }
                            })
                            .finally(() => {
                                this.loading = false;
                            })
                    }
                })
            },

            checkDate(date) {
                return echoDate(date);
            },
            approveData() {
                this.$emit('approve_data', true);
            }
        }
    }
</script>
