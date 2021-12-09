<template>
    <div class="card--common account-content">
        <div class="card--common__header">
            <h3 class="mb-0">Помощь</h3>
        </div>

        <div class="card--common__body">
            <p class="mb-0">Опишите детали Вашего вопроса здесь.</p>
            <p class="mb-40">Администратор сервиса свяжется с Вами в ближайшее время.</p>

            <div class="row no-gutters">
                <div class="col-sm-8">
                    <support-form v-if="user" :data="user"></support-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },

        computed: {
            user() {
                return this.$store.getters.getUser;
            }
        },
    }
</script>
