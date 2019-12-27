<template>
    <div class="margin-button">
        <button class="btn btn-primary follow-button" type="button"  @click="acceptFollow">Подписаться</button>
        <button class="btn btn-primary follow-button min" type="button"  @click="acceptFollow"><i class="fas fa-check"></i></button>
    </div>
</template>

<script>
    import HTTP from "../components/http";
    export default {
        name: "FollowButton",
        props: {
            followUser: {
                type: Object,
                required: true
            }
        }, methods: {
            getCookie(name){
                var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
                if ( results )
                    return ( unescape ( results[2] ) );
                else
                    return null;
            },
            acceptFollow() {
                HTTP.post('/user/follow', {
                    accessToken: this.getCookie('accessToken'),
                    id: this.followUser.id,
                    username: this.followUser.username,
                    serviceName: this.followUser.serviceName,
                    profileUrl: this.followUser.profileUrl
                }).then(
                    (response) => {
                        if (response.data.status == 'success') {
                            this.$router.update();
                        }
                    },
                    (error) => {
                        this.result = error.response.data;
                    }
                )
            },
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