<template>
    <InstagramHeader v-if="userInfo.serviceName=='instagram'" v-bind:user-info="userInfo"/>
    <TelegramHeader v-else-if="userInfo.serviceName=='telegram'" v-bind:user-info="userInfo"/>
</template>

<script>
    import InstagramHeader from "./InstagramHeader";
    import TelegramHeader from "./TelegramHeader";
    export default {
        name: "PostHeader",
        components: {TelegramHeader, InstagramHeader},
        props:{
            userInfo:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>