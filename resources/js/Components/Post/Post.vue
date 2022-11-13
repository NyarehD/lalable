<template>
    <div
        class="border-x-[1px] border-b-[1px] border-gray-500/20 first-of-type:border-t-2 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl hover:cursor-pointer hover:bg-gray-200/60 transition-colors duration-300"
        @click.stop="goToPost">
        <PostProfile :post="post" />
        <div class="px-4 pb-3" v-if="post.description">
            <p class="text-lg">{{ post.description }}</p>
        </div>
        <img :src="post.post_photos[0].photo_src" class="h-80 md:h-[30rem] w-full object-cover"
             v-if="post.post_photos.length===1">
        <PhotoCarousel :photos="post.post_photos" v-if="post.post_photos.length>1" />
        <PostReaction :post-id="post.id" :total-likes="post.total_likes_count" :user-liked="post.user_liked" />
    </div>
</template>
<script setup>
    import PhotoCarousel from "@/Components/PhotoCarousel.vue";
    import PostProfile from "@/Components/Post/PostProfile.vue";
    import PostReaction from "@/Components/Post/PostReaction.vue";
    import { Inertia } from "@inertiajs/inertia";

    const props = defineProps({
        post: Object,
    });

    function goToPost() {
        Inertia.visit(route("post.show", { id: props.post.id }), { preserveScroll: true });
    }
</script>
