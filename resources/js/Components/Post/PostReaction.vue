<template>
    <div class="flex p-1.5 justify-between">
        <button
            class="inline-flex justify-center mx-auto items-center bg-transparent w-1/6 font-semibold group hover:text-indigo-500 transition-colors duration-300"
            :class="{'text-indigo-500':userLiked,'text-gray-900/80':!userLiked}"
            @click.stop.prevent="toggleLike">
            <a class="rounded-full group-hover:bg-indigo-200/80 group-active:bg-indigo-300/80 p-2 mr-1">
                <LikeSolid v-if="userLiked" class="text-indigo-500" />
                <LikeOutline v-else />
            </a>
            {{ totalLikes }} {{ totalLikes > 1 ? "Likes" : "Like" }}
        </button>
        <button
            class="inline-flex justify-center mx-auto items-center bg-transparent w-1/6 font-semibold text-gray-900/80 group hover:text-indigo-500 transition-colors duration-300">
            <a class="rounded-full group-hover:bg-indigo-200/80 group-active:bg-indigo-300/80 p-2 mr-1">
                <LikeOutline class="" />
            </a>
            Like
        </button>
        <button
            class="inline-flex justify-center mx-auto items-center bg-transparent w-1/6 font-semibold text-gray-900/80 group hover:text-indigo-500 transition-colors duration-300"
            @click.stop.prevent="sharePost">
            <a class="rounded-full group-hover:bg-indigo-200/80 group-active:bg-indigo-300/80 p-2 mr-1">
                <ShareIcon />
            </a>
            Share
        </button>
    </div>
</template>
<script setup>
    import LikeOutline from "@/Components/Icons/LikeOutline.vue";
    import LikeSolid from "@/Components/Icons/LikeSolid.vue";
    import ShareIcon from "@/Components/Icons/ShareIcon.vue";
    import { Inertia } from "@inertiajs/inertia";

    const props = defineProps({
        postId: Number,
        totalLikes: Number,
        userLiked: Boolean,
    });

    function toggleLike() {
        Inertia.post(route(props.userLiked ? "post.unlike" : "post.like"), { "post_id": props.postId }, {
            preserveScroll: true,
        });
    }

    function sharePost() {
        Inertia.post(route("post.share"), { "description": "alskdfj","post_id":props.postId }, {
            preserveScroll: true,
        });
    }
</script>
