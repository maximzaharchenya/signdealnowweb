<template>
    <div>

        <div v-for="(item, i) in $v.postData.$each.$iter" :key="i" class="mb-40">
            <div>
                <hr>
                <div class="mb-40 d-flex align-items-center justify-content-between">
                    <p class="mb-0 font-500">Залоговая недвижимость</p>
                    <div>
                        <span class="cursor-pointer color-text-primary text-underline" @click="cancelItem(i)">отменить</span>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.type_select.$error, 'is-valid': !item.type_select.$invalid}">
                        <label>Тип объекта*</label>
                        <multiselect v-model.trim="item.type_select.$model"
                                     @input="delayTouch(item.type_select)"
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
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.area.$error, 'is-valid': item.area.$model && !item.area.$invalid}">
                        <label :for="item.index.$model + '_area'">Площадь объекта, м<sup>2</sup></label>
                        <input :id="item.index.$model  + '_area'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.area.$model"
                               @input="delayTouch(item.area)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.land_area.$error, 'is-valid': item.land_area.$model && !item.land_area.$invalid}">
                        <label :for="item.index.$model + '_land_area'">Площадь земельного участка, м<sup>2</sup></label>
                        <input :id="item.index.$model + '_land_area'"
                               autocomplete="off"
                               type="text"
                               v-model.trim="item.land_area.$model"
                               @input="delayTouch(item.land_area)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.living_area.$error, 'is-valid': item.living_area.$model && !item.living_area.$invalid}">
                        <label :for="item.index.$model + '_living_area'">Жилая площадь объекта, м<sup>2</sup></label>
                        <input :id="item.index.$model + '_living_area'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.living_area.$model"
                               @input="delayTouch(item.living_area)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': item.purpose.$model && !item.purpose.$invalid}">
                        <label>Целевое назначение объекта</label>
                        <multiselect v-model.trim="item.purpose.$model"
                                     @input="delayTouch(item.purpose)"
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
                    <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': item.energy_class.$model && !item.energy_class.$invalid}">
                        <label>Класс эффективности объекта</label>
                        <multiselect v-model.trim="item.energy_class.$model"
                                     @input="delayTouch(item.energy_class)"
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
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.country.$error, 'is-valid': !item.country.$invalid}">
                        <label>Страна объекта*</label>
                        <multiselect v-model.trim="item.country.$model"
                                     @input="delayTouch(item.country)"
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
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.city.$error, 'is-valid': !item.city.$invalid}">
                        <label :for="item.index.$model + '_city'">Город объекта*</label>
                        <input :id="item.index.$model + '_city'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.city.$model"
                               @input="delayTouch(item.city)">
                    </div>
                </div>

                <div class="col-8">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.address.$error, 'is-valid': !item.address.$invalid}">
                        <label :for="item.index.$model + '_address'">Адрес объекта (улица, дом, квартира)*</label>
                        <input :id="item.index.$model + '_address'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.address.$model"
                               @input="delayTouch(item.address)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.cost.$error, 'is-valid': item.cost.$model && !item.cost.$invalid}">
                        <label :for="item.index.$model + '_cost'">Стоимость объекта, евро</label>
                        <input :id="item.index.$model + '_cost'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.cost.$model"
                               @input="delayTouch(item.cost)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': item.cadastral_number.$model && !item.cadastral_number.$invalid}">
                        <label :for="item.index.$model + '_cadastral_number'">Кадастровый номер</label>
                        <input :id="item.index.$model + '_cadastral_number'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.cadastral_number.$model"
                               @input="delayTouch(item.cadastral_number)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.registration_number.$error, 'is-valid': item.registration_number.$model && !item.registration_number.$invalid}">
                        <label :for="item.index.$model + '_registration_number'">Регистрационный номер</label>
                        <input :id="item.index.$model + '_registration_number'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.registration_number.$model"
                               @input="delayTouch(item.registration_number)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.serf_number.$error, 'is-valid': item.serf_number.$model && !item.serf_number.$invalid}">
                        <label :for="item.index.$model + '_serf_number'">Номер крепостного реестра</label>
                        <input :id="item.index.$model + '_serf_number'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.serf_number.$model"
                               @input="delayTouch(item.serf_number)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled_item, 'is-invalid': item.partnership_code.$error, 'is-valid': item.partnership_code.$model && !item.partnership_code.$invalid}">
                        <label :for="item.index.$model + '_partnership_code'">Регистрационный код товарищества</label>
                        <input :id="item.index.$model + '_partnership_code'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.partnership_code.$model"
                               @input="delayTouch(item.partnership_code)">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': item.owner.$model && !item.owner.$invalid}">
                        <label :for="item.index.$model + '_owner'">Имя Фамилия владельца объекта</label>
                        <input :id="item.index.$model + '_owner'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.owner.$model"
                               @input="delayTouch(item.owner)">
                    </div>
                </div>

                <div class="col-4" v-if="!disabled_item">
                    <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': item.owner_code.$model && !item.owner_code.$invalid}">
                        <label :for="item.index.$model + '_owner_code'">Личный код владельца</label>
                        <input :id="item.index.$model + '_owner_code'"
                               autocomplete="off"
                               type="text"
                               :disabled="disabled_item"
                               v-model.trim="item.owner_code.$model"
                               @input="delayTouch(item.owner_code)">
                    </div>
                </div>
            </div>
        </div>


        <div v-if="!disabled_item" class="mb-20">
            <hr>

            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <p class="mb-2 font-500">Залоговая недвижимость</p>

                <button class="mb-2 btn-small btn-v2" @click="addMortgage()">
                    <span class="nowrap">Добавить залог</span>
                </button>
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

    import { requiredRule, onlyNumRuleNoReq, noValid } from '../../../../services/validation';
    const touchMap = new WeakMap();

    export default {
        components: {
            Multiselect
        },

        props: ['data', 'url', 'disabled_item', 'check_user_data', 'user_id'],
        data() {
            return {
                postData: [
                    {
                        index: 1,
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
                ],

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
                loading: false
            }
        },

        created() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });
        },

        watch: {
            data() {
                this.init();
            }
        },

        mounted() {
            this.init();
        },

        computed: {
            valid() {
                return !this.$v.$invalid
            }
        },

        methods: {
            init() {
                //
                // if(this.data && this.data.length > 0) {
                //     this.postData = [];
                //     this.data.forEach(item => {
                //         if(item.mortgage_user_id == this.user_id) {
                //             let data = {};
                //
                //             data.index = this.index;
                //             data.area = item.area;
                //             data.land_area = item.land_area;
                //             data.living_area = item.living_area;
                //             data.purpose = item.purpose;
                //             data.cadastral_number = item.cadastral_number;
                //             data.energy_class = item.energy_class;
                //             data.city = item.city;
                //             data.address = item.address;
                //             data.registration_number = item.registration_number;
                //             data.serf_number = item.serf_number;
                //             data.partnership_code = item.partnership_code;
                //             data.owner = item.owner;
                //             data.owner_code = item.owner_code;
                //             data.cost = item.cost;
                //
                //             if(item.type == 1) data.type_select = {id: 1, title: 'Квартира'};
                //             if(item.type == 2) data.type_select = {id: 2, title: 'Многоквартирный дом'};
                //             if(item.type == 3) data.type_select = {id: 3, title: 'Дом'};
                //             if(item.type == 4) data.type_select = {id: 4, title: 'Дача'};
                //             if(item.type == 5) data.type_select = {id: 5, title: 'Производственное помещение'};
                //
                //             if (item.country) {
                //                 data.country = JSON.parse(item.country);
                //             }
                //
                //             this.postData.push(data);
                //
                //             this.index ++;
                //         }
                //     })
                // }
            },
            saveData() {
                this.$v.$touch();

                if(this.check_user_data) {
                    if(this.$v.$invalid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Внимание',
                            html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`
                        });
                        return;
                    }

                    else {
                        this.postData.forEach(item => {
                            const options = {
                                headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                            };

                            if (item.type_select) item.type = item.type_select.id;

                            let formData = new FormData();
                            for (let key in item) {
                                if (item[key]) formData.append(key, item[key]);
                            }

                            axios.post(this.url, formData, options)
                                .then(response => {
                                    if (response.status == 200) {
                                        this.postData = [];
                                        this.$emit('init_data', true);

                                        // Swal.fire({
                                        //     icon: 'success',
                                        //     title: 'Готово',
                                        //     html: 'Данные успешно сохранены.',
                                        // })
                                    }
                                })
                                .finally(() => {
                                    this.$v.$reset();
                                    this.loading = false;
                                })
                        })
                    }
                }

                if(!this.check_user_data && this.$v.$invalid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`
                    });
                    return;
                }
            },

            addMortgage() {
                let obj = {
                    index: this.index,
                    type_select: null,
                    area: null,
                    land_area: null,
                    living_area: null,
                    purpose: null,
                    cadastral_number: null,
                    energy_class: null,
                    country: null,
                    city: null,
                    address: null,
                    registration_number: null,
                    serf_number: null,
                    partnership_code: null,
                    owner: null,
                    owner_code: null,
                    cost: null,
                };
                this.postData.push(obj);
                this.index ++;

                this.$emit('mortgage_validation', false);
            },

            cancelItem(item) {
                let data = this.postData;
                data = data.splice(item, 1);
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000));

                this.$emit('mortgage_validation', this.valid);

            },

        },

        validations: {
            postData: {
                $each: {
                    index: requiredRule,
                    type_select: requiredRule,
                    area: onlyNumRuleNoReq,
                    land_area: onlyNumRuleNoReq,
                    living_area: onlyNumRuleNoReq,
                    purpose: noValid,
                    cadastral_number: noValid,
                    energy_class: noValid,
                    country: requiredRule,
                    city: requiredRule,
                    address: requiredRule,
                    registration_number: onlyNumRuleNoReq,
                    serf_number: onlyNumRuleNoReq,
                    partnership_code: onlyNumRuleNoReq,
                    owner: noValid,
                    owner_code: noValid,
                    cost: onlyNumRuleNoReq,
                }}}
    }
</script>
