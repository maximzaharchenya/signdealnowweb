<template>
    <div>
        <div class="custom-form">


            <div class="mb-16 d-flex flex-wrap align-items-center justify-content-between" v-if="!disabled_item">
                <p class="font-500 mb-1 pr-3">
                    Выберите, кто вы, и заполните данные:
                </p>

                <div class="d-flex align-items-center mb-1">
                    <img src="/svg/help.svg" alt="" class="mr-1 d-none d-sm-inline-block">
                    <span>Эти данные будут видны только вам до момента подписания договора.</span>
                </div>
            </div>
            <p v-else class="font-500 mb-20">Данные:</p>

            <div class="mb-40 row" v-if="!disabled_item">
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="person = true"
                            :class="{'btn-filter-active': person}">
                        Физическое лицо
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="person = false"
                            :class="{'btn-filter-active': !person}">
                        Юридическое лицо
                    </button>
                </div>
            </div>


            <div v-if="disabled_item" class="row mb-40">
                <div class="col-6">
                    <button class="btn-small btn-filter btn-filter-active no-effects">
                        <span v-if="person">Физическое лицо</span>
                        <span v-if="!person">Юридическое лицо</span>
                    </button>
                </div>
            </div>


            <!-- ФИЗИЧЕСКОЕ ЛИЦО -->

            <div v-if="person">
                <div class="row mb-40">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.name.$error, 'is-valid': !$v.postData.name.$invalid, 'disabled--item': disabled_item}">
                            <label for="name">Имя*</label>
                            <input id="name"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.name)"
                                   v-model.trim="postData.name">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.surname.$error, 'is-valid': !$v.postData.surname.$invalid, 'disabled--item': disabled_item}">
                            <label for="surname">Фамилия*</label>
                            <input id="surname"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.surname)"
                                   v-model.trim="postData.surname">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.date_of_birth.$error, 'is-valid': !$v.date_of_birth.$invalid, 'disabled--item': disabled_item}">
                            <label for="date_of_birth">Дата рождения*</label>
                            <input id="date_of_birth"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   placeholder="##.##.####"
                                   v-mask="'##.##.####'"
                                   @input="delayTouch($v.date_of_birth)"
                                   v-model.trim="date_of_birth">
                        </div>
                    </div>

                    <div class="col-4" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.email.$error, 'is-valid': !$v.postData.email.$invalid}">
                            <label for="email">Email*</label>
                            <input id="email"
                                   autocomplete="off"
                                   type="text"
                                   @input="delayTouch($v.postData.email)"
                                   v-model.trim="postData.email">
                        </div>
                    </div>

                    <div class="col-4" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.number.$error, 'is-valid': !$v.postData.number.$invalid}">
                            <label for="personal_code">Личный код*</label>
                            <input id="personal_code"
                                   autocomplete="off"
                                   type="text"
                                   @input="delayTouch($v.postData.number)"
                                   v-model.trim="postData.number">
                        </div>
                    </div>

                    <div class="col-4" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible}">
                            <label for="phone">Телефон*</label>
                            <vue-tel-input id="phone"
                                           autocomplete="off"
                                           type="text"
                                           @input="delayTouch($v.postData.phone)"
                                           v-model.trim="postData.phone"
                                           :inputOptions="inputOptions"
                                           :mode="mode"
                                           @validate="telValidate"
                                           @blur="blur"
                                           :validCharactersOnly="validCharactersOnly"
                            ></vue-tel-input>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item is-valid"
                             :class="{'disabled--item': disabled_item}">
                            <label for="phone">Семейное положение*</label>
                            <multiselect v-model="family_status"
                                         :options="family_status_options"
                                         :allow-empty="false"
                                         :searchable="false"
                                         deselect-label=""
                                         placeholder=""
                                         selected-label=""
                                         select-label=""
                                         label="name"
                                         track-by="name"
                                         :disabled="disabled_item"
                            ></multiselect>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item" v-if="countries_options"
                             :class="{'is-invalid': $v.postData.country.$error, 'is-valid': !$v.postData.country.$invalid, 'disabled--item': disabled_item}">
                            <label>Страна*</label>
                            <multiselect v-model.trim="postData.country"
                                         @input="delayTouch($v.postData.country)"
                                         :options="countries_options"
                                         :allow-empty="false"
                                         :searchable="true"
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
                            <label for="city">Город*</label>
                            <input id="city"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   v-model.trim="postData.city"
                                   @input="delayTouch($v.postData.city)">
                        </div>
                    </div>

                    <div class="col-12" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.address.$error, 'is-valid': !$v.postData.address.$invalid, 'disabled--item': disabled_item}">
                            <label for="address">Точный адрес (улица, дом, квартира)*</label>
                            <input id="address"
                                   autocomplete="off"
                                   type="text"
                                   :disabled="disabled_item"
                                   v-model.trim="postData.address"
                                   @input="delayTouch($v.postData.address)">
                        </div>
                    </div>
                </div>


                <!--  MARRIED _____ DATA  -->
                <div v-if="family_status.id == 1">
                    <hr>

                    <p class="font-500 mb-40">Заполните данные о супруге:</p>

                    <div class="row mb-40">
                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.name.$error, 'is-valid': !$v.marriedData.name.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_name">Имя*</label>
                                <input id="marriedData_name"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.name)"
                                       v-model.trim="marriedData.name">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.surname.$error, 'is-valid': !$v.marriedData.surname.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_surname">Фамилия*</label>
                                <input id="marriedData_surname"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.surname)"
                                       v-model.trim="marriedData.surname">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.married_date_of_birth.$error, 'is-valid': !$v.married_date_of_birth.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_date_of_birth">Дата рождения*</label>
                                <input id="marriedData_date_of_birth"
                                       autocomplete="off"
                                       placeholder="##.##.####"
                                       v-mask="'##.##.####'"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.married_date_of_birth)"
                                       v-model.trim="married_date_of_birth"
                                       v-model="married_date_of_birth">
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.email.$error, 'is-valid': !$v.marriedData.email.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_email">Email*</label>
                                <input id="marriedData_email"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.email)"
                                       v-model.trim="marriedData.email">
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.number.$error, 'is-valid': !$v.marriedData.number.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_personal_code">Личный код*</label>
                                <input id="marriedData_personal_code"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.number)"
                                       v-model.trim="marriedData.number">
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': !phoneValid_marriedData && possible_marriedData, 'is-valid': phoneValid_marriedData && !possible_marriedData, 'disabled--item': disabled_item}">
                                <label for="marriedData_phone">Телефон*</label>
                                <vue-tel-input id="marriedData_phone"
                                               autocomplete="off"
                                               type="text"
                                               @input="delayTouch($v.marriedData.phone)"
                                               v-model.trim="marriedData.phone"
                                               :inputOptions="inputOptions"
                                               :mode="mode"
                                               :disabled="disabled_item"
                                               @validate="telValidate_marriedData"
                                               @blur="blur_marriedData"
                                               :validCharactersOnly="validCharactersOnly"
                                ></vue-tel-input>
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.requisites.$error, 'is-valid': !$v.marriedData.requisites.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_requisites">Реквизиты*</label>
                                <input id="marriedData_requisites"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.requisites)"
                                       v-model.trim="marriedData.requisites">
                            </div>
                        </div>


                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item" v-if="countries_options"
                                 :class="{'is-invalid': $v.marriedData.country.$error, 'is-valid': !$v.marriedData.country.$invalid, 'disabled--item': disabled_item}">
                                <label>Страна*</label>
                                <multiselect @input="delayTouch($v.marriedData.country)"
                                             v-model.trim="marriedData.country"
                                             :options="countries_options"
                                             :allow-empty="false"
                                             :disabled="disabled_item"
                                             :searchable="true"
                                             deselect-label=""
                                             placeholder=""
                                             selected-label=""
                                             select-label=""
                                ><span slot="noResult">Совпадений не найдено</span></multiselect>
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.city.$error, 'is-valid': !$v.marriedData.city.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_city">Город*</label>
                                <input id="marriedData_city"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.city)"
                                       v-model.trim="marriedData.city">
                            </div>
                        </div>

                        <div class="col-12" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.marriedData.address.$error, 'is-valid': !$v.marriedData.address.$invalid, 'disabled--item': disabled_item}">
                                <label for="marriedData_address">Точный адрес (улица, дом, квартира)*</label>
                                <input id="marriedData_address"
                                       autocomplete="off"
                                       type="text"
                                       :disabled="disabled_item"
                                       @input="delayTouch($v.marriedData.address)"
                                       v-model.trim="marriedData.address">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ЮРИДИЧЕСКОЕ ЛИЦО -->
            <div v-if="!person">
                <div class="row mb-40">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.commercial_code.$error, 'is-valid': !$v.postData.commercial_code.$invalid, 'disabled--item': disabled_item}">
                            <label for="commercial_code">Код коммерческого регистра*</label>
                            <input id="commercial_code"
                                   @input="delayTouch($v.postData.commercial_code)"
                                   v-model.trim="postData.commercial_code"
                                   autocomplete="off"
                                   :disabled="disabled_item"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.commercial_name.$error, 'is-valid': !$v.postData.commercial_name.$invalid, 'disabled--item': disabled_item}">
                            <label for="commercial_name">Наименование коммерческого товарищества*</label>
                            <input id="commercial_name"
                                   @input="delayTouch($v.postData.commercial_name)"
                                   v-model.trim="postData.commercial_name"
                                   autocomplete="off"
                                   :disabled="disabled_item"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.email.$error, 'is-valid': !$v.postData.email.$invalid, 'disabled--item': disabled_item}">
                            <label for="email_legal">Email*</label>
                            <input id="email_legal"
                                   @input="delayTouch($v.postData.email)"
                                   v-model.trim="postData.email"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-4" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': !phoneValid && possible, 'is-valid': phoneValid && !possible}">
                            <label for="phone_legal">Телефон*</label>
                            <vue-tel-input id="phone_legal"
                                           autocomplete="off"
                                           type="text"
                                           @input="delayTouch($v.postData.phone)"
                                           v-model.trim="postData.phone"
                                           :inputOptions="inputOptions"
                                           :mode="mode"
                                           @validate="telValidate"
                                           @blur="blur"
                                           :validCharactersOnly="validCharactersOnly"
                            ></vue-tel-input>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item" v-if="countries_options"
                             :class="{'is-invalid': $v.postData.country.$error, 'is-valid': !$v.postData.country.$invalid, 'disabled--item': disabled_item}">
                            <label>Страна*</label>
                            <multiselect @input="delayTouch($v.postData.country)"
                                         v-model.trim="postData.country"
                                         :options="countries_options"
                                         :allow-empty="false"
                                         :searchable="true"
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
                            <label for="city_legal">Город*</label>
                            <input id="city_legal"
                                   @input="delayTouch($v.postData.city)"
                                   v-model.trim="postData.city"
                                   autocomplete="off"
                                   :disabled="disabled_item"
                                   type="text">
                        </div>
                    </div>

                    <div class="col-8" v-if="!disabled_item">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.address.$error, 'is-valid': !$v.postData.address.$invalid, 'disabled--item': disabled_item}">
                            <label for="address_legal">Адрес организации (улица, дом, квартира)*</label>
                            <input id="address_legal"
                                   :disabled="disabled_item"
                                   @input="delayTouch($v.postData.address)"
                                   v-model.trim="postData.address"
                                   autocomplete="off"
                                   type="text">
                        </div>
                    </div>


                </div>

                <hr>
                <div>
                    <p class="mb-20 font-500" v-if="!disabled_item">Выберите роль представителя и заполните его
                        данные:</p>
                    <p v-else class="mb-20 font-500">Роль представителя:</p>

                    <div class="row mb-40" v-if="!disabled_item">
                        <div class="col-6">
                            <button class="btn-small btn-filter"
                                    @click="postData.representative_role = 1"
                                    :class="{'btn-filter-active': postData.representative_role == 1}">
                                Законный представитель
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn-small btn-filter"
                                    @click="postData.representative_role = 2"
                                    :class="{'btn-filter-active': postData.representative_role == 2}">
                                Доверенное лицо
                            </button>
                        </div>
                    </div>

                    <div v-if="disabled_item" class="row mb-40">
                        <div class="col-6">
                            <button class="btn-small btn-filter btn-filter-active">
                                <span v-if="postData.representative_role == 1">Законный представитель</span>
                                <span v-if="!postData.representative_role == 2">Доверенное лицо</span>
                            </button>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.postData.representative_name.$error, 'is-valid': !$v.postData.representative_name.$invalid, 'disabled--item': disabled_item}">
                                <label for="representative_name">Имя*</label>
                                <input id="representative_name"
                                       @input="delayTouch($v.postData.representative_name)"
                                       v-model.trim="postData.representative_name"
                                       autocomplete="off"
                                       :disabled="disabled_item"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.postData.representative_surname.$error, 'is-valid': !$v.postData.representative_surname.$invalid, 'disabled--item': disabled_item}">
                                <label for="representative_surname">Фамилия*</label>
                                <input id="representative_surname"
                                       @input="delayTouch($v.postData.representative_surname)"
                                       v-model.trim="postData.representative_surname"
                                       autocomplete="off"
                                       :disabled="disabled_item"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.representative_date_of_birth.$error, 'is-valid': !$v.representative_date_of_birth.$invalid, 'disabled--item': disabled_item}">
                                <label for="representative_date_of_birth">Дата рождения*</label>
                                <input id="representative_date_of_birth"
                                       placeholder="##.##.####"
                                       v-mask="'##.##.####'"
                                       @input="delayTouch($v.representative_date_of_birth)"
                                       v-model.trim="representative_date_of_birth"
                                       autocomplete="off"
                                       :disabled="disabled_item"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.postData.representative_email.$error, 'is-valid': !$v.postData.representative_email.$invalid, 'disabled--item': disabled_item}">
                                <label for="representative_email">Email*</label>
                                <input id="representative_email"
                                       @input="delayTouch($v.postData.representative_email)"
                                       v-model.trim="postData.representative_email"
                                       autocomplete="off"
                                       :disabled="disabled_item"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': $v.postData.representative_number.$error, 'is-valid': !$v.postData.representative_number.$invalid, 'disabled--item': disabled_item}">
                                <label for="representative_number">Личный код*</label>
                                <input id="representative_number"
                                       @input="delayTouch($v.postData.representative_number)"
                                       v-model.trim="postData.representative_number"
                                       autocomplete="off"
                                       :disabled="disabled_item"
                                       type="text">
                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item"
                                 :class="{'is-invalid': !phoneValid_representative && possible_representative, 'is-valid': phoneValid_representative && !possible_representative, 'disabled--item': disabled_item}">
                                <label for="representative_phone">Телефон*</label>
                                <vue-tel-input id="representative_phone"
                                               autocomplete="off"
                                               type="text"
                                               @input="delayTouch($v.postData.representative_phone)"
                                               v-model.trim="postData.representative_phone"
                                               :inputOptions="inputOptions"
                                               :mode="mode"
                                               :disabled="disabled_item"
                                               @validate="telValidate_representative"
                                               @blur="blur_representative"
                                               :validCharactersOnly="validCharactersOnly"
                                ></vue-tel-input>

                            </div>
                        </div>

                        <div class="col-4" v-if="!disabled_item">
                            <div class="mb-20 form--item image-loader"
                                 :class="{'is-invalid': $v.postData.representative_power_of_attorney.$error, 'is-valid': !$v.postData.representative_power_of_attorney.$invalid, 'disabled--item': disabled_item}">
                                <label>Доверенность (скан PDF или asics)*</label>

                                <b-form-file
                                    id="representative_power_of_attorney"
                                    @input="delayTouch($v.postData.representative_power_of_attorney)"
                                    v-model.trim="postData.representative_power_of_attorney"
                                    :placeholder="load_representative_power_of_attorney ? 'Файл загружен': 'Файл не выбран'"
                                    drop-placeholder="Перетащите файл сюда"
                                ></b-form-file>

                            </div>
                        </div>

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
    import {
        emailRule,
        requiredRule,
        birthRule,
        onlyNumRule,
        requiredRuleAttorney,
        personalNumberRule
    } from '../../../../services/validation';

    const touchMap = new WeakMap();

    import Multiselect from 'vue-multiselect';
    import {VueTelInput} from 'vue-tel-input';

    import RequestsServices from '../../../../services/requests';
    import {echoDate} from '../../../../services/functions';

    export default {
        props: ['data', 'url', 'check_mortgage', 'disabled_item', 'married_data', 'role', 'user_id', 'deal'],

        components: {
            Multiselect,
            VueTelInput
        },


        data() {
            return {
                active: 1,

                postData: {
                    person: 1,
                    name: null,
                    surname: null,
                    number: null,
                    date_of_birth: null,
                    country: null,
                    city: null,
                    address: null,
                    phone: null,
                    email: null,

                    commercial_code: null,
                    commercial_name: null,

                    representative_role: 1,
                    representative_name: null,
                    representative_surname: null,
                    representative_date_of_birth: null,
                    representative_email: null,
                    representative_number: null,
                    representative_phone: null,
                    representative_power_of_attorney: null,

                    role: 1

                },

                person: true,
                date_of_birth: null,
                representative_date_of_birth: null,

                marriedData: {
                    name: null,
                    surname: null,
                    number: null,
                    requisites: null,
                    country: null,
                    city: null,
                    address: null,
                    phone: null,
                    email: null,
                },
                married_date_of_birth: null,

                family_status: {
                    id: 2,
                    name: 'Не женат/ не замужем'
                },
                family_status_options: [
                    {
                        id: 1,
                        name: 'Женат/замужем'
                    },
                    {
                        id: 2,
                        name: 'Не женат/ не замужем'
                    }
                ],
                countries_options: null,

                /*data for vue-tel-input*/
                dynamicPlaceholder: true,
                validCharactersOnly: true,
                enabledCountryCode: true,
                inputOptions: {
                    showDialCode: true,
                },
                mode: 'international',

                phoneValid: '',
                phoneValid_marriedData: '',
                phoneValid_representative: '',

                possible: '',
                possible_marriedData: '',
                possible_representative: '',
                /**/

                type: 1,
                load_representative_power_of_attorney: false,

                loading: true,
            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            },
            valid() {
                return !this.$v.$invalid
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

        methods: {
            init() {
                let data;
                let married_data;


                if (this.data && this.role == 1) data = this.data;

                if (this.data && this.role == 2) {
                    this.data.forEach(item => {
                        if (item.client_user_id == this.user_id) data = item;
                    })
                }
                if (this.married_data) {
                    this.married_data.forEach(item => {
                        if (item.user_id == this.user_id) married_data = item;
                    })
                }

                if (data) {
                    this.postData.country = data.country;
                    this.postData.name = data.name;
                    this.postData.surname = data.surname;
                    this.postData.number = data.number;
                    this.date_of_birth = data.date_of_birth;
                    this.postData.city = data.city;
                    this.postData.address = data.address;
                    this.postData.phone = data.phone;
                    this.postData.email = data.email;

                    this.postData.commercial_code = data.commercial_code;
                    this.postData.commercial_name = data.commercial_name;
                    this.postData.representative_role = data.representative_role;
                    this.postData.representative_name = data.representative_name;
                    this.postData.representative_surname = data.representative_surname;
                    this.postData.representative_date_of_birth = data.representative_date_of_birth;

                    this.postData.representative_number = data.representative_number;
                    this.postData.representative_phone = data.representative_phone;
                    this.postData.representative_email = data.representative_email;

                    if (data.representative_power_of_attorney) {
                        this.load_representative_power_of_attorney = true;
                    } else this.load_representative_power_of_attorney = false;

                    this.date_of_birth = this.checkDate(data.date_of_birth);
                    this.representative_date_of_birth = this.checkDate(data.representative_date_of_birth);

                    if (data.person == 0) this.person = true;
                    if (data.person == 1) this.person = false;

                    if (data.family_status == 1) this.family_status = {id: 1, name: 'Женат/замужем'};
                    if (data.family_status == 2) this.family_status = {id: 2, name: 'Не женат/ не замужем'};

                    this.$emit('edit_page', true);
                }


                if (married_data) {
                    this.marriedData.country = married_data.country;
                    this.marriedData.name = married_data.name;
                    this.marriedData.surname = married_data.surname;
                    this.marriedData.number = married_data.number;
                    this.marriedData.requisites = married_data.requisites;
                    this.marriedData.city = married_data.city;
                    this.marriedData.address = married_data.address;
                    this.marriedData.phone = married_data.phone;
                    this.marriedData.email = married_data.email;

                    this.married_date_of_birth = this.checkDate(married_data.date_of_birth);
                }

                 if(!data && this.user.id == this.user_id) {
                     this.postData.country = this.user.country;
                     this.postData.name = this.user.name;
                     this.postData.surname = this.user.surname;
                     this.postData.number = this.user.personal_number;
                     this.date_of_birth = this.user.date_of_birth;
                     this.postData.city = this.user.city;
                     this.postData.address = this.user.address;
                     this.postData.phone = this.user.phone;
                     this.postData.email = this.user.email;
                 }

                if(this.valid) this.$emit('user_data_validation', this.valid);

                this.loading = false;
            },

            saveData() {
                let valid = false;
                this.$v.$touch();

                /*Check mortagage validation*/
                if (this.check_mortgage) {
                    /* CHECK VALID_1 */
                    if (this.person && this.family_status.id == 2) {
                        if (this.$v.$invalid || !this.phoneValid) {
                            if (!this.phoneValid) this.possible = true;
                            Swal.fire({
                                icon: 'error',
                                title: 'Внимание',
                                html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`,
                            });
                            return;
                        } else valid = true;
                    }

                    /* CHECK VALID_2 */
                    if (this.person && this.family_status.id == 1) {
                        if (this.$v.$invalid || !this.phoneValid || !this.phoneValid_marriedData) {
                            if (!this.phoneValid) this.possible = true;
                            if (!this.phoneValid_marriedData) this.possible_marriedData = true;
                            Swal.fire({
                                icon: 'error',
                                title: 'Внимание',
                                html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`,
                            });
                            return;
                        } else valid = true;
                    }


                    /* CHECK VALID_3 */
                    if (!this.person) {
                        if (this.$v.$invalid || !this.phoneValid || !this.phoneValid_representative) {
                            if (!this.phoneValid) this.possible = true;
                            if (!this.phoneValid_representative) this.possible_representative = true;
                            Swal.fire({
                                icon: 'error',
                                title: 'Внимание',
                                html: `Поля со * обязательны для заполнения. <br> Некоторые данные внесены некорректно.`,
                            });
                            return;
                        } else valid = true;
                    }

                    if (valid) {
                        this.loading = true;

                        const options = {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                Authorization: "Bearer " + localStorage.getItem('token')
                            }
                        };

                        this.postData.role = this.role;

                        let formData = new FormData();
                        for (let key in this.postData) {
                            if (this.postData[key]) formData.append(key, this.postData[key]);
                        }

                        if (this.person) formData.append('person', 0);
                        else formData.append('person', 1);

                        if (this.family_status.id == 1) formData.append('family_status', 1);
                        else formData.append('family_status', 0);

                        if (this.date_of_birth) {
                            let date_of_birth = this.date_of_birth.split('.').reverse().join('-');
                            formData.append('date_of_birth', date_of_birth);
                        }

                        if (this.representative_date_of_birth) {
                            let date_of_birth = this.representative_date_of_birth.split('.').reverse().join('-');
                            formData.append('representative_date_of_birth', date_of_birth);
                        }

                        axios.post(this.url, formData, options)
                            .then(response => {
                                if (response.status == 200) {
                                    if (this.family_status.id == 1 && this.person) this.saveMarriedData();
                                    else {
                                        if (this.check_mortgage) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Готово',
                                                html: 'Данные успешно сохранены.',
                                            });
                                            this.$emit('init_data', true);
                                        }

                                    }
                                }
                            })
                            .finally(() => {
                                this.loading = false;
                            })

                    }
                }
            },


            saveMarriedData() {
                let formData = new FormData();
                for (let key in this.marriedData) {
                    if (this.marriedData[key]) formData.append(key, this.marriedData[key]);
                }

                if (this.married_date_of_birth) {
                    let date_of_birth = this.married_date_of_birth.split('.').reverse().join('-');
                    formData.append('date_of_birth', date_of_birth);
                }

                let url_married = '/api/deal/' + this.$route.params.id + '/married_data';
                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.post(url_married, formData, options)
                    .then(response => {
                        if (response.status == 200) {
                            if (this.check_mortgage) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Готово',
                                    html: 'Данные успешно сохранены.',
                                });
                                this.$emit('init_data', true);
                            }
                        }
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            },

            delayTouch($v) {
                $v.$reset();
                if (touchMap.has($v)) {
                    clearTimeout(touchMap.get($v))
                }
                touchMap.set($v, setTimeout($v.$touch, 1000));

                this.$emit('user_data_validation', this.valid);
            },

            telValidate(number, isValid, country) {
                this.phoneValid = number.valid;
                this.possible = number.possible;
            },
            blur() {
                if (this.phoneValid == false) {
                    this.possible = true;
                }
            },

            telValidate_marriedData(number, isValid, country) {
                this.phoneValid_marriedData = number.valid;
                this.possible_marriedData = number.possible;
            },
            blur_marriedData() {
                if (this.phoneValid_marriedData == false) {
                    this.possible_marriedData = true;
                }
            },


            telValidate_representative(number, isValid, country) {
                this.phoneValid_representative = number.valid;
                this.possible_representative = number.possible;
            },
            blur_representative() {
                if (this.phoneValid_representative == false) {
                    this.possible_representative = true;
                }
            },

            checkDate(date) {
                return echoDate(date);
            }
        },

        validations() {
            if (this.person && this.family_status.id == 2) {
                return {
                    postData: {
                        name: requiredRule,
                        surname: requiredRule,
                        email: emailRule,
                        number: personalNumberRule,
                        phone: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule
                    },
                    date_of_birth: birthRule
                }
            }

            if (this.person && this.family_status.id == 1) {
                return {
                    postData: {
                        name: requiredRule,
                        surname: requiredRule,
                        email: emailRule,
                        number: personalNumberRule,
                        phone: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule
                    },
                    date_of_birth: birthRule,

                    marriedData: {
                        name: requiredRule,
                        surname: requiredRule,
                        number: personalNumberRule,
                        requisites: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,
                        phone: requiredRule,
                        email: emailRule,
                    },
                    married_date_of_birth: birthRule,
                }
            }

            if (!this.person) {
                return {
                    postData: {
                        commercial_code: onlyNumRule,
                        commercial_name: requiredRule,
                        email: emailRule,
                        phone: requiredRule,
                        country: requiredRule,
                        city: requiredRule,
                        address: requiredRule,

                        representative_name: requiredRule,
                        representative_surname: requiredRule,
                        representative_email: emailRule,
                        representative_number: personalNumberRule,
                        representative_phone: requiredRule,
                        representative_power_of_attorney: requiredRuleAttorney,

                    },
                    representative_date_of_birth: birthRule
                }
            }
        }
    }
</script>
