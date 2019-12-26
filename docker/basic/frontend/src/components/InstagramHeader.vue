<template>
    <div class="post-header">
        <div class="profile">
            <div class="avatar">
                <img class="avatar-img" :src="userInfo.avatarUrl">
            </div>
            <div class="account">
                <a class="account-name">{{userInfo.username}}</a>
                <a class="account-login" :href="userInfo.accountUrl">{{userInfo.login}}</a>
            </div>
        </div>
        <a class="service-img instagram" :href="userInfo.postUrl">
            <i class="fab fa-instagram"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "InstagramHeader",
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

    .post-header {
        display: flex;
        justify-content: space-between;
        padding: 10px 15px;
    }

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

    .avatar-img{
        width: 32px;
        height: 32px;
        overflow: hidden;
        border-radius: 50%;
    }

    .avatar{
        margin-right: 7px;
    }

    .account{
        display: flex;
        flex-direction: column;
    }

    .account-name{
        font-weight: 500;
        color: #000000;
    }

    .account-login{
        font-size: .8rem;
        margin-top: -6px;
        color: #000000;
        opacity: .6;
    }

    .account-login:hover,
    .account-login:focus{
        text-decoration: none;
        color: #2168F3;
    }
    .profile{
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .follow-card:hover .service-img.instagram{
        color: #F32159;
        opacity: .6;
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