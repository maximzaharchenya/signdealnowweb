<template>
    <div :class="{'card--common': !show_for_notary}">
        <div class="card--common__header header-sticky" v-if="!show_for_notary">
            <h3 class="mb-0">Договорной процесс</h3>

            <div class="d-none d-md-block">
                <button class="btn-small btn-v2 mr-3"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
                <button class="btn-small btn-v1" @click="saveData()" v-if="!disabled_item">
                    <span v-if="edit_page">Сохранить изменения</span>
                    <span v-if="!edit_page">Сохранить</span>
                </button>
            </div>

        </div>

        <div :class="{'card--common__body': !show_for_notary}">
            <div class="custom-form">
                <p class="font-500 mb-20" v-if="!disabled_item">Заполните данные об объекте недвижимости:</p>
                <p class="font-500 mb-20" v-if="disabled_item">Данные об объекте недвижимости:</p>


                <div class="row mb-40">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.type.$error, 'is-valid': !$v.type.$invalid, 'disabled--item': disabled_item}">
                            <label>Тип объекта*</label>
                            <multiselect @input="delayTouch($v.type)"
                                         v-model.trim="type"
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
                             :class="{'is-invalid': $v.postData.area.$error, 'is-valid': postData.area && !$v.postData.area.$invalid, 'disabled--item': disabled_item}">
                            <label for="area">Площадь объекта, м<sup>2</sup></label>
                            <input id="area"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.area)"
                                   v-model.trim="postData.area">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.land_area.$error, 'is-valid': postData.land_area && !$v.postData.land_area.$invalid, 'disabled--item': disabled_item}">
                            <label for="land_area">Площадь земельного участка, м<sup>2</sup></label>
                            <input id="land_area"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.land_area)"
                                   v-model.trim="postData.land_area">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.living_area.$error, 'is-valid': postData.living_area && !$v.postData.living_area.$invalid, 'disabled--item': disabled_item}">
                            <label for="living_area">Жилая площадь объекта, м<sup>2</sup></label>
                            <input id="living_area"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.living_area)"
                                   v-model.trim="postData.living_area">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': postData.purpose}">
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
                        <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': postData.energy_class}">
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
                             :class="{'is-invalid': $v.postData.country.$error, 'is-valid': !$v.postData.country.$invalid, 'disabled--item': disabled_item}">
                            <label>Страна объекта*</label>
                            <multiselect @input="delayTouch($v.postData.country)"
                                         v-model.trim="postData.country"
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
                            <label for="city">Город объекта*</label>
                            <input id="city"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.city)"
                                   v-model.trim="postData.city">
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.address.$error, 'is-valid': !$v.postData.address.$invalid, 'disabled--item': disabled_item}">
                            <label for="address">Адрес объекта (улица, дом, квартира)*</label>
                            <input id="address"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"v
                                   @input="delayTouch($v.postData.address)"
                                   v-model.trim="postData.address">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.property_cost.$error, 'is-valid': postData.property_cost && !$v.postData.property_cost.$invalid, 'disabled--item': disabled_item}">
                            <label for="property_cost">Стоимость объекта, евро</label>
                            <input id="property_cost"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.property_cost)"
                                   v-model.trim="postData.property_cost">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': postData.cadastral_number}">
                            <label for="cadastral_number">Кадастровый номер</label>
                            <input id="cadastral_number"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   v-model="postData.cadastral_number">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.registration_number.$error, 'is-valid': postData.registration_number && !$v.postData.registration_number.$invalid, 'disabled--item': disabled_item}">
                            <label for="registration_number">Регистрационный номер</label>
                            <input id="registration_number"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.registration_number)"
                                   v-model.trim="postData.registration_number">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.partnership_code.$error, 'is-valid': postData.partnership_code && !$v.postData.partnership_code.$invalid, 'disabled--item': disabled_item}">
                            <label for="partnership_code">Регистрационный код товарищества</label>
                            <input id="partnership_code"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.partnership_code)"
                                   v-model.trim="postData.partnership_code">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item" :class="{'disabled--item': disabled_item, 'is-valid': postData.owner_property}">
                            <label for="owner_property">Имя Фамилия владельца объекта</label>
                            <input id="owner_property"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   v-model="postData.owner_property">
                        </div>
                    </div>

                    <div class="col-4" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.personal_identification_code.$error, 'is-valid': postData.personal_identification_code && !$v.postData.personal_identification_code.$invalid, 'disabled--item': disabled_item}">
                            <label for="personal_identification_code">Личный код владельца</label>
                            <input id="personal_identification_code"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   v-model="postData.personal_identification_code">
                        </div>
                    </div>
                </div>


                <div class="d-flex flex-wrap align-items-center justify-content-between" v-if="!co_owner_data && user_role == 1">
                    <p class="mb-2 font-500">Совладелец</p>

                    <button class="btn-small mb-2 btn-v2" @click="addCoOwner()">
                        <span class="nowrap">Добавить совладельца</span>
                    </button>
                </div>

                <div v-if="co_owner_data">
                    <div v-for="(item,i) in $v.coOwnerData.$each.$iter" :key="i" class="mb-40">
                        <div v-if="!disabled_item" class="mb-20 d-flex align-items-center justify-content-between">
                            <p class="font-500 mb-0" >Заполните данные о совладельце:</p>
                            <div>
                                <span class="cursor-pointer color-text-primary text-underline" @click="cancelItem(i)">отменить</span>
                            </div>
                        </div>

                        <p class="font-500 mb-20" v-if="disabled_item">Данные о совладельце:</p>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-20 form--item"  :class="{'disabled--item': disabled_item, 'is-invalid': item.name.$error, 'is-valid': !item.name.$invalid}">
                                    <label :for="item.index.$model + '_name'">Имя Фамилия совладельца объекта*</label>
                                    <input :id="item.index.$model + '_name'"
                                           autocomplete="off"
                                           type="text"
                                           :disabled="disabled_item"
                                           v-model.trim="item.name.$model"
                                           @input="delayTouch(item.name)">
                                </div>
                            </div>

                            <div class="col-4" v-if="!disabled_item">
                                <div class="mb-20 form--item"  :class="{'disabled--item': disabled_item, 'is-invalid': item.number.$error, 'is-valid': item.number.$model && !item.number.$invalid}">
                                    <label :for="item.index.$model + '_number'">Личный код совладельца*</label>
                                    <input :id="item.index.$model + '_number'"
                                           autocomplete="off"
                                           type="text"
                                           :disabled="disabled_item"
                                           v-model.trim="item.number.$model"
                                           @input="delayTouch(item.number)">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <p class="mb-2 font-500">Совладелец</p>

                        <button class="btn-small btn-v2 mb-2" @click="addCoOwner()">
                            <span class="nowrap">Добавить совладельца</span>
                        </button>
                    </div>
                </div>


            </div>

            <div class="d-block d-md-none pt-4">
                <button class="btn-small btn-v2 w-100"
                        @click="approveData()"
                        v-if="user_role == 1 || user_role == 2 || user_role == 9 || user_role == 10 || user_role == 12"
                        :disabled="user_approved == 1">
                    <span v-if="user_approved == 1">Изменения одобрены</span>
                    <span v-else>Одобрить изменения</span>
                </button>
            </div>
        </div>

        <div class="load-box" v-if="loading">
            <b-spinner></b-spinner>
        </div>

        <div class="mobile-footer-btn-container" v-if="!disabled_item">
            <button class="btn-small btn-v1 w-100" @click="saveData()">
                <span v-if="edit_page">Сохранить изменения</span>
                <span v-if="!edit_page">Сохранить</span>
            </button>
        </div>

    </div>

</template>


<script>
    import {onlyNumRuleNoReq, requiredRule, personalNumberRuleNoReq} from '../../../services/validation';
    const touchMap = new WeakMap();

    import RequestsServices from '../../../services/requests';
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            Multiselect
        },
        props: ['deal', 'disabled_item', 'user_role', 'user_approved', 'show_for_notary'],
        data() {
            return {
                data: null,
                url: '/api/deal/' + this.$route.params.id + '/property_data',

                postData: {
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
                    partnership_code: null,
                    owner_property: null,
                    personal_identification_code: null,
                    property_cost: null,
                },
                coOwnerData: [],
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

                co_owner_data: false,
                coOwnerIndex: 1,

                loading: true,
                edit_page: false
            }
        },

        created() {
            RequestsServices.countries().then(response => {
                this.countries_options = response;
            });
        },

        mounted() {
            this.init();
        },

        watch: {
            deal() {
                this.init();
            }
        },

        methods: {
            init() {
                if(this.deal.property_data) {
                    let data = JSON.parse(this.deal.property_data);

                    if (data) {
                        this.postData.area = data.area;
                        this.postData.land_area = data.land_area;
                        this.postData.living_area = data.living_area;
                        this.postData.purpose = data.purpose;
                        this.postData.cadastral_number = data.cadastral_number;
                        this.postData.energy_class = data.energy_class;
                        this.postData.city = data.city;
                        this.postData.address = data.address;
                        this.postData.registration_number = data.registration_number;
                        this.postData.partnership_code = data.partnership_code;
                        this.postData.personal_identification_code = data.personal_identification_code;
                        this.postData.property_cost = data.property_cost;
                        this.postData.owner_property = data.owner_property;
                        if(data.type == 1) this.type = {id: 1, title: 'Квартира'};
                        if(data.type == 2) this.type = {id: 2, title: 'Многоквартирный дом'};
                        if(data.type == 3) this.type = {id: 3, title: 'Дом'};
                        if(data.type == 4) this.type = {id: 4, title: 'Дача'};
                        if(data.type == 5) this.type = {id: 5, title: 'Производственное помещение'};

                        this.postData.country = data.country;

                        this.edit_page = true;
                    }

                    this.loading = false;
                }

                if(!this.deal.property_data) {
                    this.postData.cadastral_number = this.deal.cadastral_number;
                    this.postData.city = this.deal.city;
                    this.postData.address = this.deal.address;
                    this.postData.country = this.deal.country;
                }

                if(this.deal.co_owner_data) {
                    let co_owner_data = JSON.parse(this.deal.co_owner_data);
                    co_owner_data.forEach(item => {
                        this.coOwnerData.push(item)
                    })
                    this.co_owner_data = true;

                    this.loading = false;
                }

                else this.loading = false;
            },

            saveData() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Внимание',
                        html: 'Некоторые поля заполнены некорректно'
                    });
                    return;
                } else {
                    this.loading = true;

                    const options = {
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };
                    if (this.type) this.postData.type = this.type.id;
                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    axios.post(this.url, formData, options)
                        .then(response => {
                            if (response.status == 200) {
                                if(this.co_owner_data) this.saveCoOwnerData();
                                if(!this.co_owner_data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Готово',
                                        html: 'Данные успешно сохранены.',
                                    })
                                    this.$emit('init_data', true);
                                }

                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }
            },

            saveCoOwnerData() {
                let url = '/api/deal/' + this.$route.params.id + '/co_owner_data';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };
                let formData = JSON.stringify(this.coOwnerData);
                axios.post(url, {'co_owner_data': formData}, options)
                    .then(response => {
                        if (response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Данные успешно сохранены.',
                            })
                            this.$emit('init_data', true);
                        }
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },

            addCoOwner() {
                this.co_owner_data = true;
                let obj = {};
                obj.name = null;
                obj.number = null;
                obj.index = this.coOwnerIndex;
                this.coOwnerData.push(obj);

                this.coOwnerIndex ++;
            },

            cancelItem(item) {
                let data = this.coOwnerData;
                data = data.splice(item, 1);
                this.co_owner_data = data;
            },

            approveData() {
                this.$emit('approve_data', true);
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000))
            },
        },

        validations() {
            if(!this.co_owner_data) {
                return {
                    postData: {
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,
                        area: onlyNumRuleNoReq,
                        land_area: onlyNumRuleNoReq,
                        living_area: onlyNumRuleNoReq,
                        property_cost: onlyNumRuleNoReq,
                        registration_number: onlyNumRuleNoReq,
                        partnership_code: onlyNumRuleNoReq,
                        personal_identification_code: personalNumberRuleNoReq
                    },
                    type: requiredRule,
                }
            }
            else {
                return {
                    postData: {
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,
                        area: onlyNumRuleNoReq,
                        land_area: onlyNumRuleNoReq,
                        living_area: onlyNumRuleNoReq,
                        property_cost: onlyNumRuleNoReq,
                        registration_number: onlyNumRuleNoReq,
                        partnership_code: onlyNumRuleNoReq,
                        personal_identification_code: personalNumberRuleNoReq

                    },
                    type: requiredRule,

                    coOwnerData: {
                        $each: {
                            name: requiredRule,
                            number: personalNumberRuleNoReq,
                            index: requiredRule
                        }
                    }
                }
            }

        },
    }
</script>
