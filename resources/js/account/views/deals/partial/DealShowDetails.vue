<template>
    <div>
        <!--  Статус сделки 1|2 - 'ЗАПРОС ОТПРАВЛЕН и ФОРМИРОВАНИЕ ДОГОВОРА' -->
        <div class="card--common h-auto" v-if="deal.status == 1 || deal.status == 2">
            <div class="card--common__header">
                <h3 class="mb-0">Договорной процесс</h3>

                <div class="d-none d-sm-block">
                    <button class="btn-small btn-v2" v-if="deal.status == 1" disabled>Заполнить поля</button>
                    <router-link :to="'/account/deals/' + deal.id + '/create-data'" class="btn-small btn-v1" v-else>
                        Заполнить поля
                    </router-link>
                </div>

            </div>

            <div class="card--common__body">
                <!--  IF DEAL HAS STATUS - 1 -->
                <p class="mb-0 color-text-grey" v-if="deal.status == 1">
                    Здесь вы будете отслеживать ход формирования и регулирования сделки.
                    Для начала вам необходимо подождать одобрения приглашения и только после этого перейти на
                    страницу заполнения всех полей, касательно сделки.
                    После того, как все участники сделки одобрять всю информацию договорного процесса, вы сможете
                    приступить к нотариальному.
                </p>


                <!--  IF DEAL HAS STATUS - 2 -->
                <div v-if="deal.status == 2">
                    <div class="mb-30 d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 font-500">Подтверждение статуса процесса</h5>
                    </div>

                    <div v-for="item in statuses">
                        <div v-if="item.user_role == 1">
                            <p class="mb-1 color-text-light">Продавец</p>
                            <div class="d-flex align-items-end align-items-sm-center justify-content-between">
                                <p class="mb-0 mr-2 mr-sm-0">{{item.name}} {{item.surname}}</p>
                                <div class="d-sm-flex align-items-center">
                                    <div class="d-flex align-items-center mr-sm-5 mb-1 mb-sm-0">
                                        <img src="/svg/check-ok.svg" alt="" class="mr-2" v-if="item.approved == 1">
                                        <img src="/svg/check-null.svg" alt="" class="mr-2" v-else>

                                        <span v-if="item.approved == 1">Одобрено</span>
                                        <span v-else class="color-text-grey">Не одобрено</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="/svg/check-ok.svg" alt="" class="mr-2" v-if="item.fullness">
                                        <img src="/svg/check-null.svg" alt="" class="mr-2" v-else>

                                        <span v-if="item.fullness">Заполнено</span>
                                        <span class="color-text-grey" v-else>Заполняется</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-3 mb-3">
                        </div>

                        <div v-if="item.user_role == 2">
                            <p class="mb-1 color-text-light">Покупатели</p>

                            <div class="d-flex align-items-end align-items-sm-center justify-content-between">
                                <p class="mb-0 mr-2 mr-sm-0">{{item.name}} {{item.surname}}</p>
                                <div class="d-sm-flex align-items-center">
                                    <div class="d-flex align-items-center mr-sm-5 mb-1 mb-sm-0">
                                        <img src="/svg/check-ok.svg" alt="" class="mr-2" v-if="item.approved == 1">
                                        <img src="/svg/check-null.svg" alt="" class="mr-2" v-else>

                                        <span v-if="item.approved == 1">Одобрено</span>
                                        <span v-else class="color-text-grey">Не одобрено</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img src="/svg/check-ok.svg" alt="" class="mr-2" v-if="item.fullness">
                                        <img src="/svg/check-null.svg" alt="" class="mr-2" v-else>

                                        <span v-if="item.fullness">Заполнено</span>
                                        <span class="color-text-grey" v-else>Заполняется</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-block d-sm-none pt-5">
                    <button class="btn-small btn-v2 w-100 text-center" v-if="deal.status == 1" disabled>Заполнить поля
                    </button>
                    <router-link :to="'/account/deals/' + deal.id + '/create-data'"
                                 class="btn-small btn-v1 w-100 text-center" v-else>
                        Заполнить поля
                    </router-link>
                </div>
            </div>

        </div>

        <!--  Статус сделки 3 - 'ПРИГЛАШЕНИЕ НОТАРИУСА' -->
        <div class="card--common h-auto" v-if="deal.status == 3">
            <div class="card--common__header">
                <h3 class="mb-0">Нотариальный процесс</h3>

                <div class="d-none d-sm-block">
                    <router-link v-if="user_role == 1 || user_role == 2 || user_role == 8"
                                 :to="'/account/deals/' + deal.id + '/invite-notary'" class="btn-small btn-v1">
                        Пригласить нотариуса
                    </router-link>
                    <button v-else class="btn-small btn-v1" disabled="">Пригласить нотариуса</button>
                </div>

            </div>
            <div class="card--common__body">
                <p class="mb-0 color-text-grey">
                    Для начала нотариального процесса вам необходимо пригласить нотариуса в сделку.
                </p>

                <div class="d-block d-sm-none pt-4">
                    <router-link v-if="user_role == 1 || user_role == 2 || user_role == 8"
                                 :to="'/account/deals/' + deal.id + '/invite-notary'"
                                 class="btn-small btn-v1 w-100 text-center">Пригласить нотариуса
                    </router-link>
                    <button v-else class="btn-small btn-v1 w-100 text-center" disabled="">Пригласить нотариуса</button>
                </div>
            </div>
        </div>

        <!--  Статус сделки 4 - 'Ожидание нотариуса' -->
        <div class="card--common h-auto" v-if="deal.status == 4 || deal.status == 12">
            <div class="card--common__header">
                <h3 class="mb-0">Нотариальный процесс</h3>
                <router-link v-if="deal.status == 12" :to="'/account/deals/' + deal.id + '/invite-notary'"
                             class="btn-small btn-v1">Пригласить нотариуса
                </router-link>
            </div>
            <div class="card--common__body">
                <p class="mb-40 color-text-grey" v-if="deal.status == 4">
                    Вы пригласили нотариуса в сделку. Ожидайте ответа.
                    Как только нотариус одобрит приглашение, вы перейдете к согласованию даты и времени подписания.
                    Если нотариус отклонит приглашение, вам придет уведомление об отказе, и вам нужно будет выбрать
                    другого натариуса и пригласить его в сделку.
                </p>

                <p class="mb-40 color-text-grey" v-if="deal.status == 12">
                    Нотариус отклонил ваше приглашение в сделку. <br>
                    Вам нужно выбрать другого нотариуса и пригласить его в сделку.

                </p>

                <!--  DESCTOP ITEMS -->
                <div class="d-none d-sm-block">
                    <div class="deals-table notaries-invite-table" v-if="deal.notary">
                        <div class="deals-table__header">
                            <div>Нотариус</div>
                            <div>Нотариальная контора</div>
                            <div class="d-lg-none d-xl-block">Язык</div>
                            <div>Статус</div>
                        </div>

                        <div class="deals-table__item">
                            <div class="d-flex align-items-center">
                                <div class="img-circle-container mr-3">
                                    <img v-if="deal.notary.image" :src="'/storage/' + deal.notary.image" alt="">
                                    <img src="/img/defaults/deal.jpg" alt="">
                                </div>
                                <span> {{deal.notary.name}} {{deal.notary.surname}}</span>
                            </div>
                            <div> {{deal.notary.office_name}}</div>
                            <div class="d-lg-none d-xl-flex flex-wrap">
                                <span v-if="!deal.notary.languages">-</span>

                                <div v-if="deal.notary.languages" v-for="(item, key) in deal.notary.languages"
                                     :key="key">
                                    {{item}}<span v-if="key !== deal.notary.languages.length - 1"
                                                  class="d-inline-block pr-1">, </span>
                                </div>
                            </div>
                            <div>
                                <span>Ожидает одобрения</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  MOBILE ITEMS -->
                <div class="d-block d-sm-none">
                    <div v-if="deal.notary"
                         class="notary__card">
                        <div class="notary__card--header">
                            <div>
                                <div class="font-500">
                                    {{deal.notary.name}} {{deal.notary.surname}}
                                </div>
                                <p class="mb-0 color-text-grey">Нотариус</p>
                            </div>
                            <img v-if="deal.notary.image" :src="'/storage/' + deal.notary.image" alt="">
                            <img v-else src="/img/defaults/user_default.png" alt="">
                        </div>

                        <div class="notary__card--body">
                            <div class="item">
                                <span>{{deal.notary.office_name}}</span>
                            </div>

                            <div class="item">
                                <span class="color-text-light">Сделок в работе:</span>
                                <span>{{deal.notary.deals_in_progress}}</span>
                            </div>

                            <div class="item">
                                <span class="color-text-light">Закрытых сделок:</span>
                                <span>{{deal.notary.closed_deals}}</span>
                            </div>

                            <div class="item">
                                <span class="color-text-light pr-1">Язык:</span>
                                <div v-if="deal.notary.language" class="d-flex flex-wrap">
                                    <div v-for="(lang, key) in deal.notary.language" :key="key">
                                        {{lang}}<span v-if="key !== deal.notary.language.length - 1"
                                                      class="d-inline-block pr-1">, </span>
                                    </div>
                                </div>
                            </div>

                            <div class="item">
                                <span class="color-text-light">Статус:</span>
                                <span>Ожидает одобрения</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--  Статус сделки 5 - 'Согласование времени подписания' -->
        <div class="card--common h-auto" v-if="deal.status == 5 && user_role != 3 && user_role != 8 ">
            <div class="card--common__header">
                <div class="d-flex flex-wrap align-items-end">
                    <h3 class="mb-1 mr-3">Нотариальный процесс</h3>
                    <router-link :to="'/account/deals/' + deal.id + '/payment'"
                                 v-if="(user_role == 1 || user_role == 2) && deal.notary_fees"
                                 class="text-underline nowrap mb-1">
                        Нотариальные сборы
                    </router-link>
                </div>

                <div class="d-sm-block d-none">
                    <button class="btn-small btn-v1" disabled v-if="!deal.sign_info">Согласовать</button>
                    <router-link v-if="deal.sign_info" :to="'/account/deals/' + deal.id + '/data-approval'"
                                 class="btn-small btn-v1">Согласовать
                    </router-link>
                </div>

            </div>
            <div class="card--common__body">
                <p class="mb-40 color-text-grey">
                    Нотариус одобрил ваше приглашение в сделку. Далее вам необходимо согласовать время и дату подписания
                    после того, как нотариус предложит подходящее.
                    При возникновении спортых моментов мы можете созвониться по видеосвязи или предложить подходящее вам
                    другое время в чате.
                </p>

                <div class="row custom-form time__approve__show">
                    <div class="col-6 col-sm-4">
                        <div class="mb-20 form--item disabled--item">
                            <p class="mb-1 color-text-light">Дата подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.date}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4">
                        <div class="mb-20 form--item disabled--item">
                            <p class="mb-1 color-text-light">Время подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.time}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <!--                    <div class="col-4">-->
                    <!--                        <div class="mb-20 form&#45;&#45;item disabled&#45;&#45;item">-->
                    <!--                            <p class="mb-1 color-text-light">Документ</p>-->
                    <!--&lt;!&ndash;                            <a href="#" class="doc_link">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <span class="color-text-dark">Договор купли-продажи</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </a>&ndash;&gt;-->

                    <!--                            <div class="doc_link no_file">-->
                    <!--                                <span class="color-text-light">Не загружено</span>-->
                    <!--                                <img src="/svg/load.svg" alt="">-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>

                <div class="d-block d-sm-none pt-4">
                    <button class="btn-small btn-v1 w-100 text-center" disabled v-if="!deal.sign_info">Согласовать
                    </button>
                    <router-link v-if="deal.sign_info" :to="'/account/deals/' + deal.id + '/data-approval'"
                                 class="btn-small btn-v1 w-100 text-center">Согласовать
                    </router-link>
                </div>
            </div>
        </div>


        <!--  Статус сделки 5 - 'Согласование времени подписания' ДЛЯ НОТАРИУСА -->
        <div class="card--common h-auto" v-if="deal.status == 5 && (user_role == 3 || user_role == 8)">
            <div class="card--common__header">
                <div class="d-flex align-items-end">
                    <h3 class="mb-0 mr-3">Нотариальный процесс</h3>
                </div>

                <div class="d-none d-sm-block">
                    <router-link :to="'/account/deals/' + deal.id + '/data-approval'" class="btn-small btn-v1">
                        Согласовать
                    </router-link>
                </div>

            </div>
            <div class="card--common__body">
                <p class="mb-40 color-text-grey" v-if="user_role == 3">
                    Вы одобрили участие в сделке
                    <span v-if="deal.id < 10">00{{deal.id}}</span>
                    <span v-else-if="deal.id < 100 && deal.id > 9">0{{deal.id}}</span>
                    <span v-else>00{{deal.id}}</span>. <br>
                    Для начала вам необходимо предложить дату и время подписания, а затем начать работу с формированием
                    договора.
                    На этой вкладке вы будете видеть согласованное время и дату, и загруженный вами договор.
                </p>

                <p v-if="user_role == 8" class="color-text-grey">
                    Нотариус одобрил участие в сделке. <br>
                    Для начала вам необходимо предложить дату и время подписания, а затем начать работу с формированием
                    договора.
                    На этой вкладке вы будете видеть согласованное время и дату, и загруженный вами договор.
                </p>

                <div class="row custom-form time__approve__show">
                    <div class="col-6 col-xl-4">
                        <div class="mb-20">
                            <p class="mb-1 color-text-light">Дата подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.date}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <div class="col-6 col-xl-4">
                        <div class="mb-20 form--item disabled--item">
                            <p class="mb-1 color-text-light">Время подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.time}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <!--                    <div class="col-4">-->
                    <!--                        <div class="mb-20 form&#45;&#45;item image-loader">-->
                    <!--&lt;!&ndash;                            <p class="mb-1 color-text-light">Документ</p>&ndash;&gt;-->

                    <!--                            &lt;!&ndash;                            <a href="#" class="doc_link">&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                                <span class="color-text-dark">Договор купли-продажи</span>&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                            </a>&ndash;&gt;-->

                    <!--&lt;!&ndash;                            <div class="doc_link no_file">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <span class="color-text-light">Не загружено</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </div>&ndash;&gt;-->


                    <!--                            <label class="color-text-light">Документ</label>-->
                    <!--                            <b-form-file-->
                    <!--                                placeholder="Не загружено"-->
                    <!--                                drop-placeholder="Перетащите файл сюда"-->
                    <!--                            ></b-form-file>-->

                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>

                <div class="d-block d-sm-none pt-4">
                    <router-link :to="'/account/deals/' + deal.id + '/data-approval'"
                                 class="btn-small btn-v1 w-100 text-center">Согласовать
                    </router-link>
                </div>
            </div>
        </div>

        <!--  Статус сделки 6 - 'СОЖИДАНИЕ ПОДПИСАНИЯ'-->
        <div class="card--common h-auto" v-if="deal.status == 6">
            <div class="card--common__header">
                <div class="d-flex align-items-end">
                    <h3 class="mb-0 mr-3">Ожидание подписания</h3>
                </div>

                <div class="d-none d-sm-block">
                    <router-link v-if="user_role == 3 || user_role == 8"
                                 :to="'/account/deals/' + deal.id + '/data-approval'" class="btn-small btn-v1">Детали
                        процесса
                    </router-link>
                    <router-link v-else :to="'/account/deals/' + deal.id + '/payment'" class="btn-small btn-v1">
                        Нотариальные сборы
                    </router-link>
                </div>

            </div>
            <div class="card--common__body">

                <p v-if="user_role == 3" class="color-text-grey mb-40">
                    В назначенную дату и время вам необходимо будет прсутствовать на подписании сделки, убедитесь, что у
                    вас будет устойчивое интернет соединение и ничто не будет вас отвлекать.
                </p>
                <p v-else class="color-text-grey mb-40">
                    В назначенную дату и время вам необходимо будет прсутствовать на подписании сделки вместе с
                    нотариусом, убедитесь, что у вас будет устойчивое интернет соединение и ничто не будет вас
                    отвлекать.
                </p>

                <div class="row custom-form time__approve__show">
                    <div class="col-6 col-xl-4">
                        <div class="mb-20">
                            <p class="mb-1 color-text-light">Дата подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.date}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <div class="col-6 col-xl-4">
                        <div class="mb-20 form--item disabled--item">
                            <p class="mb-1 color-text-light">Время подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.time}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <!--                    <div class="col-4">-->
                    <!--                        <div class="mb-20 form&#45;&#45;item image-loader">-->
                    <!--&lt;!&ndash;                            <p class="mb-1 color-text-light">Документ</p>&ndash;&gt;-->

                    <!--                            &lt;!&ndash;                            <a href="#" class="doc_link">&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                                <span class="color-text-dark">Договор купли-продажи</span>&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                            </a>&ndash;&gt;-->

                    <!--&lt;!&ndash;                            <div class="doc_link no_file">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <span class="color-text-light">Не загружено</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </div>&ndash;&gt;-->


                    <!--                            <label class="color-text-light">Документ</label>-->
                    <!--                            <b-form-file-->
                    <!--                                placeholder="Не загружено"-->
                    <!--                                drop-placeholder="Перетащите файл сюда"-->
                    <!--                            ></b-form-file>-->

                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>

                <div class="d-sm-none d-block pt-4">
                    <router-link v-if="user_role == 3 || user_role == 8"
                                 :to="'/account/deals/' + deal.id + '/data-approval'"
                                 class="btn-small btn-v1 w-100 text-center">Детали процесса
                    </router-link>
                    <router-link v-else :to="'/account/deals/' + deal.id + '/payment'"
                                 class="btn-small btn-v1 w-100 text-center">Нотариальные сборы
                    </router-link>
                </div>
            </div>
        </div>


        <!--  Статус сделки 7 - 'ПОДПИСАНИЕ ДОГОВОРА'-->
        <div class="card--common h-auto" v-if="deal.status == 7">
            <div class="card--common__header">
                <h3 class="mb-0 mr-3">Подписание договора</h3>

                <div class="d-none d-sm-block">
                    <router-link :to="'/account/deals/' + deal.id + '/signing'" class="btn-small btn-v1">
                        Присоединиться
                    </router-link>
                </div>

            </div>
            <div class="card--common__body">

                <p class="mb-40 color-text-grey">
                    Подписание началось - зайдите в видеокабинет (видеоконференцию) для окончательного этапа сделки.
                </p>

                <div class="row custom-form time__approve__show">
                    <div class="col-6 col-sm-4">
                        <div class="mb-20">
                            <p class="mb-1 color-text-light">Дата подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.date}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4">
                        <div class="mb-20 form--item disabled--item">
                            <p class="mb-1 color-text-light">Время подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.time}}</p>
                            <p v-else class="mb-0">Еще не назначено</p>
                        </div>
                    </div>

                    <!--                    <div class="col-4">-->
                    <!--                        <div class="mb-20 form&#45;&#45;item image-loader">-->
                    <!--&lt;!&ndash;                            <p class="mb-1 color-text-light">Документ</p>&ndash;&gt;-->

                    <!--                            &lt;!&ndash;                            <a href="#" class="doc_link">&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                                <span class="color-text-dark">Договор купли-продажи</span>&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--                            &lt;!&ndash;                            </a>&ndash;&gt;-->

                    <!--&lt;!&ndash;                            <div class="doc_link no_file">&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <span class="color-text-light">Не загружено</span>&ndash;&gt;-->
                    <!--&lt;!&ndash;                                <img src="/svg/load.svg" alt="">&ndash;&gt;-->
                    <!--&lt;!&ndash;                            </div>&ndash;&gt;-->


                    <!--                            <label class="color-text-light">Документ</label>-->
                    <!--                            <b-form-file-->
                    <!--                                placeholder="Не загружено"-->
                    <!--                                drop-placeholder="Перетащите файл сюда"-->
                    <!--                            ></b-form-file>-->

                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>

                <div class="d-sm-none d-block">
                    <router-link :to="'/account/deals/' + deal.id + '/signing'"
                                 class="btn-small btn-v1 w-100 text-center">Присоединиться
                    </router-link>
                </div>
            </div>
        </div>


        <!--  Статус сделки 9 - 'НЕ АКТИВНА' -->
        <div class="card--common h-auto" v-if="deal.status == 9">
            <div class="card--common__header">
                <h3 class="mb-0">Внимание</h3>
            </div>
            <div class="card--common__body">
                <p class="mb-0 color-text-grey">
                    Ваша сделка перешла в статус «не активна», так как другой покупатель заброниовал данный объект и
                    подписал прелиминарный контракт.
                    Если в ближайшее время другим покупателем не будет подписан договор купли продажи, статус сделки
                    вновь перейдет на «формирование договора»,
                    и вы сможете продолжить оформление.
                </p>
            </div>
        </div>


        <!--  Статус сделки 11 - 'ЗАКРЫТА' -->
        <div class="card--common h-auto" v-if="deal.status == 11">
            <div class="card--common__header">
                <h3 class="mb-0">Итоги сделки</h3>
            </div>
            <div class="card--common__body">
                <div class="row custom-form time__approve__show">
                    <div class="col-6 col-lg-4">
                        <div class="mb-20">
                            <p class="mb-1 color-text-light">Дата подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.date}}</p>
                        </div>
                    </div>

                    <div class="col-6 col-lg-4">
                        <div class="mb-20 form--item disabled--item">
                            <p class="mb-1 color-text-light">Время подписи</p>
                            <p v-if="deal.sign_info">{{deal.sign_info.time}}</p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-20 form--item image-loader">
                            <p class="mb-1 color-text-light">Документ</p>

                            <a :href="'/storage/documents/' + deal.document_file" target="_blank" class="doc_link"
                               v-if="deal.document_file">
                                <span class="color-text-dark">Договор купли-продажи</span>
                                <img src="/svg/load.svg" alt="">
                            </a>

                            <div class="doc_link no_file" v-else>
                                <span class="color-text-light">Не загружено</span>
                                <img src="/svg/load.svg" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import Button from "../../../../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Button";

    export default {
        components: {Button},
        props: ['deal', 'statuses', 'user_role'],
        data() {
            return {}
        }
    }
</script>
