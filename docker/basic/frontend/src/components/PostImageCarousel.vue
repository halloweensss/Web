<template>
    <b-carousel-slide>
        <template v-slot:img>
            <img class="post-body-content-center" :src="imageUrl">
        </template>
    </b-carousel-slide>
</template>

<script>
    export default {
        name: "PostImageCarousel",
        props: {
            imageUrl: {
                type: String,
                required: true
            }
        }
    }
</script>