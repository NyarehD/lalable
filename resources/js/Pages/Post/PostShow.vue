<template>
    <!--    Do not search for solutions for overflowing in this page. That overflow is caused by laravel debug bar by adding margin-bottom: 3px to body-->
    <template v-if="post.post_photos.length > 0">
        <div class="md:flex-row bg dark:bg-neutral-800 relative flex flex-col max-h-screen overflow-hidden">
            <div class="md:w-7/12 lg:w-2/3" v-if="post.post_photos.length > 1">
                <PhotoCarousel :photos="post.post_photos" :is-full-height="true" v-show="true" />
            </div>
            <div class="md:w-7/12 lg:w-2/3" v-else>
                <img :src="post.post_photos[0]?.photo_src" alt="" class="object-contain h-screen mx-auto">
            </div>
            <div
                class="border-l-[1px] dark:border-neutral-200/20 border-inherit max-h-screen flex flex-col md:w-5/12 lg:w-1/3 rounded-r-3xl dark:text-white">
                <PostProfile :post="post" />
                <div class="px-4 pb-3" v-if="post.description">
                    <p class="text-lg">{{ post.description }}</p>
                </div>
                <PostReaction :post-id="post.id" :total-likes="post.total_likes_count" :user-liked="post.user_liked" />
                <CommentSection :post-id="post.id" :comments="post.comments" class="flex-grow overflow-auto" />
            </div>
            <PrimaryBtn type="text" class="top-3 left-3 dark:text-white absolute p-1 text-indigo-500" @click="goToNewsFeed">
                <XMark />
            </PrimaryBtn>
        </div>
    </template>
    <template v-else>
        <PageLayout>
            <div class="max-w-2xl min-h-screen px-2 mx-auto">
                <Post :post="post" />
            </div>
        </PageLayout>
    </template>
</template>

<script setup lang="ts">
    import CommentSection from "@/Components/Comment/CommentSection.vue";
    import XMark from "@/Components/Icons/XMark.vue";
    import PhotoCarousel from "@/Components/PhotoCarousel.vue";
    import Post from "@/Components/Post/Post.vue";
    import PostProfile from "@/Components/Post/PostProfile.vue";
    import PostReaction from "@/Components/Post/PostReaction.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import PageLayout from "@/Layouts/PageLayout.vue";
    import Comment from "@/Types/comment.type";
    import { default as PostType } from "@/Types/post.type";
    import { router } from "@inertiajs/vue3";

    defineProps<{
        post: Partial<PostType> & {
            comments: Comment[]
        }
    }>()
    function goToNewsFeed() {
        router.visit("/", { preserveScroll: true, replace: true });
    }
</script>
<style scoped></style>
