<template>
    <div class="flex py-3 px-4 justify-between">
        <div class="flex">
            <img :src="post.owner.full_image_path" :alt="post.owner.name" class="w-12 h-12 rounded-full">
            <div class="ml-3">
                <p class="font-semibold"> {{ post.owner.name }}</p>
                <p>{{ post.for_humans }}</p>
            </div>
        </div>
        <PostDropdown :post-id="post.id" :is-post-owner="post.can.is_post_owner"/>
    </div>
</template>
<script setup>
    import PostDropdown from "@/Components/Post/PostDropdown.vue";

    defineProps({
        post: Object,
    });

</script>
<style>
</style>
