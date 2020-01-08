<template>
    <div class="margin-button">
        <button class="btn btn-danger follow-button" type="button" @mousedown="acceptUnfollow" >Отписаться</button>
        <button class="btn btn-danger follow-button min" type="button" @mousedown="acceptUnfollow"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
</template>

<script>
    import HTTP from "../components/http";
    export default {
        name: "UnfollowButton",
        props:{
            followUser:{
                type: Object,
                required: true
            }
        },
        methods: {
            getCookie(name){
                var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
                if ( results )
                    return ( unescape ( results[2] ) );
                else
                    return null;
            },
            acceptUnfollow() {
                HTTP.post('/user/unfollow', {
                    accessToken: this.getCookie('accessToken'),
                    id: this.followUser.id,
                    serviceName: this.followUser.serviceName
                }).then(
                    (response) => {
                        if (response.data.status == 'success') {
                            this.$emit('unfollow-update');
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