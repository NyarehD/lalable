<template>
    <div class="max-w-2xl px-2 mx-auto" v-memo>
        <Post v-for="(post) in posts" :post="post" :key="post.id" />
    </div>
    <TextToast :text="$page.props.message" />
</template>
<script setup>
    import Post from "@/Components/Post/Post.vue";
    import TextToast from "@/Components/TextToast.vue";
    
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
