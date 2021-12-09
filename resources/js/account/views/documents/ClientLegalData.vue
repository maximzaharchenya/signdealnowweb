<template>
    <div class="custom-form" :class="{'card--common': !show_for_notary}">

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
                <button class="btn-small btn-v1" @click="saveData()" v-if="!disabled">
                    <span v-if="edit_page">Сохранить изменения</span>
                    <span v-if="!edit_page">Сохранить</span>
                </button>
            </div>

        </div>

        <div :class="{'card--common__body': !show_for_notary}">
            <p class="mb-20 font-500" v-if="!disabled">Выберите банк покупателя:</p>
            <p class="mb-20 font-500" v-if="disabled">Банк покупателя:</p>

            <div class="mb-40 row" v-if="!disabled">
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="local_bank = 1"
                            :class="{'btn-filter-active': local_bank == 1}">
                        Местный банк
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn-small btn-filter"
                            @click="local_bank = 0"
                            :class="{'btn-filter-active': local_bank == 0}">
                        Зарубежный банк
                    </button>
                </div>
            </div>

            <div v-if="disabled" class="row mb-40">
                <div class="col-6">
                    <button class="btn-small btn-filter btn-filter-active no-effects">
                        <span v-if="local_bank == 1">Местный банк</span>
                        <span v-if="local_bank == 0">Зарубежный банк</span>
                    </button>
                </div>
            </div>

            <div class="row mb-40">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_name.$error, 'is-valid': !$v.postData.bank_name.$invalid, 'disabled--item': disabled}">
                        <label for="bank_name">Наименование банка*</label>
                        <input :disabled="disabled" id="bank_name"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_name)"
                               v-model.trim="postData.bank_name">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_number.$error, 'is-valid': !$v.postData.bank_number.$invalid, 'disabled--item': disabled}">
                        <label for="bank_number">Номер банка*</label>
                        <input :disabled="disabled" id="bank_number"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_number)"
                               v-model.trim="postData.bank_number">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.branch_code.$error, 'is-valid': !$v.postData.branch_code.$invalid, 'disabled--item': disabled}">
                        <label for="branch_code">Регистрационный код филиала*</label>
                        <input :disabled="disabled" id="branch_code"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.branch_code)"
                               v-model.trim="postData.branch_code">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_email.$error, 'is-valid': postData.bank_email && !$v.postData.bank_email.$invalid, 'disabled--item': disabled}">
                        <label for="bank_email">Email банка</label>
                        <input :disabled="disabled" id="bank_email"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_email)"
                               v-model.trim="postData.bank_email"
                               v-model="postData.bank_email">
                    </div>
                </div>

                <div class="col-8">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.bank_address.$error, 'is-valid': postData.bank_address && !$v.postData.bank_address.$invalid, 'disabled--item': disabled}">
                        <label for="bank_address">Адрес банка*</label>
                        <input :disabled="disabled" id="bank_address"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.bank_address)"
                               v-model.trim="postData.bank_address">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.client_account_number.$error, 'is-valid': postData.client_account_number && !$v.postData.client_account_number.$invalid, 'disabled--item': disabled}">
                        <label for="client_account_number">Номер счета*</label>
                        <input :disabled="disabled" id="client_account_number"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.client_account_number)"
                               v-model.trim="postData.client_account_number">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.mortgage_amount.$error, 'is-valid': postData.mortgage_amount && !$v.postData.mortgage_amount.$invalid, 'disabled--item': disabled}">
                        <label for="mortgage_amount">Сумма ипотеки</label>
                        <input :disabled="disabled" id="mortgage_amount"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.mortgage_amount)"
                               v-model.trim="postData.mortgage_amount">
                    </div>
                </div>

                <div class="col-8">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.days_to_conclude_insurance_after_signing.$error, 'is-valid': postData.days_to_conclude_insurance_after_signing && !$v.postData.days_to_conclude_insurance_after_signing.$invalid, 'disabled--item': disabled}">
                        <label for="days_to_conclude_insurance_after_signing">Количество дней для заключения страховки
                            после
                            подписания</label>
                        <input :disabled="disabled" id="days_to_conclude_insurance_after_signing"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.days_to_conclude_insurance_after_signing)"
                               v-model.trim="postData.days_to_conclude_insurance_after_signing">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'is-invalid': $v.postData.insurance_penalty.$error, 'is-valid': postData.insurance_penalty && !$v.postData.insurance_penalty.$invalid, 'disabled--item': disabled}">
                        <label for="insurance_penalty">Штраф за нарушение сроков</label>
                        <input :disabled="disabled" id="insurance_penalty"
                               autocomplete="off"
                               type="text"
                               @input="delayTouch($v.postData.insurance_penalty)"
                               v-model.trim="postData.insurance_penalty">
                    </div>
                </div>


            </div>

            <div class="mb-40" v-if="local_bank == 0">
                <hr>

                <p class="mb-20 font-500" v-if="!disabled">Заполните данные о местном филиале зарубежного банка
                    покупателя:</p>
                <p class="mb-20 font-500" v-if="disabled">Данные о местном филиале зарубежного банка покупателя:</p>

                <div class="row">
                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.foreign_bank_name}">
                            <label for="foreign_bank_name">Наименование банка</label>
                            <input :disabled="disabled" id="foreign_bank_name"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.foreign_bank_name">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.foreign_bank_number}">
                            <label for="foreign_bank_number">Номер банка</label>
                            <input :disabled="disabled" id="foreign_bank_number"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.foreign_bank_number">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.foreign_bank_code}">
                            <label for="foreign_bank_code">Регистрационный код филиала</label>
                            <input :disabled="disabled" id="foreign_bank_code"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.foreign_bank_code">
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-20 form--item"
                             :class="{'is-invalid': $v.postData.foreign_bank_email.$error, 'is-valid': postData.foreign_bank_email && !$v.postData.foreign_bank_email.$invalid, 'disabled--item': disabled}">
                            <label for="foreign_bank_email">Email банка</label>
                            <input :disabled="disabled" id="foreign_bank_email"
                                   autocomplete="off"
                                   type="text"
                                   @input="delayTouch($v.postData.foreign_bank_email)"
                                   v-model.trim="postData.foreign_bank_email">
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="mb-20 form--item"
                             :class="{'disabled--item': disabled, 'is-valid': postData.foreign_bank_address}">
                            <label for="foreign_bank_address">Адрес банка</label>
                            <input :disabled="disabled" id="foreign_bank_address"
                                   autocomplete="off"
                                   type="text"
                                   v-model="postData.foreign_bank_address">
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <p class="mb-20 font-500" v-if="!disabled">Заполните данные о представителе местного банка:</p>
            <p class="mb-20 font-500" v-if="disabled">Данные о представителе местного банка:</p>

            <div class="row mb-40">
                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.bank_representative_name}">
                        <label for="bank_representative_name">Имя</label>
                        <input :disabled="disabled" id="bank_representative_name"
                               autocomplete="off"
                               type="text"
                               v-model="postData.bank_representative_name">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item"
                         :class="{'disabled--item': disabled, 'is-valid': postData.bank_representative_surname}">
                        <label for="bank_representative_surname">Фамилия</label>
                        <input :disabled="disabled" id="bank_representative_surname"
                               autocomplete="off"
                               type="text"
                               v-model="postData.bank_representative_surname">
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-20 form--item" v-if="!disabled"
                         :class="{'is-invalid': $v.postData.bank_representative_personal_code.$error, 'is-valid': postData.bank_representative_personal_code && !$v.postData.bank_representative_personal_code.$invalid, 'disabled--item': disabled}">
                        <label for="bank_representative_personal_code">Личный код</label>
                        <input :disabled="disabled" id="bank_representative_personal_code"
                               autocomplete="off"
                               type="text"
                               v-model="postData.bank_representative_personal_code">
                    </div>
                </div>
            </div>


            <!-- СОХРАНЕННЫЕ ДАННЫЕ ЗАЛОГОДЕРЖАТЕЛЕЙ -->
            <div v-if="holders && holders.length > 0">
                <div v-for="item in holders">
                    <holder-show-data :mortgages_id="mortgages_id" @init_data="init" :data="item"
                                      :user_id="user_id"></holder-show-data>
                </div>
            </div>


            <!-- ВНЕСТИ ДАННЫЕ ЗАЛОГОДЕРЖАТЕЛЕЙ -->
            <div v-if="(mortgageData && mortgageData.length > 1 || the_pledge_holder_of_all_objects_is_one_bank) && !disabled">
                <hr>
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-16">
                    <p class="mb-2 font-500" v-if="!disabled">Заполните данные о залогодержателях:</p>
                    <p class="mb-2 font-500" v-if="disabled">Данные о залогодержателях:</p>

                    <div class="checkbox mb-2">
                        <input :disabled="disabled" type="checkbox" id="is_pledged"
                               v-model="the_pledge_holder_of_all_objects_is_one_bank">
                        <label for="is_pledged">Залогодержатель всех объектов - один банк</label>
                    </div>
                </div>
            </div>


            <div v-if="mortgageData && mortgageData.length > 0 && user_id == user.id" class="mb-40">
                <div v-for="item in $v.mortgageData.$each.$iter">
                    <hr>

                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-20">
                            <p class="mb-0 font-500" v-if="!disabled">
                                Выберите банк залогодержателя
                                <span class="font-400" v-if="!the_pledge_holder_of_all_objects_is_one_bank">(залоговая недвижимость - {{item.mortgage_type.$model}}, {{item.mortgage_address.$model}}) </span>
                                и введите
                                его данные:</p>
                            <p class="mb-0 font-500" v-if="disabled">Банк залогодержателя и его данные:</p>
                        </div>


                        <div class="mb-40 row">
                            <div class="col-6">
                                <button class="btn-small btn-filter"
                                        @click="item.mortgage_holder_local_bank.$model = 1"
                                        :class="{'btn-filter-active': item.mortgage_holder_local_bank.$model == 1}">
                                    Местный банк
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn-small btn-filter"
                                        @click="item.mortgage_holder_local_bank.$model = 0"
                                        :class="{'btn-filter-active': item.mortgage_holder_local_bank.$model == 0}">
                                    Зарубежный банк
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="mb-20 form--item"
                                     :class="{'is-invalid': item.mortgage_holder_name.$error, 'is-valid': !item.mortgage_holder_name.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_name'">Наименование
                                        банка*</label>
                                    <input :disabled="disabled" :id="item.index.$model + '_mortgage_holder_name'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_name.$model"
                                           @input="delayTouch(item.mortgage_holder_name)">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-20 form--item"
                                     :class="{'is-invalid': item.mortgage_holder_number.$error, 'is-valid': !item.mortgage_holder_number.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_number'">Номер банка*</label>
                                    <input :disabled="disabled" :id="item.index.$model + '_mortgage_holder_number'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_number.$model"
                                           @input="delayTouch(item.mortgage_holder_number)">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-20 form--item"
                                     :class="{'is-invalid': item.mortgage_holder_code.$error, 'is-valid': item.mortgage_holder_code.$model && !item.mortgage_holder_code.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_code'">Регистрационный код
                                        филиала</label>
                                    <input :disabled="disabled" :id="item.index.$model + '_mortgage_holder_code'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_code.$model"
                                           @input="delayTouch(item.mortgage_holder_code)">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-20 form--item"
                                     :class="{'is-invalid': item.mortgage_holder_email.$error, 'is-valid': item.mortgage_holder_email.$model && !item.mortgage_holder_email.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_email'">Email банка</label>
                                    <input :disabled="disabled" :id="item.index.$model + '_mortgage_holder_email'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_email.$model"
                                           @input="delayTouch(item.mortgage_holder_email)">
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="mb-20 form--item"
                                     :class="{'is-invalid': item.mortgage_holder_address.$error, 'is-valid': !item.mortgage_holder_address.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_address'">Адрес банка*</label>
                                    <input :disabled="disabled" :id="item.index.$model + '_mortgage_holder_address'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_address.$model"
                                           @input="delayTouch(item.mortgage_holder_address)">
                                </div>
                            </div>

                            <div class="col-4">

                                <div class="mb-20 form--item"
                                     :class="{'is-invalid': item.additional_collateral_cost.$error, 'is-valid': item.additional_collateral_cost.$model && !item.additional_collateral_cost.$invalid}">
                                    <label :for="item.index.$model + '_additional_collateral_cost'">Стоимость
                                        дополнительного залога</label>
                                    <input :disabled="disabled" :id="item.index.$model + '_additional_collateral_cost'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.additional_collateral_cost.$model"
                                           @input="delayTouch(item.additional_collateral_cost)">
                                </div>
                            </div>
                        </div>


                        <div v-if="item.mortgage_holder_local_bank.$model == 0" class="mb-40">
                            <hr>

                            <p class="mb-20 font-500" v-if="!disabled">
                                Заполните данные о местном филиале зарубежного банка залогодержателя:</p>
                            <p class="mb-20 font-500" v-if="disabled">
                                Данные о местном филиале зарубежного банка залогодержателя:</p>

                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-20 form--item"
                                         :class="{'disabled--item': disabled, 'is-valid': item.mortgage_holder_representative_bank_name.$model && !item.mortgage_holder_representative_bank_name.$invalid}">
                                        <label for="mortgage_holder_representative_bank_name">Наименование банка</label>
                                        <input :disabled="disabled" id="mortgage_holder_representative_bank_name"
                                               autocomplete="off"
                                               type="text"
                                               v-model.trim="item.mortgage_holder_representative_bank_name.$model"
                                               @input="delayTouch(item.mortgage_holder_representative_bank_name)">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="mb-20 form--item"
                                         :class="{'disabled--item': disabled, 'is-valid': item.mortgage_holder_representative_bank_number.$model && !item.mortgage_holder_representative_bank_number.$invalid}">
                                        <label for="mortgage_holder_representative_bank_number">Номер банка</label>
                                        <input :disabled="disabled" id="mortgage_holder_representative_bank_number"
                                               autocomplete="off"
                                               type="text"
                                               v-model.trim="item.mortgage_holder_representative_bank_number.$model"
                                               @input="delayTouch(item.mortgage_holder_representative_bank_number)">
                                    </div>
                                </div>

                                <div class="col-4"></div>

                                <div class="col-4">
                                    <div class="mb-20 form--item"
                                         :class="{'is-invalid': item.mortgage_holder_representative_bank_email.$error, 'is-valid': item.mortgage_holder_representative_bank_email.$model && !item.mortgage_holder_representative_bank_email.$invalid}">
                                        <label for="mortgage_holder_representative_bank_email">Email банка</label>
                                        <input :disabled="disabled" id="mortgage_holder_representative_bank_email"
                                               autocomplete="off"
                                               type="text"
                                               v-model.trim="item.mortgage_holder_representative_bank_email.$model"
                                               @input="delayTouch(item.mortgage_holder_representative_bank_email)">
                                    </div>
                                </div>

                                <div class="col-8">
                                    <div class="mb-20 form--item"
                                         :class="{'disabled--item': disabled, 'is-valid': item.mortgage_holder_representative_bank_address.$model && !item.mortgage_holder_representative_bank_address.$invalid}">
                                        <label for="mortgage_holder_representative_bank_address">Адрес банка</label>
                                        <input :disabled="disabled" id="mortgage_holder_representative_bank_address"
                                               autocomplete="off"
                                               type="text"
                                               v-model.trim="item.mortgage_holder_representative_bank_address.$model"
                                               @input="delayTouch(item.mortgage_holder_representative_bank_address)">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <p class="mb-20 font-500" v-if="!disabled">
                            <span v-if="item.mortgage_holder_local_bank.$model == 1">Заполните данные о представителе местного банка залогодержателя:</span>
                            <span v-if="item.mortgage_holder_local_bank.$model == 0">Заполните данные о представителе местного филиала зарубежного банка залогодержателя:</span>
                        </p>
                        <p class="mb-20 font-500" v-if="disabled">
                            Данные о представителе местного банка залогодержателя:
                        </p>

                        <div class="row">
                            <div class="col-4">
                                <div class="mb-20 form--item"
                                     :class="{'disabled--item': disabled, 'is-valid': item.mortgage_holder_representative_name.$model && !item.mortgage_holder_representative_name.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_representative_name'">Имя</label>
                                    <input :disabled="disabled"
                                           :id="item.index.$model + '_mortgage_holder_representative_name'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_representative_name.$model"
                                           @input="delayTouch(item.mortgage_holder_representative_name)">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="mb-20 form--item"
                                     :class="{'disabled--item': disabled, 'is-valid': item.mortgage_holder_representative_surname.$model && !item.mortgage_holder_representative_surname.$invalid}">
                                    <label
                                        :for="item.index.$model + '_mortgage_holder_representative_surname'">Фамилия</label>
                                    <input :disabled="disabled"
                                           :id="item.index.$model + '_mortgage_holder_representative_surname'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_representative_surname.$model"
                                           @input="delayTouch(item.mortgage_holder_representative_surname)">
                                </div>
                            </div>

                            <div class="col-4" v-if="!disabled">
                                <div class="mb-20 form--item"
                                     :class="{'disabled--item': disabled, 'is-valid': item.mortgage_holder_representative_code.$model && !item.mortgage_holder_representative_code.$invalid}">
                                    <label :for="item.index.$model + '_mortgage_holder_representative_code'">Личный
                                        код</label>
                                    <input :disabled="disabled"
                                           :id="item.index.$model + '_mortgage_holder_representative_code'"
                                           autocomplete="off"
                                           type="text"
                                           v-model.trim="item.mortgage_holder_representative_code.$model"
                                           @input="delayTouch(item.mortgage_holder_representative_code)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="d-block d-md-none">
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

        <div class="mobile-footer-btn-container" v-if="!disabled">
            <button class="btn-small btn-v1 w-100" @click="saveData()">
                <span v-if="edit_page">Сохранить изменения</span>
                <span v-if="!edit_page">Сохранить</span>
            </button>
        </div>

    </div>
</template>


<script>
    import {emailRuleNoReq, requiredRule, onlyNumRuleNoReq, noValid, personalNumberRuleNoReq} from '../../../services/validation';

    const touchMap = new WeakMap();

    import RequestsServices from '../../../services/requests';

    export default {
        props: ['user_id', 'disabled', 'user_role', 'user_approved', 'show_for_notary'],
        data() {
            return {
                deal: null,

                postData: {
                    bank_name: null,
                    bank_number: null,
                    branch_code: null,
                    client_account_number: null,
                    bank_address: null,
                    bank_email: null,

                    mortgage_amount: null,
                    days_to_conclude_insurance_after_signing: null,
                    insurance_penalty: null,

                    bank_representative_name: null,
                    bank_representative_surname: null,
                    bank_representative_personal_code: null,

                    foreign_bank_name: null,
                    foreign_bank_number: null,
                    foreign_bank_code: null,
                    foreign_bank_address: null,
                    foreign_bank_email: null
                },

                mortgageData: [],
                holders: null,

                local_bank: 1,
                the_pledge_holder_of_all_objects_is_one_bank: false,
                mortgages_id: [],

                loading: true,
                edit_page: false

            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },

        mounted() {
            this.init();
        },

        watch: {
            the_pledge_holder_of_all_objects_is_one_bank() {
                /*залогодержатель - один банк*/
                if (this.the_pledge_holder_of_all_objects_is_one_bank == true) {
                    this.mortgageData = [];
                    let obj = {};

                    obj.mortgage_holder_local_bank = 1;
                    obj.mortgage_holder_name = null;
                    obj.mortgage_holder_number = null;
                    obj.mortgage_holder_code = null;
                    obj.mortgage_holder_email = null;
                    obj.mortgage_holder_address = null;

                    obj.additional_collateral_cost = null;

                    obj.mortgage_holder_representative_name = null;
                    obj.mortgage_holder_representative_surname = null;
                    obj.mortgage_holder_representative_code = null;
                    obj.mortgage_holder_representative_bank_name = null;
                    obj.mortgage_holder_representative_bank_number = null;
                    obj.mortgage_holder_representative_bank_email = null;
                    obj.mortgage_holder_representative_bank_address = null;

                    obj.index = 1;
                    this.mortgageData.push(obj);

                    this.getMortgagesId();
                } else {
                    this.getMortgageItems();
                    this.mortgages_id = [];
                }
            }
        },

        methods: {
            init() {
                this.holders = [];
                RequestsServices.deal(this.$route.params.id, this.user_id).then(response => {
                    this.deal = response;

                    if (this.deal && this.deal.client_data) {
                        let client_data = this.deal.client_data;
                        let data;


                        client_data.forEach(item => {
                            if (item.client_user_id == this.user_id) data = item;
                        });

                        if (data) {
                            this.postData.bank_name = data.bank_name;
                            this.postData.bank_number = data.bank_number;
                            this.postData.branch_code = data.branch_code;
                            this.postData.client_account_number = data.client_account_number;
                            this.postData.bank_address = data.bank_address;
                            this.postData.bank_email = data.bank_email;

                            this.postData.mortgage_amount = data.mortgage_amount;
                            this.postData.days_to_conclude_insurance_after_signing = data.days_to_conclude_insurance_after_signing;
                            this.postData.insurance_penalty = data.insurance_penalty;

                            this.postData.bank_representative_name = data.bank_representative_name;
                            this.postData.bank_representative_surname = data.bank_representative_surname;
                            this.postData.bank_representative_personal_code = data.bank_representative_personal_code;

                            this.postData.foreign_bank_name = data.foreign_bank_name;
                            this.postData.foreign_bank_number = data.foreign_bank_number;
                            this.postData.foreign_bank_code = data.foreign_bank_code;
                            this.postData.foreign_bank_address = data.foreign_bank_address;
                            this.postData.foreign_bank_email = data.foreign_bank_email;

                            if (data.local_bank == 1) this.local_bank = 1;
                            if (data.local_bank == 0) this.local_bank = 0;

                            this.edit_page = true
                        }
                    }

                    /* залогодержатели */
                    this.getMortgageItems();

                    this.loading = false;
                });


            },

            getMortgageItems() {
                this.mortgageData = [];
                let mortgage_data = this.deal.mortgages;
                let index = 1;
                mortgage_data.forEach(item => {
                    if (this.user_id == item.user_id) {

                        if (!item.holder_data) {
                            let obj = {};

                            obj.mortgage_holder_local_bank = 1;
                            obj.mortgage_holder_name = null;
                            obj.mortgage_holder_number = null;
                            obj.mortgage_holder_code = null;
                            obj.mortgage_holder_email = null;
                            obj.mortgage_holder_address = null;

                            obj.additional_collateral_cost = null;

                            obj.mortgage_holder_representative_name = null;
                            obj.mortgage_holder_representative_surname = null;
                            obj.mortgage_holder_representative_code = null;
                            obj.mortgage_holder_representative_bank_name = null;
                            obj.mortgage_holder_representative_bank_number = null;
                            obj.mortgage_holder_representative_bank_email = null;
                            obj.mortgage_holder_representative_bank_address = null;

                            /*to initialize mortgage*/
                            obj.mortgage_id = item.id;
                            if (item.type == 1) obj.mortgage_type = "Квартира";
                            if (item.type == 2) obj.mortgage_type = "Многоквартирный дом";
                            if (item.type == 3) obj.mortgage_type = "Дом";
                            if (item.type == 4) obj.mortgage_type = "Дача";
                            if (item.type == 5) obj.mortgage_type = "Производственное помещение";
                            obj.mortgage_address = item.address + ', ' + item.city + ', ' + item.country;

                            obj.index = index;
                            this.mortgageData.push(obj);

                            index++;
                        }

                        if (item.holder_data) {
                            let holder = JSON.parse(item.holder_data);
                            let current_holder = holder[0];
                            if (!current_holder.mortgage_id) {
                                this.getMortgagesId();
                                this.holders[0] = current_holder;
                            }
                            if (current_holder.mortgage_id) this.holders.push(current_holder);
                        }

                    }
                })
            },

            getMortgagesId() {
                let mortgage_data = this.deal.mortgages;
                mortgage_data.forEach(item => {
                    if (this.user_id == item.user_id) {
                        let mortgages_id = {id: item.id};
                        this.mortgages_id.push(mortgages_id);
                    }
                })
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
                    let formData = new FormData();
                    for (let key in this.postData) {
                        if (this.postData[key]) formData.append(key, this.postData[key]);
                    }

                    if (this.local_bank == 1) formData.append('local_bank', 1);
                    else formData.append('local_bank', 0);

                    if (this.the_pledge_holder_of_all_objects_is_one_bank) formData.append('the_pledge_holder_of_all_objects_is_one_bank', 1);
                    else formData.append('the_pledge_holder_of_all_objects_is_one_bank', 0);

                    let url = '/api/deal/' + this.$route.params.id + '/client_data';
                    const options = {
                        headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                    };

                    axios.post(url, formData, options)
                        .then(response => {
                            if (response.status == 200) {
                                if (this.mortgageData && this.mortgageData.length > 0) this.saveHolderData();
                                else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Готово',
                                        html: 'Данные успешно сохранены.',
                                    })
                                    this.init();
                                }

                            }
                        })
                        .finally(() => {
                            this.loading = false;
                        })
                }
            },

            saveHolderData() {
                if (this.the_pledge_holder_of_all_objects_is_one_bank) {
                    this.mortgages_id.forEach(item => {
                        this.postHolderData(this.mortgageData[0], item.id);
                    })
                } else {
                    this.mortgageData.forEach(item => {
                        this.postHolderData(item, item.mortgage_id);
                    })
                }


            },

            postHolderData(item, mortgage_id) {
                let formData = new FormData();
                for (let key in item) {
                    if (item[key]) formData.append(key, item[key]);
                }

                if (item.mortgage_holder_local_bank == 1) formData.append('mortgage_holder_local_bank', 1);
                else formData.append('mortgage_holder_local_bank', 0);


                let url = '/api/deal/' + this.$route.params.id + '/mortgage/' + mortgage_id + '/holder_data';

                const options = {
                    headers: {Authorization: "Bearer " + localStorage.getItem('token')}
                };

                axios.post(url, formData, options)
                    .then(response => {
                        if (response.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Готово',
                                html: 'Данные успешно сохранены.',
                            }).then(() => {
                                this.$router.go();
                            })

                        }
                    })
                    .finally(() => {
                        this.loading = false;
                        //this.mortgageData = [];
                    })
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
            if (this.mortgageData && this.mortgageData.length > 0) {
                return {
                    postData: {
                        bank_address: requiredRule,
                        bank_name: requiredRule,
                        bank_number: requiredRule,
                        branch_code: requiredRule,
                        client_account_number: requiredRule,

                        bank_representative_personal_code: personalNumberRuleNoReq,
                        mortgage_holder_email: emailRuleNoReq,
                        bank_email: emailRuleNoReq,
                        foreign_bank_email: emailRuleNoReq,

                        mortgage_amount: onlyNumRuleNoReq,
                        days_to_conclude_insurance_after_signing: onlyNumRuleNoReq,
                        insurance_penalty: onlyNumRuleNoReq,
                    },

                    mortgageData: {
                        $each: {
                            index: requiredRule,
                            mortgage_holder_local_bank: requiredRule,
                            mortgage_holder_name: requiredRule,
                            mortgage_holder_number: requiredRule,
                            mortgage_holder_address: requiredRule,

                            mortgage_holder_code: onlyNumRuleNoReq,
                            mortgage_holder_email: emailRuleNoReq,

                            additional_collateral_cost: onlyNumRuleNoReq,

                            mortgage_holder_representative_name: noValid,
                            mortgage_holder_representative_surname: noValid,
                            mortgage_holder_representative_code: noValid,
                            mortgage_holder_representative_bank_name: noValid,
                            mortgage_holder_representative_bank_number: noValid,
                            mortgage_holder_representative_bank_email: emailRuleNoReq,
                            mortgage_holder_representative_bank_address: noValid,

                            mortgage_id: noValid,
                            mortgage_type: noValid,
                            mortgage_address: noValid,
                        }
                    }
                }
            } else {
                return {
                    postData: {
                        bank_address: requiredRule,
                        bank_name: requiredRule,
                        bank_number: requiredRule,
                        branch_code: requiredRule,
                        client_account_number: requiredRule,

                        bank_representative_personal_code: personalNumberRuleNoReq,

                        mortgage_holder_email: emailRuleNoReq,
                        bank_email: emailRuleNoReq,
                        foreign_bank_email: emailRuleNoReq,

                        mortgage_amount: onlyNumRuleNoReq,
                        days_to_conclude_insurance_after_signing: onlyNumRuleNoReq,
                        insurance_penalty: onlyNumRuleNoReq
                    }
                }
            }

        }
    }
</script>
