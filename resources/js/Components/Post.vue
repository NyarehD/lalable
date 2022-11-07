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
        <img :src="post.post_photos[0].photo_src" class="max-h-[30rem] w-full object-cover" v-if="post.post_photos.length===1">
        <PhotoCarousel :photos="post.post_photos" v-if="post.post_photos.length>1" />
    </div>
</template>
<script setup>
    import PhotoCarousel from "@/Components/PhotoCarousel.vue";

    defineProps({
        post: Object,
    });
</script>
