<template>
    <div class="post-body">
        <div class="post-text">
            <p>
                {{userInfo.postText}}
            </p>
        </div>
        <div class="post-body-content">
            <SingleContent v-if="userInfo.imageUrl.length == 1" v-bind:user-info="userInfo"/>
            <MultipleContent v-else-if="userInfo.imageUrl.length > 1" v-bind:user-info="userInfo"/>
        </div>
    </div>
</template>

<script>
    import SingleContent from "./SingleContent";
    import MultipleContent from "./MultipleContent";
    export default {
        name: "PostBody",
        components: {MultipleContent, SingleContent},
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