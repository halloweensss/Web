<template>
    <div class="d-flex follow-card" :id = followUser.username>
        <div class="d-flex follow-card-margin">
            <InstagramFollowCard v-if="followUser.serviceName == 'instagram'" v-bind:profile-url="followUser.profileUrl"/>
            <TelegramFollowCard v-else-if="followUser.serviceName == 'telegram'" v-bind:profile-url="followUser.profileUrl"/>
            <a class="follow-nickname" :href="followUser.profileUrl">
                {{followUser.username}}
            </a>
            <FollowButton v-if="followUser.follow == false" v-bind:follow-user="followUser" v-on:follow-update="followUpdate"/>
            <UnfollowButton v-else-if="followUser.follow == true" v-bind:follow-user="followUser" v-on:unfollow-update="unfollowUpdate"/>
        </div>
    </div>
</template>

<script>
    import InstagramFollowCard from "./InstagramFollowCard";
    import TelegramFollowCard from "./TelegramFollowCard";
    import FollowButton from "./FollowButton";
    import UnfollowButton from "./UnfollowButton";
    export default {
        name: "FollowCard",
        components: {UnfollowButton, FollowButton, TelegramFollowCard, InstagramFollowCard},
        props:{
            followUser:{
                type: Object,
                required: true
            }
        },
        methods:{
            followUpdate(){
                this.$emit('follow-update');
            },
            unfollowUpdate(){
                this.$emit('unfollow-update');
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