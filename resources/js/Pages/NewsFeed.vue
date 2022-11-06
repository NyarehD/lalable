<template>
    <div class="max-w-2xl mx-auto">
        <Post v-for="post in posts" :post="post" />
    </div>
</template>
<script>
    import PageLayout from "../Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
<script setup>
    import Post from "@/Components/Post.vue";

    defineProps({
        posts: Object,
    });
</script>
