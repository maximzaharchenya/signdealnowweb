<template>
    <div class="w-100 d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div>
            <h1 class="mb-4">Welcome to SignDealNow</h1>
            <h5 class="mb-4 text-center">you will be redirected to the registration page</h5>

        </div>
    </div>
</template>

<script>
export default {
    created() {
        setTimeout(() => {
            this.$router.push('/register')
        }, 1000)
    }
}
</script>

