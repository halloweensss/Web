<template>
    <div class="post-footer">
        <div class="post-footer-content">
            <a class="d-flex post-footer-action">
                <i class="far fa-eye post-footer-icon"></i>
                <p class="post-footer-text">{{userInfo.postViews}}</p>
            </a>
        </div>
        <div class="ml-auto post-footer-date">
            <p>{{userInfo.postDate}}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TelegramFooter",
        props:{
            userInfo:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

    html{
        font-size: 16px;
    }

    hr{
        margin-top: 0px;
        color: #000000;
    }

    .post-footer{
        display: flex;
        flex-direction: row;
        padding-left: 15px;
        padding-right: 15px;
    }

    .post-footer-content{
        display: flex;
        flex-direction: row;
        font-size: 24px;
        opacity: .5;
    }

    .post-footer-date{
        vertical-align: center;
        font-size: 10px;
        display: flex;
        flex-direction: row;
        opacity: .5;
    }
    .post-footer-icon{
        font-size: 20px;
        margin-right: 5px;
    }

    .post-footer-action{
        color:#000000;
        text-decoration: none;
        padding-right: 10px;
    }

    .post-footer-action:hover,
    .post-footer-action:focus{
        text-decoration: none;
        color: #F86C6C;
    }

    .post-footer-text{
        font-size: 12px;
    }

    body{
        width: 100vw;
        height: 100vh;
        background-color: #EDF0FA;
        font-family: 'Roboto', sans-serif;
    }

    main{
        padding-top: 80px;
    }
</style>