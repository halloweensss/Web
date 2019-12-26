<template>
    <div class="margin-button">
        <button class="btn btn-danger follow-button" type="button">Отписаться</button>
        <button class="btn btn-danger follow-button min" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
</template>

<script>
    export default {
        name: "UnfollowButton",
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