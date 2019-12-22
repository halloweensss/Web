<template>
    <b-carousel
            id="carousel-1"
            controls
            indicators
            :interval="0"
            background="#ffffff"
            style="text-shadow: 1px 1px 2px #333;"
            @sliding-end="onSlideEnd"
    >
        <PostImageCarousel v-for="(imageUrl,index) in userInfo.imageUrl" :key="'image' + index" v-bind:image-url="imageUrl"/>
    </b-carousel>
</template>

<script>
    import PostImageCarousel from "./PostImageCarousel";
    export default {
        name: "MultipleContent",
        components: {PostImageCarousel},
        props:{
            userInfo:{
                type: Object,
                required: true
            }
        },
        methods: {
            onSlideEnd() {
                if (typeof this.$redrawVueMasonry === 'function') {
                    this.$redrawVueMasonry()
                }
            }
        }
    }
</script>