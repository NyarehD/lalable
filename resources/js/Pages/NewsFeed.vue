<template>
    <div class="max-w-2xl px-2 mx-auto">
        <Post v-for="(post, i) in $props.posts" :post="post" :key="`${post.id}post${i}`" v-memo="[post.user_liked_count]" />
    </div>
    <TextToast :text="$page.props.message" :duration="1000" />
</template>
<script setup lang="ts">
    import Post from "@/Components/Post/Post.vue";
    import TextToast from "@/Components/TextToast.vue";

    const props = defineProps<{
        posts: any[],
    }>();
</script>
<script lang="ts">
    import PageLayout from "../Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
