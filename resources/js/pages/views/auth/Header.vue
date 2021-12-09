<template>
    <div class="auth--header">
        <div class="auth--page">
            <div class="logo--box">
                <router-link to="/">
                    <img src="/svg/logo.svg" alt="Сервис дигитализации  покупки и продажи недвижимости">
                </router-link>
            </div>
            <div class="content-container d-none d-lg-flex justify-content-between align-items-center">
                <lang-select></lang-select>

                <div class="d-flex align-items-center">
                    <a href="tel:+375292325475" class="font-500 mr-40 color-text-dark">+375 29 232-54-75</a>
                    <router-link to="/support" class="btn-small btn-v2">
                        Есть вопрос?
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
