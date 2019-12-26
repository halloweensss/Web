<template>
    <div class="margin-button">
        <button class="btn btn-primary follow-button" type="button">Подписаться</button>
        <button class="btn btn-primary follow-button min" type="button"><i class="fas fa-check"></i></button>
    </div>
</template>

<script>
    export default {
        name: "FollowButton",
        props:{
            followUser:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>
    .margin-button{
        margin:auto 0 auto auto;
    }

    .follow-button{
        margin: auto 0 auto auto;
        border-radius: 7px;
        height: 36px;
        padding: 2px 8px;
    }

    .follow-button.min{
        padding: 5px 10px;
        display: none;
    }

    @media only screen and (max-width : 300px) {
        .follow-button {
            display: none;
        }
        .follow-button.min {
            display: flex;
        }
    }
</style>