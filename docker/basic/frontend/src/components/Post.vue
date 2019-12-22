<template>
    <div v-masonry-tile  class="grid-item col-xl-4 col-lg-6 col-md-6 col-sm-12 no-padding">
        <div class="post">
            <PostHeader v-bind:user-info="userInfo"/>
            <PostBody v-bind:user-info="userInfo"/>
            <hr>
            <PostFooter v-bind:user-info="userInfo"/>
        </div>
    </div>
</template>

<script>
    import PostHeader from "./PostHeader";
    import PostFooter from "./PostFooter";
    import PostBody from "./PostBody";
    export default {
        name: "Post",
        components: {PostBody, PostFooter, PostHeader},
        props:{
            userInfo:{
                type: Object,
                required: true
            }
        }
    }
</script>

<style scoped>

</style>