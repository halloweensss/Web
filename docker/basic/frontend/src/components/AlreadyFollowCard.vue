<template>
    <div class="d-flex follow-card">
        <div class="d-flex follow-card-margin">
            <InstagramFollowCard v-if="alreadyFollowUser.serviceName == 'instagram'" v-bind:profile-url="alreadyFollowUser.profileUrl"/>
            <TelegramFollowCard v-else-if="alreadyFollowUser.serviceName == 'telegram'" v-bind:profile-url="alreadyFollowUser.profileUrl"/>
            <a class="follow-nickname" :href="alreadyFollowUser.profileUrl">
                {{alreadyFollowUser.username}}
            </a>
            <UnfollowButton v-if="alreadyFollowUser.username.length > 0" v-bind:follow-user="alreadyFollowUser"/>
        </div>
    </div>
</template>

<script>
    import TelegramFollowCard from "./TelegramFollowCard";
    import InstagramFollowCard from "./InstagramFollowCard";
    import UnfollowButton from "./UnfollowButton";
    export default {
        name: "AlreadyFollowCard",
        components: {UnfollowButton, InstagramFollowCard, TelegramFollowCard},
        props:{
            alreadyFollowUser:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

    .follow-nickname{
        color: black;
        max-width: 50vw;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: auto 20px;
        font-weight: 500;
        font-size: 16px;
        opacity: .6;
    }


    .follow-nickname:hover,
    .follow-nickname:focus{
        color: #2168F3;
        text-decoration: none;

    }

    .follow-card{
        width: 100%;
    }

    .follow-card:hover{
        background-color: #E0E6FF;
    }

    .follow-card:hover .follow-nickname{
        color: #2168F3;
        text-decoration: none;
    }

    .follow-card-margin{
        width: 100%;
        margin: 10px 40px;
    }


    @media only screen and (max-width : 768px) {
        .follow-nickname {
            max-width: 43vw;
        }
        .follow-card-margin{
            width: 100%;
            margin: 10px 10px;
        }
    }

    @media only screen and (max-width : 400px) {
        .follow-nickname {
            max-width: 34vw;
        }
    }


    @media only screen and (max-width : 300px) {
        .follow-nickname {
            max-width: 30vw;
        }
    }

</style>