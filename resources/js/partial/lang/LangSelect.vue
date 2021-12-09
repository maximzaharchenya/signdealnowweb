<template>
    <div class="lang--select">
        <multiselect
            v-model="select_lang"
            :options="options"
            :allow-empty="false"
            :searchable="false"
            deselect-label=""
            selected-label=""
            select-label=""
            label="title"
            track-by="title"
        >
        </multiselect>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
        data () {
            return {
                select_lang: {value: 1, title: 'RU'},
                options: [
                    {value: 1, title: 'RU'},
                    {value: 2, title: 'ET'},
                    {value: 3, title: 'EN'},
                ]
            }
        }
    }
</script>
