<template>
    <a class="service-img instagram" :href="profileUrl">
        <i class="fab fa-instagram"></i>
    </a>
</template>

<script>
    export default {
        name: "InstagramFollowCard",
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

    .service-img.instagram:hover,
    .service-img.instagram:focus{
        color: #F32159;
        opacity: .6;
    }

    .follow-card:hover .service-img.instagram{
        color: #F32159;
        opacity: .6;
    }
</style>