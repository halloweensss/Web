<template>
    <img class="post-body-content-center" :src="userInfo.imageUrl">
</template>

<script>
    export default {
        name: "SingleContent",
        props:{
            userInfo:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>
    .post-body-content-center{
        width: 100%;
        justify-content: center;
        align-items: center;
    }
</style>