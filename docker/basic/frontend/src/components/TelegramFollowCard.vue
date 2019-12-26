<template>
    <a class="service-img telegram" :href="profileUrl">
        <i class="fab fa-telegram-plane"></i>
    </a>
</template>

<script>
    export default {
        name: "TelegramFollowCard",
        props:{
            profileUrl: {
                type:String,
                required: true
            }
        }
    }
</script>

<style scoped>
    .service-img{
        color: #000000;
        font-size: 32px;
        width: 32px;
        opacity: .3;
    }

    .service-img.telegram:hover,
    .service-img.telegram:focus{
        color: #2168F3;
        opacity: .6;
    }

    .follow-card:hover .service-img.telegram{
        color: #2168F3;
        opacity: .6;
    }
</style>