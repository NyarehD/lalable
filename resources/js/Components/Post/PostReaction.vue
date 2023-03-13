<template>
    <div class="flex p-1.5 justify-around">
        <button
            class="dark:text-white/80 dark:hover:text-indigo-500 group hover:text-indigo-500 inline-flex items-center justify-center w-full font-semibold transition-colors duration-300 bg-transparent"
            :class="{ 'text-indigo-600': userLiked, 'text-gray-900/80': !userLiked }" @click.stop.prevent="toggleLike">
            <a
                class="group-hover:bg-indigo-200/80 dark:group-hover:bg-indigo-500/30 group-active:bg-indigo-300/80 p-2 mr-1 rounded-full">
                <LikeSolid v-if="userLiked" class="text-indigo-600" />
                <LikeOutline v-else />
            </a>
            {{ totalLikes }} {{ totalLikes > 1 ? "Likes" : "Like" }}
        </button>
        <button
            class="dark:text-white/80 dark:hover:text-indigo-500 text-gray-900/80 group hover:text-indigo-600 inline-flex items-center justify-center w-full font-semibold transition-colors duration-300 bg-transparent">
            <a
                class="group-hover:bg-indigo-200/80 dark:group-hover:bg-indigo-500/30 group-active:bg-indigo-300/80 p-2 mr-1 rounded-full">
                <CommentIcon class="" />
            </a>
            {{ totalComments }} {{ totalComments > 1 ? "Comments" : "Comment" }}
        </button>
        <button
            class="dark:text-white/80 dark:hover:text-indigo-500 text-gray-900/80 group hover:text-indigo-600 inline-flex items-center justify-center w-full font-semibold transition-colors duration-300 bg-transparent"
            @click.stop.prevent="sharePost">
            <a
                class="group-hover:bg-indigo-200/80 dark:group-hover:bg-indigo-500/30 group-active:bg-indigo-300/80 p-2 mr-1 rounded-full">
                <ShareIcon />
            </a>
            Share
        </button>
    </div>
</template>
<script setup>
    import CommentIcon from "@/Components/Icons/CommentIcon.vue";
    import LikeOutline from "@/Components/Icons/LikeOutline.vue";
    import LikeSolid from "@/Components/Icons/LikeSolid.vue";
    import ShareIcon from "@/Components/Icons/ShareIcon.vue";
    import { router } from "@inertiajs/vue3";

    const props = defineProps({
        postId: Number,
        totalLikes: Number,
        userLiked: Boolean,
        totalComments: Number
    });

    function toggleLike() {
        router.post(route(props.userLiked ? "post.unlike" : "post.like"), { "post_id": props.postId }, {
            preserveScroll: true,
            only: ["posts"]
        });
    }

    function sharePost() {
        router.post(route("post.share"), { "description": "alskdfj", "post_id": props.postId }, {
            preserveScroll: true,
        });
    }
</script>
