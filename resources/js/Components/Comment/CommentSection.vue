<template>
    <div class="flex flex-col">
        <div class="flex justify-between gap-2 px-4 py-3 grow-0">
            <img :src="user.full_image_path" alt="" class="h-auto rounded-full w-11 ">
            <TextInput class="w-full " v-model="comment" @keydown.enter="commentPost" />
            <PrimaryBtn @click.prevent="commentPost" type="primary">Comment</PrimaryBtn>
        </div>
        <div class="px-4 py-3 overflow-auto" v-memo>
            <SingleComment v-for="comment in comments" :key="`comments${comment.id}`" :comment="comment" />
        </div>
    </div>
</template>

<script setup>
    import { computed, ref } from "vue";
    import { usePage } from "@inertiajs/vue3";
    import TextInput from "@/Components/TextInput.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import { router } from "@inertiajs/vue3";
    import SingleComment from "@/Components/Comment/SingleComment.vue";

    const comment = ref("");

    const { comments, postId } = defineProps({
        comments: Object,
        postId: Number,
    });
    const user = computed(() => usePage().props.auth.user);

    function commentPost() {
        router.post(route("comment.store"), {
            "comment": comment.value,
            "post_id": postId,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                comment.value = "";
            },
        });
    }
</script>
