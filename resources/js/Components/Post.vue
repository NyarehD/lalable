<template>
    <div
        class="border-x-[1px] border-b-[1px] border-gray-500/20 first-of-type:border-t-2 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl">
        <div class="flex p-4">
            <img :src="post.owner.full_image_path" :alt="post.owner.name" class="w-12 h-12 rounded-full">
            <div class="ml-3">
                <p class="font-semibold"> {{ post.owner.name }}</p>
                <p>{{ post.for_humans }}</p>
            </div>
        </div>
        <div class="px-4 pb-1" v-if="post.description">
            <p class="text-lg">{{ post.description }}</p>
        </div>
        <div class="grid grid-cols-2" v-if="post.post_photos.length>0">
            <img :src="photo.photo_src" v-for="photo in post.post_photos"
                 class="h-[20rem] w-full object-cover"
                 alt=" img">
        </div>
    </div>
</template>
<script setup>
    defineProps({
        post: Object,
    });
</script>
