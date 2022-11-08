<template>
    <div class="max-w-2xl mx-auto px-2">
        <Post v-for="(post,i) in posts" :post="post" :key="i" />
    </div>
</template>
<script setup>
    import Post from "@/Components/Post/Post.vue";

    defineProps({
        posts: Object,
    });
</script>
<script>
    import PageLayout from "../Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
