<template>
    <InstagramFooter v-if="userInfo.serviceName=='instagram'" v-bind:user-info="userInfo"/>
    <TelegramFooter v-else-if="userInfo.serviceName=='telegram'" v-bind:user-info="userInfo"/>
</template>

<script>
    import InstagramFooter from "./InstagramFooter";
    import TelegramFooter from "./TelegramFooter";
    export default {
        name: "PostFooter",
        components: {TelegramFooter, InstagramFooter},
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