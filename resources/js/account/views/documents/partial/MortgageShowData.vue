<template>
    <div class="custom-form" v-if="data">

        <div class="mb-40">
            <div>
                <hr>
                <div class="d-flex mb-40 align-items-center justify-content-between">
                    <p class="mb-0 font-500">Залоговая недвижимость:</p>

                    <div class="d-flex" v-if="user_id == user.id">
                        <div v-if="disabled_item" @click="disabled_item = false" class="cursor-pointer">
                            <img src="/svg/action_edit.svg" alt="">
                        </div>
                        <div v-if="!disabled_item" class="cursor-pointer" @click="saveItem()"><img
                            src="/svg/action_save.svg" alt=""></div>

                        <div @click="deleteItem()" class="cursor-pointer"><img src="/svg/action_delete.svg" alt="">
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.type_select.$error, 'is-valid': postData.type_select && !$v.postData.type_select.$invalid}">
                        <label>Тип объекта*</label>
                        <multiselect v-model.trim="postData.type_select"
                                     @input="delayTouch($v.postData.type_select)"
                                     :options="type_options"
                                     :allow-empty="false"
                                     :searchable="false"
                                     deselect-label=""
                                     placeholder=""
                                     selected-label=""
                                     select-label=""
                                     label="title"
                                     track-by="title"
                                     :disabled="disabled_item"
                        ></multiselect>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.area.$error, 'is-valid': postData.area && !$v.postData.area.$invalid}">
                        <label :for="'show_area' + data.id">Площадь объекта, м<sup>2</sup></label>
                        <input :id="'show_area' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.area"
                               @input="delayTouch($v.postData.area)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.land_area.$error, 'is-valid': postData.land_area && !$v.postData.land_area.$invalid}">
                        <label :for="'show_land_area' + data.id">Площадь земельного участка, м<sup>2</sup></label>
                        <input :id="'show_land_area' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.land_area"
                               @input="delayTouch($v.postData.land_area)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.living_area.$error, 'is-valid': postData.living_area && !$v.postData.living_area.$invalid}">
                        <label :for="'show_living_area' + data.id">Жилая площадь объекта, м<sup>2</sup></label>
                        <input :id="'show_living_area' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.living_area"
                               @input="delayTouch($v.postData.living_area)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-valid': postData.purpose}">
                        <label>Целевое назначение объекта</label>
                        <multiselect v-model="postData.purpose"
                                     :options="purpose_options"
                                     :allow-empty="false"
                                     :searchable="false"
                                     deselect-label=""
                                     placeholder=""
                                     selected-label=""
                                     select-label=""
                                     :disabled="disabled_item"
                        ></multiselect>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-valid': postData.energy_class}">
                        <label>Класс эффективности объекта</label>
                        <multiselect v-model="postData.energy_class"
                                     :options="energy_class_options"
                                     :allow-empty="false"
                                     :searchable="false"
                                     deselect-label=""
                                     placeholder=""
                                     selected-label=""
                                     select-label=""
                                     :disabled="disabled_item"
                        ></multiselect>
                    </div>
                </div>

                <div class="col-4">

                    <div class="mb-20 form--item" v-if="countries_options"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.country.$error, 'is-valid': !$v.postData.country.$invalid}">
                        <label>Страна объекта*</label>
                        <multiselect v-model.trim="postData.country"
                                     @input="delayTouch($v.postData.country)"
                                     :options="countries_options"
                                     :allow-empty="false"
                                     :searchable="true"
                                     noResult="Нет данных"
                                     deselect-label=""
                                     placeholder=""
                                     selected-label=""
                                     select-label=""
                                     :disabled="disabled_item"
                        ><span slot="noResult">Совпадений не найдено</span></multiselect>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.city.$error, 'is-valid': !$v.postData.city.$invalid, 'disabled--item': disabled_item}">
                        <label :for="'show_city' + data.id">Город объекта*</label>
                        <input :id="'show_city' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.city"
                               @input="delayTouch($v.postData.city)">
                </div>
                </div>

                <div class="col-8">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.address.$error, 'is-valid': !$v.postData.address.$invalid}">
                        <label :for="'show_address' + data.id">Адрес объекта (улица, дом, квартира)*</label>
                        <input :id="'show_address' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.address"
                               @input="delayTouch($v.postData.address)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.cost.$error, 'is-valid': postData.cost && !$v.postData.cost.$invalid}">
                        <label :for="'show_cost' + data.id">Стоимость объекта, евро</label>
                        <input :id="'show_cost' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.cost"
                               @input="delayTouch($v.postData.cost)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-valid': postData.cadastral_number}">
                        <label :for="'show_cadastral_number' + data.id">Кадастровый номер</label>
                        <input :id="'show_cadastral_number' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model="postData.cadastral_number">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.registration_number.$error, 'is-valid': postData.registration_number && !$v.postData.registration_number.$invalid}">
                        <label :for="'show_registration_number' + data.id">Регистрационный номер</label>
                        <input :id="'show_registration_number' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.registration_number"
                               @input="delayTouch($v.postData.registration_number)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.serf_number.$error, 'is-valid': postData.serf_number && !$v.postData.serf_number.$invalid}">
                        <label :for="'show_serf_number' + data.id">Номер крепостного реестра</label>
                        <input :id="'show_serf_number' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.serf_number"
                               @input="delayTouch($v.postData.serf_number)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': $v.postData.partnership_code.$error, 'is-valid': postData.partnership_code && !$v.postData.partnership_code.$invalid}">
                        <label :for="'show_partnership_code' + data.id">Регистрационный код товарищества</label>
                        <input  :id="'show_partnership_code' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="postData.partnership_code"
                               @input="delayTouch($v.postData.partnership_code)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-valid': postData.owner}">
                        <label :for="'show_owner' + data.id">Имя Фамилия владельца объекта</label>
                        <input :id="'show_owner' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model="postData.owner">
                    </div>
                </div>

                <div class="col-4" v-if="user_id == user.id">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-valid': postData.owner_code}">
                        <label :for="'show_owner_code' + data.id">Личный код владельца</label>
                        <input :id="'show_owner_code' + data.id"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model="postData.owner_code">
                    </div>
                </div>
            </div>
        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>


    </div>

</template>


<script>
    import RequestsServices from '../../../../services/requests';
    import Multiselect from 'vue-multiselect';

    import {requiredRule, onlyNumRuleNoReq, noValid} from '../../../../services/validation';

    const touchMap = new WeakMap();

    export default {
        components: {
            Multiselect
        },

        props: ['data', 'user_id'],
        data() {
            return {
                postData: {
                        type_select: null,
                        type: null,
                        area: null,
                        land_area: null,
                        //used_land_area: null,
                        living_area: null,
                        purpose: null,
                        cadastral_number: null,
                        energy_class: null,
                        country: null,
                        city: null,
                        address: null,
                        //cadastral_number_property: null,
                        registration_number: null,
                        serf_number: null,
                        partnership_code: null,
                        owner: null,
                        owner_code: null,
                        cost: null,
                    },

                type: null,
                countries_options: null,

                type_options: [
                    {id: 1, title: 'Квартира'},
                    {id: 2, title: 'Многоквартирный дом'},
                    {id: 3, title: 'Дом'},
                    {id: 4, title: 'Дача'},
                    {id: 5, title: 'Производственное помещение'}
                ],
                purpose_options: ['Жилая', 'Нежилая', 'Дом', 'Коммерческая'],
                energy_class_options: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],

                index: 2,

                disabled_item: true,
                loading: true
            }
        },

        created() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });
        },
        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        watch: {
            data() {
                this.init();
            }
        },

        mounted() {
            this.init();
        },


        methods: {
            init() {
                if (this.data) {
                    this.loading = true;

                    if (this.data.type == 1) this.postData.type_select = {id: 1, title: 'Квартира'};
                    if (this.data.type == 2) this.postData.type_select = {id: 2, title: 'Многоквартирный дом'};
                    if (this.data.type == 3) this.postData.type_select = {id: 3, title: 'Дом'};
                    if (this.data.type == 4) this.postData.type_select = {id: 4, title: 'Дача'};
                    if (this.data.type == 5) this.postData.type_select = {id: 5, title: 'Производственное помещение'};

                    this.postData.country = this.data.country;
                    this.postData.area = this.data.area;
                    this.postData.land_area = this.data.land_area;
                    this.postData.living_area = this.data.living_area;
                    this.postData.purpose = this.data.purpose;
                    this.postData.cadastral_number = this.data.cadastral_number;
                    this.postData.energy_class = this.data.energy_class;
                    this.postData.city = this.data.city;
                    this.postData.address = this.data.address;
                    this.postData.registration_number = this.data.registration_number;
                    this.postData.serf_number = this.data.serf_number;
                    this.postData.partnership_code = this.data.partnership_code;
                    this.postData.owner = this.data.owner;
                    this.postData.owner_code = this.data.owner_code;
                    this.postData.cost = this.data.cost;

                    this.loading = false;
                } else this.loading = false;

            },
            saveItem() {
                this.$v.$touch();

                if (this.$v.$invalid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`
                    });
                    return;
                } else {
                    this.loading = true;

                    const options = {
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };
                    let url = '/api/deal/' + this.$route.params.id + '/mortgage/' + this.data.id;

                    if (this.postData.type_select) this.postData.type = this.postData.type_select.id;

                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    axios.post(url, formData, options)
                        .then(response => {
                            if (response.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Данные успешно сохранены.',
                                }).then(() => {
                                    this.$emit('init_data', true);
                                    this.disabled_item = true;
                                })
                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }
            },

            deleteItem() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Внимание',
                    html: 'Вы уверены, что хотите удалить запись?',
                    showCancelButton: true,
                    cancelButtonText: 'Отмена',
                    confirmButtonText: `Удалить`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.loading = true;

                        let url = '/api/deal/' + this.$route.params.id + '/mortgage/' + this.data.id + '/delete';
                        const options = {
                            headers: {Authorization: "Bearer " + localStorage.getItem('token')},
                            params: {
                                mortgage_id: this.data.id
                            }
                        };

                        axios.get(url, options)
                            .then(response => {
                                if (response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Готово',
                                        html: 'Информация о залоговой недвижимости удалена.'
                                    }).then(() => {
                                        this.$emit('init_data', true);
                                    })
                                }
                            })
                            .finally(() => {
                                this.loading = false
                            })
                    }
                })
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000));
            },

        },

        validations: {
            postData: {
                type_select: requiredRule,

                country: requiredRule,
                city: requiredRule,
                address: requiredRule,

                area: onlyNumRuleNoReq,
                land_area: onlyNumRuleNoReq,
                living_area: onlyNumRuleNoReq,

                registration_number: onlyNumRuleNoReq,
                serf_number: onlyNumRuleNoReq,
                partnership_code: onlyNumRuleNoReq,
                cost: onlyNumRuleNoReq,
            }
        }
    }
</script>
