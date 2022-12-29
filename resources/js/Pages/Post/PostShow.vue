<template>
    <!--    Do not search for solutions for overflowing in this page. That overflow is caused by laravel debug bar by adding margin-bottom: 3px to body-->
    <template v-if="post.post_photos.length>0">
        <div class="flex flex-col md:flex-row overflow-hidden max-h-screen rounded-3xl relative">
            <div class="md:w-7/12 lg:w-2/3" v-if="post.post_photos.length>1">
                <PhotoCarousel :photos="post.post_photos" :is-full-height="true" v-show="true" />
            </div>
            <div class="md:w-7/12 lg:w-2/3" v-else>
                <img :src="post.post_photos[0]?.photo_src" alt="" class="object-contain h-screen mx-auto">
            </div>
            <div class="border-l-[1px] border-inherit md:w-5/12 lg:w-1/3 rounded-r-3xl max-h-screen overflow-auto">
                <PostProfile :post="post" />
                <div class="px-4 pb-3" v-if="post.description">
                    <p class="text-lg">{{ post.description }}</p>
                </div>
                <PostReaction :post-id="post.id" :total-likes="post.total_likes_count" :user-liked="post.user_liked" />
                <CommentSection :post-id="post.id" :comments="post.comments" />
            </div>
            <PrimaryBtn type="text" class="absolute top-3 left-3 p-1 text-indigo-500" @click="goToNewsFeed">
                <XMark />
            </PrimaryBtn>
        </div>
    </template>
    <template v-else>
        <PageLayout>
            <div class="max-w-2xl mx-auto px-2">
                <Post :post="post" />
            </div>
        </PageLayout>
    </template>
</template>

<script setup>
    import PostProfile from "@/Components/Post/PostProfile.vue";
    import PhotoCarousel from "@/Components/PhotoCarousel.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import PostReaction from "@/Components/Post/PostReaction.vue";
    import Post from "@/Components/Post/Post.vue";
    import XMark from "@/Components/Icons/XMark.vue";
    import { Inertia } from "@inertiajs/inertia";
    import PageLayout from "@/Layouts/PageLayout.vue";
    import CommentSection from "@/Components/CommentSection.vue";

    defineProps({
        post: Object,
    });

    function goToNewsFeed() {
        Inertia.visit("/", { preserveScroll: true, replace: true });
    }
</script>
<style scoped>

</style>
