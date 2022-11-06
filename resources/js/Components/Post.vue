<template>
    <div
        class="border-x-2 border-b-2 border-gray-500/50 first-of-type:border-t-2 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl">
        <div class="grid grid-cols-2" v-if="post.post_photos.length>0">
            <img :src="photo.full_image_path" v-for="photo in post.post_photos"
                 class="h-[20rem] w-full object-cover rounded-b-none first-of-type:rounded-l-3xl last-of-type:rounded-r-3xl "
                 alt=" img">
        </div>
        <div class="p-4" v-if="post.description">
            <p>{{ post.description }}</p>
        </div>
    </div>
</template>
<script setup>
    defineProps({
        post: Object,
    });
</script>
